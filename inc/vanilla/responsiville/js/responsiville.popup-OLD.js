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
 * @property {Object}  options           The options that define the object
 *                                       behaviour.
 * @property {boolean} options.slug      A special codename for the instance of
 *                                       the element, to be used as a class on 
 *                                       its container and as a key in arrays 
 *                                       where it is grouped with other elements
 *                                       of its kind. 
 * @property {boolean} options.debug     Whether to print debug messages in the 
 *                                       browser console.
 * @property {string}  options.enter     Comma separated list of breakpoints in 
 *                                       which the popup enters, wihch means it
 *                                       is enabled.
 * @property {string}  options.leave     Comma separated list of breakpoints in 
 *                                       which the popup leaves, which means it
 *                                       is disabled.
 */

Responsiville.Popup = function ( options ) {

    // Responsiville must be initialised.

    if ( ! Responsiville.Main.getInstance() ) {
        throw new Error( 'Responsiville instantiation error: the framework has not been initialised, call new Responsiville::Main() and then Responsiville::init().' );
    }



    // General settings setup.

    this.options       = jQuery.extend( this.options, Responsiville.Popup.defaults, options );
    this.codeName      = 'responsiville.popup';
    this.responsiville = Responsiville.Main.getInstance();



    // Cache important DOM elements.

    this.$body     = this.responsiville.$body;
    this.$document = this.responsiville.$document;
    this.$window   = this.responsiville.$window;

    this.$container = jQuery( this.options.container );



    // Check for developer settings inside main element's data attributes.

    for ( var key in this.options ) {

        var value = this.$container.data( 'responsiville-accordion-' + key.toLowerCase() );

        if ( typeof value !== 'undefined' ) {
            this.options[key] = value;
        }

    }

    // Uniqueue element slug.

    if ( this.options.slug == '' ) {
        Responsiville.Accordion.elementsCounter = Responsiville.Accordion.elementsCounter !== undefined ? ++Responsiville.Accordion.elementsCounter : 0;
        this.options.slug = this.codeName.replace( '.', '-' ) + '-' + Responsiville.Accordion.elementsCounter;
    }

    // Take special care for enter/leave breakpoints possibly given as HTML data attributes.
    
    var htmlBreakpoints = Responsiville.determineEnableDisableBreakpoints({ 
        enter: this.$container.data( 'responsiville-accordion-enter' ),
        leave: this.$container.data( 'responsiville-accordion-leave' ) 
    });

    if ( htmlBreakpoints !== null ) {
        this.options.enter = htmlBreakpoints.enter;
        this.options.leave = htmlBreakpoints.leave;
    }



    // Uniquely identify this element.
    
    this.$container.addClass( this.options.slug );

    
    
    
    // If no accordion found raise an error.
    
    if ( this.$container.length === 0 ) {

        this.log( 'Responsiville.Accordion instantiation error: no accordions found (' + this.options.container + ').' );
        return;

    }



    // Add this object as a main element's data attribute for API usage.
    
    this.$container.data( 'responsiville-api', this );
    this.$container.data( 'responsiville-accordion-api', this );



    // Initialises the accordion.
        
    this.enabled = false;
    this.setupEvents();

    this.log( 'creating accordion' );



    /**
     * Called after the module has been initialised.
     * 
     * @event Responsiville.Accordion#init
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
    debug     : false, 
    slug      : '', 
    activator : 'responsiville-popup',
    container : '',
    clone     : false, 
    effect    : 'fade', 
    zIndex    : 1
};



//
// the popup is not an HTML element or a DOM entity
// it is an abstract object
// it is a functionality on top of other elements
// it might have an activator to activate it
// it might have a container which to show or which to clone
//
// clone contents or not
//
// show layer/hide layer
// show popup/hide popup
// set contents/get contents
// set activator/get activator
// 



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
 * Sets up event handlers necessary for the object to function properly. 
 * 
 * @return {void}
 */

Responsiville.Accordion.prototype.setupEvents = function () {

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