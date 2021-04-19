/**
 * Lazy loading images utility.
 * 
 * @class
 * @extends   Responsiville.Debug
 * @extends   Responsiville.Events
 * 
 * @author    Nevma, info@nevma.gr
 * @license   Nevma Copyright (c) http://www.nevma.gr
 * 
 * @fires     Responsiville.Lazymg#init
 * 
 * @classdesc Causes an image to lazy load. This means that it tries to prevent 
 *            the image from loading during normal page load time and makes it
 *            load the moment it appears in the browser viewport.
 *
 * @param {Object} options The initialisation options of the module.
 * 
 * @property {Object}  options               The options that define the object
 *                                           behaviour.
 * @property {boolean} options.debug         Whether to print debug messages in
 *                                           the browser console.
 * @property {boolean} options.slug          A special codename for the instance
 *                                           of the element, to be used as a
 *                                           class on its container and as a key
 *                                           in arrays where it is grouped with
 *                                           other elements of its kind. 
 * @property {boolean} options.element       The image element to run on.
 * @property {boolean} options.src           The image url to be lazy loaded.
 * @property {boolean} options.cssBackground Signifies that the image to be lazy 
 *                                           loaded is actually in the CSS
 *                                           background of the given element. 
 * @property {integer} options.offsetTop     How much to delay the parallax
 *                                           effect in terms of space, after
 *                                           the watched element has appeared in
 *                                           the browser viewport.
 * @property {integer} options.offsetBottom  How much to make completion faster
 *                                           in terms of space for the parallax
 *                                           effect.
 * @property {string}  options.enter         Comma separated list of breakpoints
 *                                           in which the module enters, which
 *                                           means it is enabled.
 * @property {string}  options.leave         Comma separated list of breakpoints
 *                                           in which the module leaves, which
 *                                           means it is disabled.
 */

Responsiville.Lazymg = function ( options ) {

    // Responsiville must be initialised.

    if ( ! Responsiville.Main.getInstance() ) {

        throw new Error( 'Responsiville instantiation error: the framework has not been initialised, call new Responsiville::Main() and then Responsiville::init().' );

    }



    // General settings setup.
    
    this.options       = {};
    this.options       = jQuery.extend( this.options, Responsiville.Lazymg.defaults, options );
    this.codeName      = 'responsiville.lazymg';
    this.responsiville = Responsiville.Main.getInstance();

    this.enabled = false;

    

    // Cache important DOM elements.

    this.$body     = this.responsiville.$body;
    this.$document = this.responsiville.$document;
    this.$window   = this.responsiville.$window;
    this.$element  = jQuery( this.options.element );



    // Check for developer settings inside main element's data attributes.

    for ( var key in this.options ) {

        var value = this.$element.data( 'responsiville-lazymg-' + key.toLowerCase() );

        if ( typeof value !== 'undefined' ) {
            this.options[key] = value;
        }

    }

    // Unique element slug.

    if ( this.options.slug == '' ) {
        Responsiville.Lazymg.elementsCounter = Responsiville.Lazymg.elementsCounter !== undefined ? ++Responsiville.Lazymg.elementsCounter : 0;
        this.options.slug = this.codeName.replace( '.', '-' ) + '-' + Responsiville.Lazymg.elementsCounter;
    }

    // Take special care for enter/leave breakpoints possibly given as HTML data attributes.
    
    var htmlBreakpoints = Responsiville.determineEnableDisableBreakpoints({ 
        enter: this.$element.data( 'responsiville-lazymg-enter' ),
        leave: this.$element.data( 'responsiville-lazymg-leave' ) 
    });

    if ( htmlBreakpoints !== null ) {
        this.options.enter = htmlBreakpoints.enter;
        this.options.leave = htmlBreakpoints.leave;
    }
    
    
    
    // If no image element found raise an error.
    
    if ( this.$element.length === 0 ) {

        this.log( 'Responsiville.Lazymg instantiation error: no lazymg elements found (' + this.options.element + ').' );
        return;

    }



    // Add this object as a main element's data attribute for API usage.
    
    this.$element.data( 'responsiville-api', this );
    this.$element.data( 'responsiville-lazymg-api', this );



    // Uniquely identify this element.
    
    this.$element.addClass( this.options.slug );



    // Initialises the lazymg.
    
    this.setupEvents();

    this.log( 'lazymg initialised' );



    /**
     * Called after the lazymg has been created.
     * 
     * @event Responsiville.Lazymg#init
     */

    this.fireEvent( 'init' );

};



// Extend with logging functions.

Responsiville.extend( Responsiville.Lazymg, Responsiville.Debug.Extensions );

// Extend with event handling mechanism.

Responsiville.extend( Responsiville.Lazymg, Responsiville.Events );




/**
 * @property {boolean} AUTO_RUN Controls whether this module should run by 
 *                              default, without the developer calling it, using
 *                              its default settings. Defaults to true.
 */

Responsiville.Lazymg.AUTO_RUN = typeof RESPONSIVILLE_AUTO_INIT !== 'undefined' ? RESPONSIVILLE_AUTO_INIT : true;



/**
 * @property {Object} defaults Default values for this module settings.
 */

Responsiville.Lazymg.defaults = {
    debug         : false,
    slug          : '',
    element       : '.responsiville-lazymg',
    src           : '',
    cssBackground : false,
    offsetTop     : -100,
    offsetBottom  : 0,
    enter         : 'small, mobile, tablet, laptop, desktop, large, xlarge',
    leave         : ''
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
Responsiville.Lazymg.autoRun = function () {

    jQuery( Responsiville.Lazymg.defaults.element ).each( function () {

        new Responsiville.Lazymg({
            debug   : Responsiville.Main.getInstance().options.debug,
            element : this
        });
        
    });

};



/**
 * Returns the element of interest, that is the image being handled for lazy
 * loading wrapped in jQuery. 
 * 
 * @return void
 */
Responsiville.Lazymg.getElement = function () {

    return this.$element; 

};



/**
 * Sets up event handlers necessary for the object to function properly. 
 * 
 * @return {void}
 */
Responsiville.Lazymg.prototype.setupEvents = function () {

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

};



/**
 * Enables the lazy image. It does not activate it. It simply enables it, so
 * when the necessary trigger is fired then the lazy image behaviour begins.
 * Useful in responsive design where the lazy image might be a required feature
 * in desktops but useless in mobile devices.
 *
 * @fires Responsiville.Lazymg#enabled
 * 
 * @return {void}
 */

Responsiville.Lazymg.prototype.enable = function () {

    // Only enable the module once in each page load.

    if ( this.enabled ) {
        return;
    }

    this.log( 'enable lazymg' );



    if ( this.$element.attr( 'src' ) ) {
        
        // Case where the src is already filled with an IMG element.

        if ( ! Responsiville.hasImageLoaded( this.$element.get( 0 ) ) ) {

            // Image url to lazy load is the IMG src attribute and we cache it properly here.

            this.options.src = this.$element.attr( 'src' );

            this.$element.attr( 'src', '' );
            
            new Responsiville.Parallax({
                watch       : this.$element,
                runOnce     : true,
                offsetTop   : this.options.offsetTop,
                offsetBottom: this.options.offsetBottom,
                onAppear    : this.getBoundFunction( this.appearImageBySrc )
            });
            
        } else {

            // If image has already managed to load then do nothing.
            
            this.$element.addClass( 'responsiville-lazymg-loaded' );

            this.log( 'image already loaded: ' +  this.$element.attr( 'src' ) );

        }
        
    } else if ( this.options.cssBackground ) {

        // Case where the image is going to be in the element's CSS background.

        this.$element.css( 'background-image', '' );

        new Responsiville.Parallax({
            watch       : this.$element,
            runOnce     : true,
            offsetTop   : this.options.offsetTop,
            offsetBottom: this.options.offsetBottom,
            onAppear    : this.getBoundFunction( this.appearImageByCSSBg )
        });

    } else {

        // Usual case where the element is an IMG with an empty src attribute.

        this.$element.attr( 'src', '' );

        new Responsiville.Parallax({
            watch       : this.$element,
            runOnce     : true,
            offsetTop   : this.options.offsetTop,
            offsetBottom: this.options.offsetBottom,
            onAppear    : this.getBoundFunction( this.appearImageBySrc )
        });
        
    }

    this.enabled = true;



    /**
     * Called after the lazymg scroll has been enabled.
     * 
     * @event Responsiville.Lazymg#enabled
     */

    this.fireEvent( 'enabled' );

};



/**
 * The function that runs when the image first appears, ie enters the browser
 * viewport. It sets the image src attribute back to what is was meant to be in 
 * the first place. 
 *
 * @fires Responsiville.Lazymg#appear
 * 
 * @return {void}
 */

Responsiville.Lazymg.prototype.appearImageBySrc = function () {

    this.log( 'lazymg appearing' );

    this.$element.addClass( 'responsiville-lazymg-loading' );

    Responsiville.onImagesLoaded( [this.options.src], 
        {
            single: 
                (function ( image ) {
                this.$element.attr( 'src', this.options.src );
                this.$element.removeClass( 'responsiville-lazymg-loading' );
                this.$element.addClass( 'responsiville-lazymg-loaded' );
            }).bind( this )
        }
    );

    /**
     * Called after the lazymg scroll has been enabled.
     * 
     * @event Responsiville.Lazymg#enabled
     */

    this.fireEvent( 'appear' );

};



/**
 * The function that runs when the image first appears, ie enters the browser
 * viewport. It sets the image src attribute back to what is was meant to be in 
 * the first place. 
 *
 * @fires Responsiville.Lazymg#appear
 * 
 * @return {void}
 */

Responsiville.Lazymg.prototype.appearImageByCSSBg = function () {

    this.log( 'lazymg appearing css bg' );

    this.$element.addClass( 'responsiville-lazymg-loading' );

    Responsiville.onImagesLoaded( [this.options.src], 
        {
            single: (function ( image ) {
                this.$element.css( 'background-image', 'url(' + this.options.src + ')' );
                this.$element.removeClass( 'responsiville-lazymg-loading' );
                this.$element.addClass( 'responsiville-lazymg-loaded' );
            }).bind( this )
        }
    );

    /**
     * Called after the lazymg scroll has been enabled.
     * 
     * @event Responsiville.Lazymg#enabled
     */

    this.fireEvent( 'appear' );

};



/**
 * Disables the lazy image. It does not deactivate it. It simply disables it, so
 * it does not function any more when the necessary trigger is fired. Useful in
 * responsive design where the lazy image might be a required feature in 
 * desktops but useless in mobile devices.
 * 
 * @fires Responsiville.Lazymg#disabled
 * 
 * @return {void}
 */

Responsiville.Lazymg.prototype.disable = function () {

    this.log( 'disable lazymg' );

    // Not used yet!

    this.disabled = true;

    /**
     * Called after the lazymg scroll has been disabled.
     * 
     * @event Responsiville.Lazymg#disabled
     */

    this.fireEvent( 'disabled' );

};