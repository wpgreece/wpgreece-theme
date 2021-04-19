/**
 * The main Responsiville framework scope. It defines the scope and some general
 * usage important functions used throughout the framework in responsive web 
 * development.
 *
 * @namespace Responsiville
 */

var Responsiville = {};



/**
 * @property {String} VERSION The current version of the framework.
 */

Responsiville.VERSION = '1.5';



/**
 * @property {int} THROTTLE_DURATION The default throttle duration of the framework.
 */

Responsiville.THROTTLE_DURATION = 100;



/**
 * Extends a given function/class with the functions of a given namespace. The
 * given namespace has to contain proper functions designed to extend a
 * prototype, otherwise unexpected behaviour might occur.
 * 
 * @param {Object} prototype The function/class that is to be extended. Has to
 *                           be a class defining function.
 * @param {Object} namespace The namespace of functions which will extend the
 *                           given function/class prototype.
 *                           
 * @return {void}
 */

Responsiville.extend = function ( object, namespace ) {

    for ( var key in namespace ) {
        object.prototype[key] = namespace[key];
    }

};



/**
 * Takes a function and returns a version of it that, when called repeatedly, 
 * will not run more often than a given time threshold. This way the given 
 * function, when called repeatedly, is guaranteed to run, in the worst case, no
 * more often thant the given interval.
 *
 * @param {Function} theFunction The function to throttle.
 * @param {int}      threshold   The time threshold more often than which the 
 *                               given function to be throttled should not run.
 * @param {Object}   scope       The object scope in which the throttled 
 *                               function is required to run.
 *
 * @return {Function} The throttled function.
 */

Responsiville.throttle = function ( theFunction, threshold, scope ) {

    // Set a default throttle duration.
    
    if ( typeof threshold === 'undefined' ) {
        threshold = Responsiville.THROTTLE_DURATION;
    }

    

    // Time of last call of the function.

    var last = 0;
    var counter = -1;

    // Handler that controls the next execution of the function.

    var timeoutHandler = null;

    // Return a throttled function to use.

    return function () {

        // The context within which the function will be executed and the arguments to pass to it.

        var context = scope || this;
        var args    = arguments;

        // Check how much time has passed since the last call.

        var now = new Date().getTime();

        // Cancel previous scheduled execution.

        clearTimeout( timeoutHandler );

        if ( now - last < threshold ) {

            // Schedule a new execution.

            timeoutHandler = setTimeout( function () {

                last = now;
                theFunction.apply( context, args );

            }, threshold );

        } else {

            // Enough time has passed, time for an execution.

            last = now;
            theFunction.apply( context, args );

        }

    };

};



/**
 * Takes a function and returns a version of it that, when called repeatedly, 
 * its execution is postponed for at least as much as the given interval 
 * indicates. This means that, when called repeatedly, if the repetitions of its
 * calls are within the given interval with each other, the function will only
 * run once, in the end.
 *
 * @param {Function} theFunction The function to debounce.
 * @param {int}      delay       The time delay inside which the given function
 *                               should to be debounced should not be executed.
 * @param {Object}   scope       The object scope in which the debounced 
 *                               function is required to run.
 *
 * @return {Function} The throttled function.
 */

Responsiville.debounce = function ( theFunction, delay, scope ) {

    // Set a default debounce duration.

    if ( typeof delay === 'undefined' ) {
        delay = Responsiville.THROTTLE_DURATION;
    }



    // Handler that controls the next execution of the function.

    var timeoutHandler = null;

    // Returns a debounced function to use.

    return function () {

        // The context within which the function will be executed and the arguments to pass to it.

        var context = scope || this;
        var args    = arguments;

        // Cancel previous scheduled execution.

        clearTimeout( timeoutHandler );

        // And schedule a new one.

        timeoutHandler = setTimeout( function () {

            theFunction.apply( context, args );

        }, delay );

    };

};



/**
 * Takes a set of images, waits for all of them to completely load (or fail)
 * and executes the given function callback.
 * 
 * @param {Function} images    The images elements to watch.
 * @param {array}    callbacks Associative array of callback functions to call 
 *                             when each single and all images of the given 
 *                             array have finished loading. Can take a 'single"
 *                             and a 'full' callback function respectively.
 * 
 * @return {void}
 */

Responsiville.onImagesLoaded = function ( images, callbacks ) {

    var k, length, tempImage;



    // Put all images in a consistent temporary array.

    var tempImages = [];

    for ( k=0, length=images.length; k<length; k++ ) {

        var image = images[k];

        if ( typeof image === 'string' ) {

            tempImage = new Image();
            tempImage.src = image;
            tempImages.push( tempImage );

        } else {

            tempImages.push( image ); 

        }

    }



    // Setup load and fail event handlers for all images.

    var imagesLoadedCounter = 0;

    function imageLoaded ( event ) {

        imagesLoadedCounter++;

        if ( typeof callbacks['single'] != 'undefined' ) {
            callbacks['single']( event.target );
        }

        if ( imagesLoadedCounter == images.length ) {

            if ( typeof callbacks['full'] != 'undefined' ) {
                callbacks['full']( tempImages);
            }
            
        }

    }

    for ( k=0, length=tempImages.length; k<length; k++ ) {

        tempImage = tempImages[k];

        var $tempImage = jQuery( tempImage );
        $tempImage.on( 'load', imageLoaded );
        $tempImage.on( 'error', imageLoaded );

    }

};



/**
 * Checks whether a given IMG element is fully loaded.
 * 
 * @param {HTMLImageElement} image The IMG element to check.
 * 
 * @return {Boolean} Whether the given IMG element is fully loaded.
 */

Responsiville.hasImageLoaded = function ( image ) {

    return image.complete || image.readyState === 4;

};



/**
 * Takes an input and, if it is not an array, it first converts it to an array
 * by splitting it by the given separator, then takes each element of the
 * resulting array and removes the whitespace from its beginning and end and
 * returns that array. Only applies to strings or arrays of strings. Useful when
 * transforming an unknown input that might contain a single string, a comma
 * separated list of string or an array of strings to a trimmed array of
 * strings.
 *
 * @param {Array<string>|string} input The string to split and then trim or the
 *                                     array to simply trim its elements.
 * 
 * @return {Array<string>} The resulting array of trimmed strings.
 */

Responsiville.splitAndTrim = function ( input, separator ) {

    if ( typeof separator === 'undefined' ) {
        separator = ',';
    }

    var inputArray = jQuery.isArray( input ) ? input : input.split( separator );

    for ( var k = 0, length=inputArray.length; k < length; k++ ) {
        inputArray[k] = inputArray[k].replace( /^\s+|\s+$/, '' );
    }

    return inputArray;

};



/**
 * Takes a set of enter/leave values, as given in a Responsiville module's HTML
 * data attributes, and determines the exact actual breakpoints that the
 * developer implied. The enter/leave valuesmay contain either the breakpoint
 * names themselves or shortct names, like "*" (all breakpoints), "tablet >>" (
 * tablet and above), "<< laptop" (laptop and below), etc. 
 * 
 * @param  {object} breakpoints An object with an "enter" and a "leave" key 
 *                              string values which represent the enter and
 *                              leave values given in the Responsiville module's
 *                              HTML data attributes. Each of them may be
 *                              provided or left undefined. If both are
 *                              undefined then null is returned.
 * 
 * @return {object}             An object with an "enter" and a "leave" key 
 *                              string values which represent the final enter 
 *                              and leave values after they have been decoded
 *                              to cover all available breakpoints.
 */

Responsiville.determineEnableDisableBreakpoints = function ( breakpoints ) {

    // If both given breakpoints are empty then there is nothing to do.

    if ( ( breakpoints['enter'] === undefined || ! breakpoints['enter'] ) &&
         ( breakpoints['leave'] === undefined || ! breakpoints['leave'] ) ) {
        return null;
    }



    // Obtain the current page total breakpoints.
    
    var allBreakpoints = Responsiville.Main.getInstance().options.breakpoints;



    // If ll breakpoints are in enter property.
    
    if ( breakpoints['enter'] === '*' ) {

        var enter = '';

        for ( var k=0, length=allBreakpoints.length; k<length; k++ ) {
            enter += allBreakpoints[k].name + ( k<length-1 ? ', ' : '' );
        }

        return { 
            enter: enter, 
            leave: '' 
        };

    }



    // If all breakpoints are in leave property (pointless indeed, but keep it fo completeness).
    
    if ( breakpoints['leave'] === '*' ) {

        var leave = '';

        for ( var k=0, length=allBreakpoints.length; k<length; k++ ) {
            leave += allBreakpoints[k].name + ( k<length-1 ? ', ' : '' );
        }

        return { 
            enter: '', 
            leave: leave 
        };

    }



    // If enter contains some coded shortcut value.
    
    if ( breakpoints['enter'] !== undefined && breakpoints['enter'] ) {

        // A value which declares a breakpoint and above.

        if ( breakpoints['enter'].indexOf( '>>' ) > -1  ) {

            var enterSplit      = breakpoints['enter'].split( ' ' );
            var enterBreakpoint = enterSplit[0];

            var enterArray = [];
            var leaveArray = [];

            var includeBreakpointsFromHere = false;

            for ( var k=0, length=allBreakpoints.length; k<length; k++ ) {

                includeBreakpointsFromHere = includeBreakpointsFromHere || allBreakpoints[k].name == enterBreakpoint;
                
                if ( includeBreakpointsFromHere ) {
                    enterArray.push( allBreakpoints[k].name );
                } else {
                    leaveArray.push( allBreakpoints[k].name );
                }

            }

            return { 
                enter: enterArray.join( ', ' ), 
                leave: leaveArray.join( ', ' ) 
            };

        }

        // A value which declares a breakpoint and below.

        if ( breakpoints['enter'].indexOf( '<<' ) > -1  ) {

            var enterSplit      = breakpoints['enter'].split( ' ' );
            var enterBreakpoint = enterSplit[1];

            var enterArray = [];
            var leaveArray = [];

            var includeBreakpointsFromHere = false;

            for ( var k=allBreakpoints.length-1; k>=0; k-- ) {

                includeBreakpointsFromHere = includeBreakpointsFromHere || allBreakpoints[k].name == enterBreakpoint;
                
                if ( includeBreakpointsFromHere ) {
                    enterArray.push( allBreakpoints[k].name );
                } else {
                    leaveArray.push( allBreakpoints[k].name );
                }
                
            }

            return { 
                enter: enterArray.reverse().join( ', ' ), 
                leave: leaveArray.reverse().join( ', ' ) 
            };

        }

    }



    // If leave contains some coded shortcut value.
    
    if ( breakpoints['leave'] !== undefined && breakpoints['leave'] ) {

        // A value which declares a breakpoint and above.

        if ( breakpoints['leave'].indexOf( '>>' ) > -1  ) {

            var leaveSplit      = breakpoints['leave'].split( ' ' );
            var leaveBreakpoint = leaveSplit[0];

            var enterArray = [];
            var leaveArray = [];

            var includeBreakpointsFromHere = false;

            for ( var k=0, length=allBreakpoints.length; k<length; k++ ) {

                includeBreakpointsFromHere = includeBreakpointsFromHere || allBreakpoints[k].name == leaveBreakpoint;
                
                if ( includeBreakpointsFromHere ) {
                    leaveArray.push( allBreakpoints[k].name );
                } else {
                    enterArray.push( allBreakpoints[k].name );
                }

            }

            return { 
                enter: enterArray.join( ', ' ), 
                leave: leaveArray.join( ', ' ) 
            };

        }

        // A value which declares a breakpoint and below.

        if ( breakpoints['leave'].indexOf( '<<' ) > -1  ) {

            var leaveSplit      = breakpoints['leave'].split( ' ' );
            var leaveBreakpoint = leaveSplit[1];

            var enterArray = [];
            var leaveArray = [];

            var includeBreakpointsFromHere = false;

            for ( var k=allBreakpoints.length-1; k>=0; k-- ) {

                includeBreakpointsFromHere = includeBreakpointsFromHere || allBreakpoints[k].name == leaveBreakpoint;
                
                if ( includeBreakpointsFromHere ) {
                    leaveArray.push( allBreakpoints[k].name );
                } else {
                    enterArray.push( allBreakpoints[k].name );
                }
                
            }

            return { 
                enter: enterArray.reverse().join( ', ' ), 
                leave: leaveArray.reverse().join( ', ' ) 
            };

        }

    }
    



    // Break down given enter and leave parameters. 
    
    var breakpointsEnter = breakpoints['enter'] !== undefined && breakpoints['enter'] ? Responsiville.splitAndTrim( breakpoints['enter'] ) : undefined;
    var breakpointsLeave = breakpoints['leave'] !== undefined && breakpoints['leave'] ? Responsiville.splitAndTrim( breakpoints['leave'] ) : undefined;

    

    // If both of them are empty or invalid  then there is nothing left to do.

    if ( ( breakpointsEnter === undefined || ! breakpoints['enter'] ) &&
         ( breakpointsLeave === undefined || ! breakpoints['leave'] ) ) {
        return null;
    }

    

    // If enter is not given then deduct it as the remaining breakpoints of leave.
    
    if ( breakpointsEnter === undefined || ! breakpoints['enter'] ) {

        breakpointsEnter = [];

        for ( var k=0, length=allBreakpoints.length; k<length; k++ ) {

            var globalBreakpoint = allBreakpoints[k];

            if ( breakpointsLeave.indexOf( globalBreakpoint.name ) < 0 ) {
                breakpointsEnter.push( globalBreakpoint.name );
            }

        }

    }



    // If leave is not given then deduct it as the remaining breakpoints of enter.
    
    if ( breakpointsLeave === undefined || ! breakpoints['leave'] ) {

        breakpointsLeave = [];

        for ( var k=0, length=allBreakpoints.length; k<length; k++ ) {

            var globalBreakpoint = allBreakpoints[k];

            if ( breakpointsEnter.indexOf( globalBreakpoint.name ) < 0 ) {
                breakpointsLeave.push( globalBreakpoint.name );
            }

        }

    } 



    return { 
        enter: breakpointsEnter.join( ', ' ), 
        leave: breakpointsLeave.join( ', ' ) 
    };

};




/**
 * Takes an object and enhances with responsive behaviour.
 * 
 * @param {object} responsiveObject The object which is to be enhanced with
 *                                  responsive behaviour. It must contain 
 *                                  'enter' and/or 'leave' properties which 
 *                                  define the respective breakpoints in the
 *                                  same manner in which Responsiville elements
 *                                  do and an 'enable' and 'disable' callback
 *                                  functions which will be automatically
 *                                  invoked by the framework as per the given
 *                                  breakpoints. The given object will be
 *                                  enhanced with this responsive behaviour,
 *                                  thus it can still keep any other properties
 *                                  and previous behaviour it had. 
 * 
 * @return {object} The given object enhanced.
 */

Responsiville.createResponsiveObject = function ( responsiveObject ) {

    var responsiville = Responsiville.Main.getInstance();

    responsiveObject.responsiville = responsiville;



    // Determine enable and disable breakpoints.

    var breakpoints = Responsiville.determineEnableDisableBreakpoints({
        enter: typeof responsiveObject.enter !== 'undefined' ? responsiveObject.enter : 'undefined',
        leave: typeof responsiveObject.leave !== 'undefined' ? responsiveObject.leave : 'undefined'
    });

    // If both given breakpoints are empty then stop.
    
    if ( breakpoints === null ) {
        return responsiveObject;
    }

    console.dir( breakpoints );



    var k, length;

    // Register to be enabled on the required breakpoints.

    if ( typeof responsiveObject.enable !== 'undefined' ) {

        var enableFunctionBound = responsiveObject.enable.bind( responsiveObject );

        var breakpointsEnter = Responsiville.splitAndTrim( breakpoints.enter );

        for ( k=0, length=breakpointsEnter.length; k<length; k++ ) {
            responsiville.on( 'enter.' + breakpointsEnter[k], enableFunctionBound );
        }
        
        // Enable right away if necessary.
        
        if ( responsiville.is( breakpoints.enter ) ) {
            enableFunctionBound();
        }

    }

    // Register to be disabled on the required breakpoints.
    
    if ( typeof responsiveObject.disable !== 'undefined' ) {

        var disableFunctionBound = responsiveObject.disable.bind( responsiveObject );

        var breakpointsLeave = Responsiville.splitAndTrim( breakpoints.leave );

        for ( k=0, length=breakpointsLeave.length; k<length; k++ ) {
            responsiville.on( 'enter.' + breakpointsLeave[k], disableFunctionBound );
        }

        // Disable right away if necessary.
        
        if ( responsiville.is( breakpoints.leave ) ) {
            disableFunctionBound();
        }

    }



    return responsiveObject;

};