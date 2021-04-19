/**
 * Creates and initialises the parallax behaviour.
 * 
 * @class
 * @extends   Responsiville.Debug
 * @extends   Responsiville.Events
 * 
 * @author    Nevma, info@nevma.gr
 * @license   Nevma Copyright (c) http://www.nevma.gr
 * 
 * @fires     Responsiville.Parallax#init
 * 
 * @classdesc A parallax behaviour is materialised when an element is watched as
 *            the browser window scrolls by it and, either some property of the
 *            element itself or some other element is changed, in relation to
 *            the browser scroll events. Usually this behaviour starts to take
 *            effect when the watched element becomes visible in the browser
 *            viewport and is completed when the element leaves the browser
 *            viewport.
 *
 * @param {Object} options The initialisation options of the module.
 * 
 * @property {Object}  options              The options that define the object
 *                                          behaviour.
 * @property {boolean} options.debug        Whether to print debug messages in
 *                                          the browser console.
 * @property {boolean} options.slug         A special codename for the instance
 *                                          of the element, to be used as a
 *                                          class on its container and as a key
 *                                          in arrays  where it is grouped with
 *                                          other elements of its kind. 
 * @property {string}  options.watch        The element to watch. This is the 
 *                                          element which is watched by the
 *                                          module as it enters, crosses and
 *                                          eventually leaves the viewport. The
 *                                          parallax effect starts when the
 *                                          watched element enters the viewport
 *                                          and finishes when the watched
 *                                          element leaves the viewport.
 * @property {Object}  options.properties   In the case where the parallaxed
 *                                          element is the watched element
 *                                          itself this associative array
 *                                          represents the CSS properties of it
 *                                          that will be affected by the
 *                                          parallax effect and  their initial
 *                                          and final values.
 * @property {Object}  options.elements     In the case where the parallaxed
 *                                          element(s) are different from the 
 *                                          watched element this associative
 *                                          array represents these elements
 *                                          along with  their CSS properties
 *                                          which are to be affected by the
 *                                          parallax effect. It may be either a
 *                                          single element or an array of
 *                                          elements.
 * @property {integer} options.throttle     Duration in milliseconds to 
 *                                          throttle the scroll event, so that 
 *                                          the modulescroll callbacks are not 
 *                                          called on each and every browser 
 *                                          scroll event.
 * @property {integer} options.duration     The duration of the animation of 
 *                                          the transition of the CSS 
 *                                          properties that are to be 
 *                                          parallaxed.
 * @property {integer} options.offsetTop    How much to delay the parallax
 *                                          effect in terms of space, after the
 *                                          watched element has appeared in the 
 *                                          browser viewport.
 * @property {integer} options.offsetBottom How much to make completion faster
 *                                          in terms of space for the parallax
 *                                          effect.
 * @property {mixed} options.onAppear       Function callback to trigger or 
 *                                          class to add when the watched
 *                                          element appears in the browser
 *                                          viewport.
 * @property {mixed} options.onDisappear    Function callback to trigger or
 *                                          class to add when the watched
 *                                          element disappears from the browser
 *                                          viewport.
 * @property {boolean} options.runOnce      If true, then the what the parallax
 *                                          functionality will only run once as
 *                                          the user scrolls up and down the
 *                                          and will not be reversed or run
 *                                          again after it has completed.
 *                                          Defaults to false.
 * @property {string}  options.enter        Comma separated list of breakpoints
 *                                          in  which the parallax enters, 
 *                                          which means it is enabled.
 * @property {string}  options.leave        Comma separated list of breakpoints
 *                                          in which the parallax leaves, which
 *                                          means it is disabled.
 */

Responsiville.Parallax = function ( options ) {

    // Responsiville must be initialised.

    if ( ! Responsiville.Main.getInstance() ) {

        throw new Error( 'Responsiville instantiation error: the framework has not been initialised, call new Responsiville::Main() and then Responsiville::init().' );

    }



    // General settings setup.
    
    this.options       = {};
    this.options       = jQuery.extend( this.options, Responsiville.Parallax.defaults, options );
    this.codeName      = 'responsiville.parallax';
    this.responsiville = Responsiville.Main.getInstance();
    this.enabled       = false;

    

    // Cache important DOM elements.

    this.$body     = this.responsiville.$body;
    this.$document = this.responsiville.$document;
    this.$window   = this.responsiville.$window;
    this.$watched  = jQuery( this.options.watch );



    // Check for developer settings inside main element's data attributes.

    for ( var key in this.options ) {

        var value = this.$watched.data( 'responsiville-parallax-' + key.toLowerCase() );

        if ( typeof value !== 'undefined' ) {
            this.options[key] = value;
        }

    }

    // Uniqueue element slug.

    if ( this.options.slug == '' ) {
        Responsiville.Parallax.elementsCounter = Responsiville.Parallax.elementsCounter !== undefined ? ++Responsiville.Parallax.elementsCounter : 0;
        this.options.slug = this.codeName.replace( '.', '-' ) + '-' + Responsiville.Parallax.elementsCounter;
    }

    // Take special care for enter/leave breakpoints possibly given as HTML data attributes.
    
    var htmlBreakpoints = Responsiville.determineEnableDisableBreakpoints({ 
        enter: this.$watched.data( 'responsiville-parallax-enter' ),
        leave: this.$watched.data( 'responsiville-parallax-leave' ) 
    });

    if ( htmlBreakpoints !== null ) {
        this.options.enter = htmlBreakpoints.enter;
        this.options.leave = htmlBreakpoints.leave;
    }
    
    
    
    // If no parallax found raise an error.
    
    if ( this.$watched.length === 0 ) {

        this.log( 'Responsiville.Parallax instantiation error: no parallax elements found (' + this.options.element + ').' );
        return;

    }



    // Add this object as a main element's data attribute for API usage.
    
    this.$watched.data( 'responsiville-api', this );
    this.$watched.data( 'responsiville-parallax-api', this );



    // Cache elements to be affected by parallax effects and their respective properties. 
    
    this.$elements = []; 
    this.elementsProperties = [];

    if ( this.options.properties !== null ) {

        // Properties are given to be parallaxed on the watched element itself.
        
        this.$elements.push( this.$watched );
        this.elementsProperties.push( this.options.properties );

    } else {

        // Other elements (besides the watched one) and their properties might be given to be parallaxed.

        if ( ! jQuery.isArray( this.options.elements ) ) {

            this.$elements.push( jQuery( this.options.elements.element ) );
            this.elementsProperties.push( this.options.elements.properties );

        } else {

            for ( var k=0, length=this.options.elements.length; k<length; k++ ) {
                var $element = jQuery( this.options.elements[k]['element'] );
                if ( $element.length > 0 ) {
                    this.$elements.push( $element );
                    this.elementsProperties.push( this.options.elements[k]['properties'] );
                }
            }

        }

    }



    // Uniquely identify this element.
    
    this.$watched.addClass( this.options.slug );



    // Initialises the parallax.
    
    this.setupEvents();

    this.log( 'parallax initialised' );



    /**
     * Called after the parallax has been created.
     * 
     * @event Responsiville.Parallax#init
     */

    this.fireEvent( 'init' );

};



// Extend with logging functions.

Responsiville.extend( Responsiville.Parallax, Responsiville.Debug.Extensions );

// Extend with event handling mechanism.

Responsiville.extend( Responsiville.Parallax, Responsiville.Events );




/**
 * @property {boolean} AUTO_RUN Controls whether this module should run by 
 *                              default, without the developer calling it, using
 *                              its default settings. Defaults to true.
 */

Responsiville.Parallax.AUTO_RUN = typeof RESPONSIVILLE_AUTO_INIT !== 'undefined' ? RESPONSIVILLE_AUTO_INIT : true;



/**
 * @property {Object} defaults Default values for this module settings.
 */

Responsiville.Parallax.defaults = {
    debug        : false,
    slug         : '',
    watch        : '.responsiville-parallax',
    properties   : null,
    elements     : [],
    throttle     : 10,
    duration     : 10,
    offsetTop    : 0,
    offsetBottom : 0,
    onAppear     : null,
    onDisappear  : null,
    runOnce      : false,
    enter        : 'tablet, laptop, desktop, large, xlarge',
    leave        : 'small, mobile'
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

Responsiville.Parallax.autoRun = function () {

    jQuery( Responsiville.Parallax.defaults.watch ).each( function () {

        new Responsiville.Parallax({
            debug : Responsiville.Main.getInstance().options.debug,
            watch : this
        });
        
    });

};



/**
 * Sets up event handlers necessary for the object to function properly. 
 * 
 * @return {void}
 */

Responsiville.Parallax.prototype.setupEvents = function () {

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
 * Enables the parallax. It does not activate it. It simply enables it, so when
 * the necessary trigger is fired then the parallax behaviour begins. Useful in 
 * responsive design where the parallax might be a required feature in desktops 
 * but useless in mobile devices
 * .
 * @fires Responsiville.Parallax#enabled
 * 
 * @return {void}
 */

Responsiville.Parallax.prototype.enable = function () {

    if ( this.enabled ) {
        return;
    }

    this.log( 'enable parallax' );



    // Bind calculate function throttled.
    
    if ( ! this.throttledCalculate ) {
        this.throttledCalculate = Responsiville.throttle( this.calculate, this.options.throttle, this );
    }

    this.$window.on( 'scroll', this.throttledCalculate );
    this.$window.on( 'resize', this.throttledCalculate );


    
    // Bind scroll function throttled.
    
    if ( ! this.throttledScroll ) {
        this.throttledScroll = Responsiville.throttle( this.scroll, this.options.throttle, this );
    }
    
    this.$window.on( 'scroll', this.throttledScroll );
    this.$window.on( 'resize', this.throttledScroll );



    // Run calculate and scroll functions once in order to initialise parallax behaviour.

    this.calculate();
    this.scroll(); 



    this.enabled = true;

    /**
     * Called after the parallax scroll has been enabled.
     * 
     * @event Responsiville.Parallax#enabled
     */

    this.fireEvent( 'enabled' );

};



/**
 * Disables the parallax. It does not deactivate it. It simply disables it, so
 * it does not function any more when the necessary trigger is fired. Useful in
 * responsive design where the parallax might be a required feature in desktops
 * but useless in mobile devices.
 * 
 * @fires Responsiville.Parallax#disabled
 * 
 * @return {void}
 */

Responsiville.Parallax.prototype.disable = function () {

    if ( ! this.enabled ) {
        return;
    }

    this.log( 'disable parallax' );



    // Put all parallax element properties in their initial values.

    for ( var k=0, length=this.$elements.length; k<length; k++ ) {

        var $element            = this.$elements[k];
        var elementProperties   = this.elementsProperties[k];
        var animationProperties = {};
        
        for ( var propertyName in elementProperties ) {
            var propertyValues = elementProperties[propertyName];
            animationProperties[propertyName] = '' + propertyValues['from'] + propertyValues['unit'];
        }

        $element.velocity( animationProperties, { duration : 0 } );

    }

    

    // Unbind calculate function.
    
    if ( ! this.throttledCalculate ) {
        this.throttledCalculate = Responsiville.throttle( this.calculate, this.options.throttle, this );
    }

    this.$window.off( 'scroll', this.throttledCalculate );
    this.$window.off( 'resize', this.throttledCalculate );
    
    // Unbind scroll function.
    
    if ( ! this.throttledScroll ) {
        this.throttledScroll = Responsiville.throttle( this.scroll, this.options.throttle, this );
    }

    this.$window.off( 'scroll', this.throttledScroll );
    this.$window.off( 'resize', this.throttledScroll );



    this.enabled = false;

    /**
     * Called after the parallax scroll has been disabled.
     * 
     * @event Responsiville.Parallax#disabled
     */

    this.fireEvent( 'disabled' );

};



/**
 * Calculates viewport and watched element dimensions and whereabouts so it is
 * prepared to do calculations for the parallax effects.
 * 
 * @return {void}
 */

Responsiville.Parallax.prototype.calculate = function () {

    this.viewportHeight          = this.$window.height();
    this.watchedElementOffsetTop = this.offsetTopTotal( this.$watched.get( 0 ) );
    this.watchedElementHeight    = this.$watched.outerHeight();

};



/**
 * Calculates an element's total offsetTop distance, by recursively ascending to
 * all its posistioned parents up to the root element. This is specifically not
 * equivalent to jQuery's offset() function because that function takes into
 * account any CSS transforms that might have been set on the element.
 * 
 * @param  {Element} The element whose total offsetTop to calculate.
 * 
 * @return {int} The total offsetTop of the given element. 
 */

Responsiville.Parallax.prototype.offsetTopTotal = function ( element ) {

    var offsetTopTotal = this.$watched.get( 0 ).offsetTop;

    var parent = this.$watched.get( 0 ).offsetParent;

    while ( parent ) {

        offsetTopTotal += parent.offsetTop;
        parent = parent.offsetParent;

    }

    return offsetTopTotal;

};



/**
 * Runs on window scroll, when the parallax behaviour is enabled, and makes sure
 * that the parallax behaviour is materialised as dictated in the given 
 * initialisation settings.
 * 
 * @fires Responsiville.Parallax#scrolling
 * @fires Responsiville.Parallax#scrolled

 * @return {void}
 */

Responsiville.Parallax.prototype.scroll = function () {

    /**
     * Called before the parallax scroll runs.
     * 
     * @event Responsiville.Parallax#scrolling
     */

    this.fireEvent( 'scrolling' );



    // Calculate how much the parallax effect has progressed.

    var scrollTop                   = this.$window.scrollTop !== undefined ? this.$window.scrollTop() : this.$document.get( 0 ).documentElement.scrollTop;
    var scrollTopStart              = this.watchedElementOffsetTop - this.viewportHeight + this.options.offsetTop;
    var scrollTopEnd                = this.watchedElementOffsetTop + this.watchedElementHeight - this.options.offsetBottom;
    var parallaxPercentage          = (scrollTop - scrollTopStart) / (scrollTopEnd - scrollTopStart);
    var watchedElementIsOffViewport = scrollTop < this.watchedElementOffsetTop - this.viewportHeight       + this.options.offsetTop || 
                                      scrollTop > this.watchedElementOffsetTop + this.watchedElementHeight - this.options.offsetBottom;
    var watchedElementWasInViewport = this.$watched.data( 'in-viewport' );
    var hasRunOnce                  = this.$watched.data( 'has-run-once' );



    // Calculate scroll direction.

    if ( this.scrollTop === undefined ) {
        this.scrollTop = 0;
    }

    var scrollDifference = scrollTop - this.scrollTop;
    var direction = scrollDifference >= 0 ? 'down' : 'up';

    this.scrollTop = scrollTop;
    this.direction = direction;



    // Possibly call appear/disappear functions on watched element appear/disappear events.

    if ( ! watchedElementIsOffViewport ) {

        // Set and cache appear state.

        this.$watched.data( 'in-viewport', true );

        // If element only just appeared, call the appear callback.

        if ( ! watchedElementWasInViewport ) {

            // Check if the run once property has been set.

            if ( ! this.options.runOnce || this.options.runOnce && ! hasRunOnce ) {

                if ( typeof this.options.onAppear == 'string' ) {

                    if ( jQuery.isFunction( window[this.options.onAppear] ) ) {
                        window[this.options.onAppear].call( this );
                    }

                } else if ( jQuery.isFunction( this.options.onAppear ) ) {
                    this.options.onAppear.call( this );
                }

                if ( this.options.runOnce ) {
                    this.$watched.data( 'has-run-once', true );
                }

            }
            
        }

    } else {

        // Set and cache disappear state.
        
        this.$watched.data( 'in-viewport', false );

        // If element only just disaappeared, call the disappear callback.
        
        if ( watchedElementWasInViewport ) {

            // Check if the run once property has been set.

            if ( ! this.options.runOnce || this.options.runOnce && ! hasRunOnce ) {

                if ( typeof this.options.onDisappear == 'string' ) {
                    
                    if ( jQuery.isFunction( window[this.options.onDisappear] ) ) {
                        window[this.options.onDisappear].call( this );
                    }

                } else if ( jQuery.isFunction( this.options.onDisappear ) ) {
                    this.options.onDisappear.call( this );
                }

                if ( this.options.runOnce ) {
                    this.$watched.data( 'has-run-once', true );
                }

            }
            
        }

    }



    // Iterate over each parallaxed element (if any).
    
    for ( var k=0, length=this.$elements.length; k<length; k++ ) {

        var $element          = this.$elements[k];
        var elementProperties = this.elementsProperties[k];



        // Skip it if the watched element is outside the browser window viewport.

        if ( watchedElementIsOffViewport ) {

            // Mark it as parallax inactive.
        
            $element.removeClass( 'responsiville-parallax-active' ); 

            // Check if current element has defined any appear or disappear classes.

            if ( ! this.options.runOnce || this.options.runOnce && ! hasRunOnce ) {
                if ( elementProperties.addClass !== undefined) {
                    $element.removeClass( elementProperties.addClass ); 
                }
            }

            if ( ! this.options.runOnce || this.options.runOnce && ! hasRunOnce ) {
                if ( elementProperties.removeClass !== undefined ) {
                    $element.addClass( elementProperties.removeClass ); 
                }
            }

            continue;

        }



        // Mark it as parallax active.

        $element.addClass( 'responsiville-parallax-active' ); 
        
        // Check if current element has defined any appear or disappear classes.

        if ( elementProperties.addClass !== undefined ) {

            if ( ! this.options.runOnce || this.options.runOnce && ! hasRunOnce ) {
                $element.addClass( elementProperties.addClass ); 
            }

            if ( this.options.runOnce ) {
                this.$watched.data( 'has-run-once', true );
            }
            
        }

        if ( elementProperties.removeClass !== undefined ) {
            
            if ( ! this.options.runOnce || this.options.runOnce && ! hasRunOnce ) {
                $element.removeClass( elementProperties.removeClass ); 
            }

            if ( this.options.runOnce ) {
                this.$watched.data( 'has-run-once', true );
            }

        }



        // Act according to element's parallax properties.

        if ( typeof elementProperties == 'function' ) {

            // Element parallax behaviour is handled by a user defined callback.

            elementProperties.call( this, $element, parallaxPercentage );

        } else if ( elementProperties !== null ) {
            
            // Element parallax behaviour is handled by user defined from/to/unit values.
            
            var animationProperties = {};

            // Set each parallax property to its respective value. 
            
            for ( var propertyName in elementProperties ) {

                // Skip non CSS properties that refer to adding and removing classes.
                
                if ( propertyName == 'appear' || propertyName == 'disappear' ) {
                    continue;
                }

                var propertyValues = elementProperties[propertyName];

                animationProperties[propertyName] = '' + (propertyValues['from']+(propertyValues['to']-propertyValues['from'])*parallaxPercentage) + propertyValues['unit'];

            }

            $element.
                velocity( 'stop' ).
                velocity( animationProperties, { duration : this.options.duration, easing: 'linear' } );

        }

    }



    /**
     * Called after the parallax scroll has run.
     * 
     * @event Responsiville.Parallax#scrolled
     */

    this.fireEvent( 'scrolled' );

};