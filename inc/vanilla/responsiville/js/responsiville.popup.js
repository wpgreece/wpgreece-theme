/**
 * Creates and initialises the popup.
 * 
 * @class
 * @extends   Responsiville.Debug
 * @extends   Responsiville.Events
 * 
 * @author    Nevma, info@nevma.gr
 * @license   Nevma Copyright (c) http://www.nevma.gr
 * 
 * @fires     Responsiville.Popup#init
 * 
 * @classdesc A popup utility which takes a piece of HTML and shows it in a new
 *            layer on top of the rest of the contents of a web page.
 *
 * @param {Object} options The initialisation options of the module.
 * 
 * @property {Object}  options                The options that define the object
 *                                            behaviour.
 * @property {boolean} options.debug          Whether to print debug messages in
 *                                            the browser console.
 * @property {boolean} options.slug           A special codename for the
 *                                            instance of the element, to be
 *                                            used as a class on its container
 *                                            and as a key in arrays where it is
 *                                            grouped with other elements of its
 *                                            kind. 
 * @property {string}  options.activator      The selector of the element which
 *                                            acticates, that is opens, the
 *                                            popup. 
 * @property {string}  options.element        The element that holds the popup
 *                                            contents. Usually stays hidden
 *                                            somewhere inside the page.
 * @property {string}  options.contents       The HTML with the popup contents,
 *                                            if the element property is not
 *                                            set.
 * @property {string}  options.layerEffect    The effect of the background layer
 *                                            opening.
 * @property {int}     options.layerDelay     The delay before the background
 *                                            layer opens and closes.
 * @property {int}     options.layerDuration  The duration of the background
 *                                            layer effect.
 * @property {string}  options.popupEffect    The effect of the popup contents
 *                                            opening.
 * @property {int}     options.popupDelay     The delay before the popup
 *                                            contents open and close.
 * @property {int}     options.popupDuration  The duration of the popup contents
 *                                            effect.
 * @property {string}  options.popupDuration  The duration of the popup contents
 *                                            effect.
 * @property {int}     options.resizeDelay    The delay before the popup resize
 *                                            action occurs.
 * @property {int}     options.resizeDuration The duration of the popup resize
 *                                            action.
 * @property {int}     options.width          The desired width of the popup in
 *                                            px, vh, vw, %.
 * @property {int}     options.height         The desired height of the popup in
 *                                            px, vh, vw, %.
 * @property {int}     options.maxWidth       The desired max width of the popup
 *                                            in px, vh, vw, %.
 * @property {int}     options.maxHeight      The desired max height of the
 *                                            popup in px, vh, vw, %.
 * @property {int}     options.minWidth       The desired min width of the popup
 *                                            in px, vh, vw, %.
 * @property {int}     options.minHeight      The desired min height of the
 *                                            popup in px, vh, vw, %.
 * @property {boolean} options.overflow       If set to false, the default, the
 *                                            popup respects the max width and
 *                                            height properties and allows for
 *                                            internal overflow scroll. If set
 *                                            to true then the popup can stretch
 *                                            its contents further from the max
 *                                            width and height and cause the
 *                                            page to overflow scroll instead.
 *                                            Useful when you know that you are
 *                                            going to have long contents. 
 * @property {string}  options.closePosition  Whether the popup close button
 *                                            will be positioned in the popup or
 *                                            out of it.
 * @property {int}     options.startZIndex    The z-index from which the popup
 *                                            should beging its layout and be
 *                                            safely visible on top of
 *                                            everything else.
 * @property {string}  options.enter          Comma separated list of
 *                                            breakpoints in which the popup
 *                                            enters, wihch means it is enabled.
 * @property {string}  options.leave          Comma separated list of
 *                                            breakpoints in which the popup
 *                                            leaves, which means it is
 *                                            disabled.
 */

Responsiville.Popup = function ( options ) {

    // Responsiville must be initialised.

    if ( ! Responsiville.Main.getInstance() ) {

        throw new Error( 'Responsiville instantiation error: the framework has not been initialised, call new Responsiville::Main() and then Responsiville::init().' );

    }



    // General settings setup.
    
    this.options       = {};
    this.options       = jQuery.extend( this.options, Responsiville.Popup.defaults, options );
    this.codeName      = 'responsiville.popup';
    this.responsiville = Responsiville.Main.getInstance();
    
    this.contents      = null;
    this.enabled       = false;
    this.open          = false;

    

    // Cache important DOM elements.

    this.$body            = this.responsiville.$body;
    this.$document        = this.responsiville.$document;
    this.$window          = this.responsiville.$window;

    this.$close           = null;
    this.$contentsWrapper = null;
    this.$contents        = null;
    this.$contentsInner   = null;

    this.$activator       = jQuery();



    // Check if a popup activator has been given. 

    if ( typeof options.activator != 'undefined' ) {

        // Activator element that opens the popup.

        this.$activator = jQuery( this.options.activator );

        // If no activator found raise an error.
    
        if ( this.$activator.length === 0 ) {

            this.log( 'Responsiville.Popup instantiation error: no activator found (' + this.options.activator + ').' );
            return;

        }

        // Check for developer settings inside main element's data attributes.

        for ( var key in this.options ) {

            var value = this.$activator.data( 'responsiville-popup-' + key.toLowerCase() );

            if ( typeof value !== 'undefined' ) {
                this.options[key] = value;
            }

        }

        // Add this object as a main element's data attribute for API usage.
        
        this.$activator.data( 'responsiville-api', this );
        this.$activator.data( 'responsiville-popup-api', this );

    }



    // Uniquely identify this element.
    
    if ( this.options.slug == '' ) {
        Responsiville.Popup.elementsCounter = Responsiville.Popup.elementsCounter !== undefined ? ++Responsiville.Popup.elementsCounter : 0;
        this.options.slug = this.codeName.replace( '.', '-' ) + '-' + Responsiville.Popup.elementsCounter;
    }

    if ( this.$activator.length > 0 ) {
        this.$activator.addClass( this.options.slug );
    }



    // Take special care for enter/leave breakpoints possibly given as HTML data attributes.

    if ( this.$activator.length > 0 ) {
        
        var htmlBreakpoints = Responsiville.determineEnableDisableBreakpoints({ 
            enter: this.$activator.data( 'responsiville-popup-enter' ),
            leave: this.$activator.data( 'responsiville-popup-leave' ) 
        });

        if ( htmlBreakpoints !== null ) {
            this.options.enter = htmlBreakpoints.enter;
            this.options.leave = htmlBreakpoints.leave;
        }

    }



    // Prepare helper HTML elements. 

    this.initHTML();

    // Setup initial popup contents.

    this.initContents();

    // Initialises the popup.
    
    this.setupEvents();

    this.log( 'popup initialised' );



    /**
     * Called after the popup has been created.
     * 
     * @event Responsiville.Popup#init
     */

    this.fireEvent( 'init' );

};



// Extend with logging functions.

Responsiville.extend( Responsiville.Popup, Responsiville.Debug.Extensions );

// Extend with event handling mechanism.

Responsiville.extend( Responsiville.Popup, Responsiville.Events );



/**
 * @property {boolean} AUTO_RUN Controls whether this module should run by 
 *                              default, without the developer calling it, using
 *                              its default settings. Defaults to true.
 */

Responsiville.Popup.AUTO_RUN = typeof RESPONSIVILLE_AUTO_INIT !== 'undefined' ? RESPONSIVILLE_AUTO_INIT : true;



/**
 * @property {Object} defaults Default values for this module settings.
 */

Responsiville.Popup.defaults = {
    debug           : false,
    slug            : '',
    activator       : '.responsiville-popup-activator',
    element         : false,
    contents        : false,
    layerEffect     : 'fade',
    layerDelay      : 50, 
    layerDuration   : 100,
    popupEffect     : 'fade',
    popupDelay      : 200, 
    popupDuration   : 300,
    resizeDelay     : 100, 
    resizeDuration  : 200,
    width           : false,
    height          : false,
    maxWidth        : '60vw',
    maxHeight       : '90vh',
    minWidth        : '25vw',
    minHeight       : false,
    overflow        : false,
    closePosition   : 'out',
    closeTitle      : 'Close popup',
    startZIndex     : 9999,
    enter           : 'small, mobile, tablet, laptop, desktop, large, xlarge',
    leave           : ''
};



/**
 * Runs through the page and searches for elements that apply to the current 
 * module in order to apply it to them automatically. Useful for automatically
 * creating elements with this module's behaviour just by setting up the
 * predefined classes and data attributes in HTML elements of the page.
 *
 * @function
 * @static
 * 
 * @return {void}
 */

Responsiville.Popup.autoRun = function () {

    jQuery( Responsiville.Popup.defaults.activator ).each( function () {

        new Responsiville.Popup({
            debug     : Responsiville.Main.getInstance().options.debug,
            activator : this
        });
        
    });

};



/**
 * Sets up the necessary helper HTML elements for the function of the popup.
 */

Responsiville.Popup.prototype.initHTML = function () {

    // Create popup contents wrapper. 

    this.$contentsWrapper = jQuery( '<div class = "responsiville-popup-contents-wrapper ' + this.options.slug + '"/>' ).appendTo( this.$body );

    if ( this.options.overflow ) {
        this.$contentsWrapper.addClass( 'responsiville-popup-overflow' );
    }

    

    // Create popup contents. 

    this.$contents = jQuery( '<div class = "responsiville-popup-contents"/>' ).appendTo( this.$contentsWrapper );



    // Create popup contents inner container.

    this.$contentsInner = jQuery( '<div class = "responsiville-popup-contents-inner"/>' ).appendTo( this.$contents );

    

    // Create close button. 

    this.$close = jQuery( '<button class = "responsiville-popup-close" title = "' + this.options.closeTitle + '"><span>Close</span></button>' );

    if ( this.options.closePosition == 'out' ) {

        this.$contentsWrapper.addClass( 'responsiville-popup-close-out' );
        this.$close.appendTo( this.$contentsWrapper );

    } else {

        this.$contentsWrapper.addClass( 'responsiville-popup-close-in' );
        this.$close.appendTo( this.$contents );

    }

};



/**
 * Inittialises the contents of the popup based on the given options.
 */

Responsiville.Popup.prototype.initContents = function () {

    if ( this.$activator.length > 0 ) {

        // The activator was given and it points to the popup contents.
        var href = this.$activator.attr( 'href' );

        if ( href ) {

            // Either is an anchor with an href pointing to the popup contents. 
            this.setContents( jQuery( href ) );

        } else {
            
            // Or it is an element with the element data attribute pointing to the popup contents.
            this.setContents( jQuery( this.options.element ) );

        }

    } else {

        // The contents option contains the actual popup contents.
        this.setContents( this.options.contents );

    }

};



/**
 * Sets up event handlers necessary for the object to function properly. 
 * 
 * @return {void}
 */

Responsiville.Popup.prototype.setupEvents = function () {

    var k, length;

    // Register to be enabled on the required breakpoints.
    
    var breakpointsEnter = Responsiville.splitAndTrim( this.options.enter );

    for ( k=0, length=breakpointsEnter.length; k<length; k++ ) {
        this.responsiville.on( 'enter.' + breakpointsEnter[k], this.getBoundFunction( this.enable ) );
    }

    // Register to be disabled on the required breakpoints.

    var breakpointsLeave = Responsiville.splitAndTrim( this.options.leave );

    for ( k=0, length=breakpointsLeave.length; k<length; k++ ) {
        this.responsiville.on( 'enter.' + breakpointsLeave[k], this.getBoundFunction( this.disable ) );
    }

    // Enable right away if necessary.
    
    if ( this.responsiville.is( this.options.enter ) ) {
        this.enable();
    }

};



/**
 * Enables the popup. It does not activate it. It simply enables it, so when the
 * necessary trigger is fired then the popup opens/closes. Useful in responsive
 * design where the popup might be a required feature in desktops but useless
 * in mobile devices. By default a popup is always enabled.
 * 
 * @return {void}
 */

Responsiville.Popup.prototype.enable = function () {

    if ( this.enabled ) {
        return;
    }

    this.log( 'enable popup' );

    if ( this.$activator.length > 0 ) {
        this.$activator.on( 'click', this.getBoundFunction( this.openPopup ) );
    }

    this.$contentsWrapper.on( 'click', this.getBoundFunction( this.closePopup ) );
    this.$contents.on( 'click', this.getBoundFunction( this.contentsClick ) );
    this.$close.on( 'click', this.getBoundFunction( this.closePopup ) );
    this.$document.on( 'keydown', this.getBoundFunction( this.documentKeyDown ) );
    this.responsiville.on( 'resize', this.getBoundFunction( this.resize ) );

    this.enabled = true;

};



/**
 * Disables the popup. It does not deactivate it. It simply disables it, so
 * it does not function any more when the necessary trigger is fired. Useful in
 * responsive design where the popup might be a required feature in desktops
 * but useless in mobile devices.
 * 
 * @return {void}
 */

Responsiville.Popup.prototype.disable = function () {

    if ( ! this.enabled ) {
        return;
    }

    this.log( 'disable popup' );

    this.enabled = false;

};



/**
 * Handles the click event on the popup contents in order to stop it from 
 * propagating behind the popup and towards the rest of the page.
 *
 * @param {Event} event The click event sent by the browser. 
 * 
 * @return {void}
 */

Responsiville.Popup.prototype.contentsClick = function ( event ) {

    event.stopPropagation();

};



/**
 * Handles keyboard events on the document level in order to close the popup
 * when the escape key is pressed.
 *
 * @param {Event} event The keyboard event sent by the browser. 
 * 
 * @return {void}
 */

Responsiville.Popup.prototype.documentKeyDown = function ( event ) {

    if ( ! this.open ) {
        return;
    }

    var ESCAPE_KEY_CODE = 27;

    var keyPressed = event.charCode || event.keyCode;

    if ( keyPressed == ESCAPE_KEY_CODE ) {
        this.closePopup();
    }

};



/**
 * Sets and updates the contents of the popup. Can be called either when the 
 * popup is open or when it is closed. If open then the popup will automatically
 * resize itseld appropriately. if the contents contain images then the popup
 * will watch them until they load  and then resize itself again. 
 *
 * @param {mixed} contents The new popup contents. Can be anything that makes 
 *                         sense, an HTML string, a DOM element or a set of 
 *                         jQuery elements. 
 *
 * @return {void}
 */

Responsiville.Popup.prototype.setContents = function ( contents ) {

    this.contents = contents;

    this.$contentsInner.html( jQuery( this.contents ).clone( true ) );

    this.$contentsInner.find( '.responsiville-popup-close-button' ).on( 'click', this.getBoundFunction( this.closePopup ) );

    if ( this.open ) {
        this.resize();
    }

    Responsiville.onImagesLoaded( this.$contentsInner.find( 'img' ).toArray(),
        {
            single: (function () {
                if ( this.open ) {
                    this.resize();
                }
            }).bind( this )
        }
    );

};



/**
 * Calculates the dimensions that the popup contents will need when they appear
 * in order for the popup to proactively grow to them in advance. It takes under
 * consideration both the contents themselves as well as limitations provided
 * by the given popup options that relate to its dimensions. 
 *
 * @return {object} An asspociative array with the calculated width and height
 *                  of the current popup contents. 
 */

Responsiville.Popup.prototype.calculateContentsDimensions = function () {

    // Create a temp element with the contents to work on.

    jQuery( '<div class = "responsiville-popup-calculate-dimensions ' + this.options.slug + '"/>' ).
        append( this.$contents.contents().clone() ).
        appendTo( this.$body );

    var $tempContents = jQuery( '.responsiville-popup-calculate-dimensions.' + this.options.slug );

    var availableWidth  = this.$body.outerWidth();
    var availableHeight = window.innerHeight;



    // Check if specific width has been given.

    if ( this.options.width ) {

        this.log( 'adjusting for set width' );
        $tempContents.css( 'width', this.options.width );

    }



    // Check if the max allowed width has been exceeded.

    if ( this.options.maxWidth ) {

        var currentWidth = $tempContents.outerWidth();
        $tempContents.css( 'width', this.options.maxWidth );
        var maxWidth  = $tempContents.outerWidth();

        if ( currentWidth > maxWidth ) {

            this.log( 'adjusting for max width' );
            $tempContents.css( 'width', this.options.maxWidth );

        } else {

            this.log( 'not adjusting for max width' );
            $tempContents.css( 'width', currentWidth );

        }

    } else {

        // Max width is the viewport width as a last resort.

        var currentWidth = $tempContents.outerWidth();
        $tempContents.css( 'width', availableWidth );
        var maxWidth  = $tempContents.outerWidth();

        if ( currentWidth < maxWidth ) {

            this.log( 'adjusting for viewport width' );
            $tempContents.css( 'width', availableWidth );

        } else {

            this.log( 'not adjusting for viewport width' );
            $tempContents.css( 'width', currentWidth );

        }

    }



    // Check if the max allowed height has been exceeded.

    if ( this.options.minWidth ) {

        var currentWidth  = $tempContents.outerWidth();
        
        $tempContents.css( 'width', this.options.minWidth );

        var minWidth  = $tempContents.outerWidth();

        if ( currentWidth < minWidth ) {

            this.log( 'adjusting for min width' );
            $tempContents.css( 'width', this.options.minWidth );

        } else {

            this.log( 'not adjusting for min width' );
            $tempContents.css( 'width', currentWidth );

        }

    }



    // Check if specific height has been given.

    if ( this.options.height ) {

        this.log( 'adjusting for set height' );
        $tempContents.css( 'height', this.options.height );

    }



    if ( ! this.options.overflow ) {

        // Check if the max allowed height has been exceeded.

        if ( this.options.maxHeight ) {

            var currentHeight = $tempContents.outerHeight();
            $tempContents.css( 'height', this.options.maxHeight );
            var maxHeight = $tempContents.outerHeight();

            if ( currentHeight > maxHeight ) {
        
                this.log( 'adjusting for max height' );
                $tempContents.css( 'height', maxHeight );

            } else {

                this.log( 'not adjusting for max height' );
                $tempContents.css( 'height', currentHeight );

            }

        } else {

            // Check if viewport height has been exceeded.

            var currentHeight = $tempContents.outerHeight();
            $tempContents.css( 'height', availableHeight );
            var maxHeight = $tempContents.outerHeight();

            if ( currentHeight > maxHeight ) {

                this.log( 'adjusting for viewport height' );
                $tempContents.css( 'height', maxHeight );

            } else {

                this.log( 'not adjusting for viewport height' );
                $tempContents.css( 'height', currentHeight );

            }

        }

    }



    // Check if the min allowed height has been exceeded.

    if ( this.options.minHeight ) {

        var currentHeight = $tempContents.outerHeight();
        $tempContents.css( 'height', this.options.minHeight );
        var minHeight = $tempContents.outerHeight();

        if ( currentHeight < minHeight ) {

            this.log( 'adjusting for min height' );
            $tempContents.css( 'height', minHeight );

        } else {
            
            this.log( 'not adjusting for min height' );
            $tempContents.css( 'height', currentHeight );

        }

    }



    // Get final temp element dimensions.

    var dimensions = {
        width  : Math.ceil( $tempContents.outerWidth() ), 
        height : Math.ceil( $tempContents.outerHeight() )
    }

    // Cleanup temporary contents element.

    $tempContents.remove();

    return dimensions;

};



/**
 * Wraps around the window.paresInt() function and returns zero (0) when the
 * given argument is not a number (NaN).
 * 
 * @param {Number} number The number to parse as an integer. 
 * 
 * @return {int} 
 */

Responsiville.Popup.prototype.parseInt = function ( number ) {

    var result = window.parseInt( number );

    if ( window.isNaN( result ) ) {
        return 0;
    } else {
        return result;
    }

}



/**
 * Shows the popup contents wrapper, the layer that contains the popup and makes
 * it stick above the rest of the page contents. 
 *
 * @param {Function} callback A function to execute after the popup contents
 *                            wrapper has finshed showing. 
 *
 * @return {void}
 */

Responsiville.Popup.prototype.showContentsWrapper = function ( callback ) {

    if ( this.options.layerEffect == 'fade' ) {

        this.$contents.css( 'opacity', 0 );

        this.$contentsWrapper.css({
            'opacity' : 0,
            'display' : 'block',
            'z-index' : this.options.startZIndex
        });

        this.$contentsWrapper.velocity(
            { opacity : 1 }, 
            {
                delay    : this.options.layerDelay,
                duration : this.options.layerDuration,
                complete : 
                    (function () {

                        if ( callback !== undefined ) {
                            callback();
                        }

                    }).bind( this )
            }
        );

    } else if ( this.options.layerEffect == 'none' ) {

        this.$contentsWrapper.
            css({
                'display' : 'block',
                'z-index' : this.options.startZIndex
            });

    }

};



/**
 * Hides the popup contents wrapper. 
 *
 * @param {Function} callback A function to execute after the popup contents
 *                            wrapper has finshed hiding. 
 *
 * @return {void}
 */

Responsiville.Popup.prototype.hideContentsWrapper = function ( callback ) {

    if ( this.options.layerEffect == 'fade' ) {

        this.$contentsWrapper.velocity(
            { opacity : 0 }, 
            {
                delay    : this.options.layerDelay,
                duration : this.options.layerDuration,
                complete : 
                    (function () {

                        this.$contentsWrapper.
                            css({ 
                                'display' : 'none',
                                'z-index' : -1 
                            });

                        if ( callback !== undefined ) {
                            callback();
                        }

                    }).bind( this )
            }
        );

    } else if ( this.options.layerEffect == 'none' ) {

        this.$contentsWrapper.
            css({ 
                'display' : 'none',
                'z-index' : -1 
            });

    }

};



/**
 * Re-arranges the popup, its layout position and dimensions to the screen as
 * its options dictate. It is called every time the popup contents change or the
 * window is resized or whenever the popup needs to update its view.
 *
 * @fires Responsiville.Popup#beforeResize
 * @fires Responsiville.Popup#resize
 *
 * @return {void}
 */

Responsiville.Popup.prototype.resize = function () {

    if ( ! this.open ) {
        return;
    }


    /**
     * Called before the popup starts opening.
     * 
     * @event Responsiville.Popup#beforeResize
     */

    this.fireEvent( 'beforeResize' );


  
    var dimensions = this.calculateContentsDimensions();

    this.$contents.addClass( 'responsiville-popup-resizing' );

    this.$contents.velocity( 'stop' ).velocity({
        width  : dimensions['width'],
        height : dimensions['height']
    }, {
        delay    : this.options.resizeDelay,
        duration : this.options.resizeDuration,
        complete : 
            (function () {

                this.$contents.removeClass( 'responsiville-popup-resizing' );

                /**
                 * Called before the popup starts opening.
                 * 
                 * @event Responsiville.Popup#resize
                 */

                this.fireEvent( 'resize' );

            }).bind( this )
    });

};



/**
 * Shows the popup contents, that is the actual popup contents container. 
 *
 * @param {Function} callback A function to execute after the popup contents
 *                            container has finshed showing. 
 *
 * @return {void}
 */

Responsiville.Popup.prototype.showContents = function ( callback ) {


    this.$contentsWrapper.css({
        'display' : 'block',
        'z-index' : this.options.startZIndex
    });

    if ( this.options.popupEffect == 'fade' ) {

        var dimensions = this.calculateContentsDimensions();

        if ( this.options.overflow ) {

            // Case where popup is allowed to grow bigger than the window height.

            this.$contents.css({
                'display'   : 'block',
                'position'  : 'relative',
                'top'       : 'auto',
                'left'      : '50%',
                'width'     : dimensions['width'],
                'height'    : dimensions['height'],
                'transform' : 'translateX(-50%)',
                'margin'    : '5rem 0'
            });

        } else {

            // Case where popup is contained inside the window height.

            this.$contents.css({
                'display'   : 'block',
                'position'  : 'fixed',
                'top'       : '50%',
                'left'      : '50%',
                'width'     : dimensions['width'],
                'height'    : dimensions['height'],
                'transform' : 'translateX(-50%) translateY(-50%)'
            });

        }

        this.$contents.velocity({
            opacity : [1, 0]
        }, {
            delay    : this.options.popupDelay,
            duration : this.options.popupDuration,
            complete : 
                (function () {

                    if ( callback !== undefined ) {
                        callback();
                    }

                }).bind( this )
        });

    } else if ( this.options.popupEffect == 'none' ) {

        this.$contents.css({
            'position'  : 'fixed',
            'top'       : '50%',
            'left'      : '50%',
            'transform' : 'translateX(-50%) translateY(-50%)'
        });
        
    }

};



/**
 * Hides the popup contents container. 
 *
 * @param {Function} callback A function to execute after the popup contents
 *                            container has finshed hiding. 
 *
 * @return {void}
 */

Responsiville.Popup.prototype.hideContents = function ( callback ) {

    if ( this.options.popupEffect == 'fade' ) {

        this.$contents.velocity({
            opacity : [0, 1]
        }, {
            delay    : this.options.popupDelay,
            duration : this.options.popupDuration,
            complete : 
                (function () {

                    this.$contents.css({
                        'display' : 'none'
                    });

                    if ( callback !== undefined ) {
                        callback();
                    }

                }).bind( this )
        });

    } else if ( this.options.popupEffect == 'none' ) {

        this.$contents.css({
            'display' : 'none'
        });

    }

};



/**
 * Opens the popup. First shows the popup contents wrapper and then the popup
 * contents container. 
 *
 * @fires Responsiville.Popup#opening
 * @fires Responsiville.Popup#open
 *
 * @return {void}
 */

Responsiville.Popup.prototype.openPopup = function () {

    if ( ! this.enabled ) {
        return;
    }

    this.log( 'open popup' );



    /**
     * Called before the popup starts opening.
     * 
     * @event Responsiville.Popup#opening
     */

    this.fireEvent( 'opening' );



    this.$body.addClass( 'responsiville-popup-body-open' );
    this.$contentsWrapper.addClass( 'responsiville-popup-open' );

    this.showContentsWrapper(( function () {

        this.showContents(( function () {

            this.open = true;
        
            /**
             * Called after the popup has been opened.
             * 
             * @event Responsiville.Popup#open
             */

            this.fireEvent( 'open' );
            
        }).bind( this ));
        
    }).bind( this ));

    return false;

};



/**
 * Closes the popup. First hides the popup contents container and then the popup
 * contents wrapper. 
 *
 * @fires Responsiville.Popup#closing
 * @fires Responsiville.Popup#close
 *
 * @return {void}
 */

Responsiville.Popup.prototype.closePopup = function () {

    if ( ! this.enabled ) {
        return;
    }

    this.log( 'close popup' );



    /**
     * Called before the popup starts closing.
     * 
     * @event Responsiville.Popup#closing
     */

    this.fireEvent( 'closing' );



    this.hideContents(( function () {
        
        this.hideContentsWrapper(( function () {
        
            this.open = false;
            this.$body.removeClass( 'responsiville-popup-body-open' );
            this.$contentsWrapper.removeClass( 'responsiville-popup-open' );

            /**
             * Called after the popup has been closed.
             * 
             * @event Responsiville.Popup#close
             */

            this.fireEvent( 'close' );
            
        }).bind( this ));

    }).bind( this ));


    return false;

};