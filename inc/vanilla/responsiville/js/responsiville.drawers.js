/**
 * Creates and initialises the drawers. 
 * 
 * @class
 * @extends   Responsiville.Debug
 * @extends   Responsiville.Events
 * 
 * @author    Nevma, info@nevma.gr
 * @license   Nevma Copyright (c) http://www.nevma.gr
 * 
 * @fires     Responsiville.Drawers#init
 * 
 * @classdesc A drawers element is an element that opens and closes like an
 *            an accordion, only it is self contained and has no header/title
 *            element like the accordion. Instead it automatically creates an
 *            open/close button.
 *
 * @param {Object} options The initialisation options of the module.
 * 
 * @property {Object}  options           The options that define the object
 *                                       behaviour.
 * @property {boolean} options.debug     Whether to print debug messages in the 
 *                                       browser console.
 * @property {boolean} options.slug      A special codename for the instance of
 *                                       the element, to be used as a class on 
 *                                       its container and as a key in arrays 
 *                                       where it is grouped with other elements
 *                                       of its kind. 
 * @property {boolean} options.exclusive Whether multiple drawers panels 
 *                                       drawers can be simultaneously open or
 *                                       not. 
 * @property {boolean} options.container The container element of the drawers
 *                                       panels.
 * @property {boolean} options.element   The selector or element that is the 
 *                                       actual panel which opens and closes. It
 *                                       has to be inside the container element.
 * @property {boolean} options.effect    The visual effect to use for opening
 *                                       and closing the elements.
 * @property {boolean} options.duration  The duration of the visual effect when
 *                                       opening and closing the elements.
 * @property {string}  options.enter     Comma separated list of breakpoints in 
 *                                       which the drawers enters, wihch means
 *                                       it is enabled.
 * @property {string}  options.leave     Comma separated list of breakpoints in 
 *                                       which the drawers leaves, which means 
 *                                       it is disabled.
 */

Responsiville.Drawers = function ( options ) {

    // Responsiville must be initialised.

    if ( ! Responsiville.Main.getInstance() ) {

        throw new Error( 'Responsiville instantiation error: the framework has not been initialised, call new Responsiville::Main() and then Responsiville::init().' );

    }



    // General settings setup.

    this.options       = {};
    this.options       = jQuery.extend( this.options, Responsiville.Drawers.defaults, options );
    this.codeName      = 'responsiville.drawers';
    this.responsiville = Responsiville.Main.getInstance();



    // Cache important DOM elements.

    this.$body      = this.responsiville.$body;
    this.$document  = this.responsiville.$document;
    this.$window    = this.responsiville.$window;
    this.$container = jQuery( this.options.container );



    // Check for developer settings inside main element's data attributes.

    for ( var key in this.options ) {

        var value = this.$container.data( 'responsiville-drawers-' + key.toLowerCase() );

        if ( typeof value !== 'undefined' ) {
            this.options[key] = value;
        }

    }

    // Uniqueue element slug.

    if ( this.options.slug == '' ) {
        Responsiville.Drawers.elementsCounter = Responsiville.Drawers.elementsCounter !== undefined ? ++Responsiville.Drawers.elementsCounter : 0;
        this.options.slug = this.codeName.replace( '.', '-' ) + '-' + Responsiville.Drawers.elementsCounter;
    }

    // Take special care for enter/leave breakpoints possibly given as HTML data attributes.
    
    var htmlBreakpoints = Responsiville.determineEnableDisableBreakpoints({ 
        enter: this.$container.data( 'responsiville-drawers-enter' ),
        leave: this.$container.data( 'responsiville-drawers-leave' ) 
    });

    if ( htmlBreakpoints !== null ) {
        this.options.enter = htmlBreakpoints.enter;
        this.options.leave = htmlBreakpoints.leave;
    }



    // Uniquely identify this element.
    
    this.$container.addClass( this.options.slug );
    
    
    
    // If no drawers found raise an error.
    
    if ( this.$container.length === 0 ) {

        this.log( 'Responsiville.Drawers instantiation error: no drawers found (' + this.options.container + ').' );
        return;

    }



    // Check if this element has already been enhanced as a drawers menu (perhaps by a very intuitive scrollmenu).

    if ( typeof this.$container.data( 'responsiville-drawers-api' ) !== 'undefined' ) {
        
        this.log( 'Responsiville.Drawers has already run for element: (' + this.options.container + ').' );
        return;

    }



    // Add this object as a main element's data attribute for API usage.
    
    this.$container.data( 'responsiville-api', this );
    this.$container.data( 'responsiville-drawers-api', this );



    // Obtain the actual elements which will be opening and closing like drawers.
    
    this.$elements = this.$container.find( this.options.element );



    // Initialises the drawers.
        
    this.enabled = false;
    this.setupEvents();

    this.log( 'drawers initialised' );



    /**
     * Called after the module has been initialised.
     * 
     * @event Responsiville.Drawers#init
     */

    this.fireEvent( 'init' );

};



// Extend with logging functions.

Responsiville.extend( Responsiville.Drawers, Responsiville.Debug.Extensions );

// Extend with event handling mechanism.

Responsiville.extend( Responsiville.Drawers, Responsiville.Events );



/**
 * @property {boolean} AUTO_RUN Controls whether this module should run by 
 *                              default, without the developer calling it, using
 *                              its default settings. Defaults to true.
 */

Responsiville.Drawers.AUTO_RUN = typeof RESPONSIVILLE_AUTO_INIT !== 'undefined' ? RESPONSIVILLE_AUTO_INIT : true;



/**
 * @property {Object} defaults Default values for this module settings.
 */

Responsiville.Drawers.defaults = {
    debug     : false, 
    exclusive : false, 
    slug      : '',
    container : '.responsiville-drawers',
    element   : 'ul',
    effect    : 'slide',
    startAt   : 0,
    duration  : 300,
    enter     : 'small, mobile, tablet, laptop, desktop, large, xlarge',
    leave     : ''
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

Responsiville.Drawers.autoRun = function () {

    jQuery( Responsiville.Drawers.defaults.container ).each( function () {

        new Responsiville.Drawers({
            debug     : Responsiville.Main.getInstance().options.debug,
            container : this
        });
        
    });

};



/**
 * Sets up event handlers necessary for the object to function properly. 
 * 
 * @return {void}
 */

Responsiville.Drawers.prototype.setupEvents = function () {

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

    

    // Which panel to open in the beginning.
    
    if ( this.options.startAt > 0 ) {
        this.openElement( this.$elements.eq( this.options.startAt-1 ) );
    }

};



/**
 * Enables the drawers.
 *
 * @fires Responsiville.Drawers#enabled
 * 
 * @return {void}
 */

Responsiville.Drawers.prototype.enable = function () {

    if ( this.enabled ) {
        return;
    }

    this.log( 'enable drawers' );



    this.enabled = true;

    for ( var k=0, length=this.$elements.length; k<length; k++ ) {

        var $element = this.$elements.eq( k );

        if ( $element.parent().find( '.responsiville-drawers-button' ).length == 0 ) {
            $element.parent().append( '<button class = "responsiville-drawers-button"></button>' );
        }

    }

    for ( var k=0, length=this.$elements.length; k<length; k++ ) {

        var $element = this.$elements.eq( k );

        $element.parent().addClass( 'responsiville-drawers-parent' );
    
        $element.
            addClass( 'responsiville-drawers-element' ).
            siblings( '.responsiville-drawers-button' ).
            on( 'click', this.getBoundFunction( this.buttonClick ) );
    
    }



    /**
     * Called after the drawers has been enabled.
     * 
     * @event Responsiville.Drawers#enabled
     */

    this.fireEvent( 'enabled' );

};



/**
 * Disables the drawers.
 * 
 * @fires Responsiville.Drawers#disabled
 * 
 * @return {void}
 */

Responsiville.Drawers.prototype.disable = function () {

    if ( ! this.enabled ) {
        return;
    }

    this.log( 'disable drawers' );



    this.enabled = false;

    for ( var k=0, length=this.$elements.length; k<length; k++ ) {

        var $element = this.$elements.eq( k );

        $element.parent().removeClass( 'responsiville-drawers-parent' );

        $element.
            addClass( 'responsiville-drawers-element' ).
            siblings( '.responsiville-drawers-button' ).
            off( 'click', this.getBoundFunction( this.buttonClick ) );
    
    }



    /**
     * Called after the drawers has been disabled.
     * 
     * @event Responsiville.Drawers#disabled
     */
    
    this.fireEvent( 'disabled' );

};



/**
 * Handles the drawers button click event. This button toggles the visibility of
 * the panel element. 
 *
 * @param {Event} event The user click event sent by the browser.
 */

Responsiville.Drawers.prototype.buttonClick = function ( event ) {

    var $element = jQuery( event.target ).siblings( this.options.element );

    if ( $element.is( ':visible' ) ) {
        this.closeElement( $element );        
    } else {
        this.openElement( $element );
    }

};



/**
 * Opens the given panel element. 
 *
 * @param {jQuery} $element The panel element required to open.
 *
 * @fires Responsiville.Drawers#opening
 * @fires Responsiville.Drawers#opened
 */

Responsiville.Drawers.prototype.openElement = function ( $element ) {

    this.log( 'opening drawers' );

    /**
     * Called before opening the element.
     * 
     * @event Responsiville.Drawers#opening
     */
    
    this.fireEvent( 'opening' );



    $element.addClass( 'responsiville-drawers-element-opening' );

    $element.velocity( 
        'slideDown', { 
            duration: this.options.duration ,
            complete: (function () {

                $element.removeClass( 'responsiville-drawers-element-opening' );
                $element.addClass( 'responsiville-drawers-element-open' );

                $element.siblings( '.responsiville-drawers-button' ).addClass( 'responsiville-drawers-button-open' );

                /**
                 * Called after opening the element.
                 * 
                 * @event Responsiville.Drawers#opened
                 */
                
                this.fireEvent( 'opened' );
                                
            }).bind( this )
        }
    );

};



/**
 * Closes the given panel element. 
 *
 * @param {jQuery} $element The panel element required to close.
 *
 * @fires Responsiville.Drawers#closing
 * @fires Responsiville.Drawers#closed
 */

Responsiville.Drawers.prototype.closeElement = function ( $element ) {

    this.log( 'closing drawers' );

    /**
     * Called before closing the element.
     * 
     * @event Responsiville.Drawers#closing
     */
    
    this.fireEvent( 'closing' );



    $element.addClass( 'responsiville-drawers-element-closing' );

    $element.velocity( 
        'slideUp', { 
            duration: this.options.duration,
            complete: (function () {

                $element.removeClass( 'responsiville-drawers-element-closing' );
                $element.removeClass( 'responsiville-drawers-element-open' );
                
                $element.siblings( '.responsiville-drawers-button' ).removeClass( 'responsiville-drawers-button-open' );

                /**
                 * Called after closing the element.
                 * 
                 * @event Responsiville.Drawers#closed
                 */
                
                this.fireEvent( 'closed' );
                                
            }).bind( this )
        }
    );

};