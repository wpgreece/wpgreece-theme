/**
 * Creates and initialises the mobile menu.
 * 
 * @class
 * @extends   Responsiville.Debug
 * @extends   Responsiville.Events
 * 
 * @author    Nevma, info@nevma.gr
 * @license   Nevma Copyright (c) http://www.nevma.gr
 * 
 * @fires     Responsiville.Mobimenu#init
 * 
 * @classdesc A responsive mobile burger menu for the Responsiville framework, 
 *            which has come to be known as a burger menu in responsive web 
 *            design. But this is just a name. The mobile menu may have any 
 *            shape and visual effect the developer decides that it should have.
 *            It is enabled and disabled according to the given breakpoints 
 *            configuration.
 *
 * @param {Object} options The initialisation options of the module.
 * 
 * @property {Object}  options            The options that define the object
 *                                        behaviour.
 * @property {boolean} options.debug      Whether to print debug messages in the 
 *                                        browser console.
 * @property {boolean} options.slug       A special codename for the instance of
 *                                        the element, to be used as a class on 
 *                                        its container and as a key in arrays 
 *                                        where it is grouped with other 
 *                                        elements of its kind. 
 * @property {string}  options.element    The element that contains the whole of
 *                                        the mobimenu.
 * @property {string}  options.enter      Comma separated list of breakpoints in 
 *                                        which the mobimenu enters, wihch means
 *                                        it is enabled.
 * @property {string}  options.leave      Comma separated list of breakpoints in 
 *                                        which the mobimenu leaves, which means 
 *                                        it is disabled.
 * @property {string}  options.menuTitle  The title of the anchor element which
 *                                        will hold the burger menu when it is
 *                                        enabled. 
 * @property {string}  options.menuText   The text of the anchor element which
 *                                        will hold the burger menu when it is
 *                                        enabled. 
 * @property {string}  options.closeText  The text of the anchor element which
 *                                        will hold the burger menu when it is
 *                                        enabled. 
 * @property {string}  options.closeTitle The title of the anchor element which
 *                                        will hold the burger menu when it is
 *                                        enabled. 
 * @property {boolean} options.styled     Controls if extended (more than the
 *                                        absolutely necessary) styling will be
 *                                        applied, for example on UL and LI
 *                                        elements of the menu and their
 *                                        contents. Default: true.
 * @property {string}  options.effect     The visual animation effect to use
 *                                        when opening and closing the mobimenu.
 * @property {int}     options.transition The speed of the transitions of the 
 *                                        mobimenu.
 * @property {string}  options.detectHash Detects whether the module should 
                                          treat anchor elements inside the menu
                                          which start with a "#" in a special
                                          way. This means that when they are
                                          clicked the mobile menu needs to close
                                          because these links are internal and
                                          no new page will be loaded, but the 
                                          element still need to close.
 */

Responsiville.Mobimenu = function ( options ) {

    // Responsiville must be initialised.

    if ( ! Responsiville.Main.getInstance() ) {

        throw new Error( 'Responsiville instantiation error: the framework has not been initialised, call new Responsiville::Main() and then Responsiville::init().' );

    }



    // General settings setup.
    
    this.options       = {};
    this.options       = jQuery.extend( this.options, Responsiville.Mobimenu.defaults, options );
    this.codeName      = 'responsiville.mobimenu';
    this.responsiville = Responsiville.Main.getInstance();
    this.enabled       = false;
    


    // Cache important DOM elements.

    this.$body     = this.responsiville.$body;
    this.$document = this.responsiville.$document;
    this.$window   = this.responsiville.$window;
    this.$menu     = jQuery( this.options.element );



    // Check for developer settings inside main element's data attributes.

    for ( var key in this.options ) {

        var value = this.$menu.data( 'responsiville-mobimenu-' + key.toLowerCase() );

        if ( typeof value !== 'undefined' ) {
            this.options[key] = value;
        }

    }

    // Uniqueue element slug.

    if ( this.options.slug == '' ) {
        
        Responsiville.Mobimenu.elementsCounter = Responsiville.Mobimenu.elementsCounter !== undefined ? ++Responsiville.Mobimenu.elementsCounter : 0;
        this.options.slug = this.codeName.replace( '.', '-' ) + '-' + Responsiville.Mobimenu.elementsCounter;

    }

    // Take special care for enter/leave breakpoints possibly given as HTML data attributes.
    
    var htmlBreakpoints = Responsiville.determineEnableDisableBreakpoints({ 
        enter: this.$menu.data( 'responsiville-mobimenu-enter' ),
        leave: this.$menu.data( 'responsiville-mobimenu-leave' ) 
    });

    if ( htmlBreakpoints !== null ) {

        this.options.enter = htmlBreakpoints.enter;
        this.options.leave = htmlBreakpoints.leave;

    }


    
    // If no menu found raise an error.
    
    if ( this.$menu.length === 0 ) {

        this.log( 'Responsiville.Mobimenu instantiation error: no menus found (' + this.options.element + ').' );
        return;

    }

    

    // Check if this element has already been enhanced as a mobimenu (perhaps by a very intuitive scrollmenu).

    if ( typeof this.$menu.data( 'responsiville-mobimenu-api' ) != 'undefined' ) {
        
        this.log( 'Responsiville.Mobimenu has already run for element: (' + this.options.element + ').' );
        return;

    }

    // Check if this code is running on a clone produced by some other mobimenu that has previously run. 

    if ( this.$menu.closest( '.responsiville-mobimenu-wrapper-clone' ).length > 0 ) {
        
        this.log( 'Responsiville.Mobimenu cannot run on its own cloned element: (' + this.options.element + ').' );
        return;

    }



    // Add this object as a main element's data attribute for API usage.
    
    this.$menu.data( 'responsiville-api', this );
    this.$menu.data( 'responsiville-mobimenu-api', this );

    // Ensure that the appropriate class is assigned to the menu element (in case the module is called on an arbitrary element)
    
    this.$menu.addClass( 'responsiville-mobimenu' );


    
    // Wrap the original menu in a container wrapper.

    this.$menu.wrap( '<div class = "responsiville-mobimenu-wrapper" />' )
    this.$wrapper = this.$menu.parent();

    // Clone the wrapper so that it's the clone that actually opens and closes.
    
    this.$wrapperCloned = this.$wrapper.clone( false ).addClass( 'responsiville-mobimenu-wrapper-clone' ).appendTo( this.$body );

    // Decide whether the element should keep its default styling or not. 

    if ( ! this.options.styled ) {
        this.$wrapperCloned.addClass( 'responsiville-mobimenu-unstyled' );
    }

    // Uniquely identify this element.

    this.$wrapperCloned.addClass( this.options.slug );

    // Add the class that controls its visual effects. 

    this.$wrapperCloned.addClass( 'responsiville-mobimenu-effect-' + this.options.effect );



    // Search for a possible drawers menu inside the cloned mobimenu element.
    
    this.$wrapperCloned.
        find( Responsiville.Drawers.defaults.container ).
        each( function () {

            new Responsiville.Drawers({
                debug     : Responsiville.Main.getInstance().options.debug,
                container : this
            });
                        
        });

    

    // Add the burger menu next to the original menu.

    this.$menu.before( 
       '<button class = "responsiville-mobimenu-burger" title = "' + this.options.menuTitle + '">' + 
           '<span>' + this.options.menuText + '</span>' + 
       '</button>'
    );

    // Add the close button the cloned wrapper.

    this.$wrapperCloned.prepend( 
        '<button class = "responsiville-mobimenu-close" title = "' + this.options.closeTitle + '">' + 
            '<span>' + this.options.closeText + '</span>' + 
        '</button>' 
    );



    // Initialises the mobimenu.
    
    this.setupEvents();

    this.log( 'mobimenu initialised' );



    /**
     * Called after the mobimenu has been created.
     * 
     * @event Responsiville.Mobimenu#init
     */

    this.fireEvent( 'init' );

};



// Extend with logging functions.

Responsiville.extend( Responsiville.Mobimenu, Responsiville.Debug.Extensions );

// Extend with event handling mechanism.

Responsiville.extend( Responsiville.Mobimenu, Responsiville.Events );




/**
 * @property {boolean} AUTO_RUN Controls whether this module should run by 
 *                              default, without the developer calling it, using
 *                              its default settings. Defaults to true.
 */

Responsiville.Mobimenu.AUTO_RUN = typeof RESPONSIVILLE_AUTO_INIT !== 'undefined' ? RESPONSIVILLE_AUTO_INIT : true;



/**
 * @property {Object} defaults Default values for this module settings.
 */

Responsiville.Mobimenu.defaults = {
    debug      : false,
    slug       : '',
    element    : '.responsiville-mobimenu',
    enter      : 'small, mobile, tablet',
    leave      : 'laptop, desktop, large, xlarge',
    menuTitle  : 'Menu',
    menuText   : 'Menu',
    closeTitle : 'Close',
    closeText  : '&times;',
    styled     : true,
    effect     : 'slide',
    transition : 500,
    detectHash : true
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

Responsiville.Mobimenu.autoRun = function () {

    jQuery( Responsiville.Mobimenu.defaults.element ).each( function () {

        new Responsiville.Mobimenu({
            debug   : Responsiville.Main.getInstance().options.debug,
            element : this
        });
        
    });

};



/**
 * Sets up event handlers necessary for the object to function properly. 
 * 
 * @return {void}
 */

Responsiville.Mobimenu.prototype.setupEvents = function () {

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



    // Burger icon button open menu handler.

    this.$menu.parent().find( '.responsiville-mobimenu-burger' ).on( 'click', this.getBoundFunction( this.openButtonClick ) );
    
    // Menu close button handler.

    this.$wrapperCloned.find( '.responsiville-mobimenu-close' ).on( 'click', this.getBoundFunction( this.closeButtonClick ) );

    // Escape key close menu handler.

    this.$body.on( 'keyup', this.getBoundFunction( this.escapeKeyUp ) );

    // Clicking on anchor elements with a "#" closes the menu to allow for in-page navigation.

    if ( this.options.detectHash ) {
        this.$wrapperCloned.find( 'a[href*="#"]' ).on( 'click', this.getBoundFunction( this.anchorHashClick ) ); 
    }

};



/**
 * Enables the mobimenu. It does not activate it, it does not open it. It simply
 * enables it, so when the necessary trigger is fired (ie the burger menu is 
 * tapped) then the menu is activated (which means it opens). Useful in 
 * responsive design where the mobimenu might be a required feature in desktops 
 * but useless in mobile devices.
 * 
 * @return {void}
 */

Responsiville.Mobimenu.prototype.enable = function () {

    if ( this.enabled ) {
        return;
    }

    this.log( 'enable mobimenu' );



    this.enabled = true;

    this.$wrapper.addClass( 'responsiville-mobimenu-enabled' );
    this.$wrapperCloned.addClass( 'responsiville-mobimenu-enabled' );

};



/**
 * Disables the mobimenu. It does not deactivate it, it does not close it. It 
 * simply disables it, so it does not function any more when the necessary
 * trigger is fired. Useful in responsive design where the mobimenu might be a 
 * required feature in desktops but useless in mobile devices.
 * 
 * @return {void}
 */

Responsiville.Mobimenu.prototype.disable = function () {

    if ( ! this.enabled ) {
        return;
    }

    this.log( 'disable mobimenu' );



    this.enabled = false;

    this.close();

    this.$wrapper.removeClass( 'responsiville-mobimenu-enabled' );
    this.$wrapperCloned.removeClass( 'responsiville-mobimenu-enabled' );

};



/**
 * Opens the mobimenu. Actually opens and shows the mobimenu with the required 
 * visual effect.
 * 
 * @fires Responsiville.Mobimenu#opening
 * @fires Responsiville.Mobimenu#opened
 * 
 * @return {void}
 */

Responsiville.Mobimenu.prototype.open = function () {

    this.log( 'open mobimenu' );

    /**
     * Called before the mobimenu has started opening.
     * 
     * @event Responsiville.Mobimenu#opening
     */

    this.fireEvent( 'opening' );



    this.$body.addClass( 'responsiville-mobimenu-open-body' );
    this.$wrapperCloned.addClass( 'responsiville-mobimenu-opening' );
    this.$wrapperCloned.addClass( 'responsiville-mobimenu-open' );



    // Mobimenu slide effect

    this.$wrapperCloned.
        css({ left : '-100%' }).
        velocity({
            properties : { left : 0 },
            options : { 
                duration : this.options.transition,
                complete: (function () {

                    this.$wrapperCloned.removeClass( 'responsiville-mobimenu-opening' );

                    

                    /**
                     * Called after the mobimenu has been opened.
                     * 
                     * @event Responsiville.Mobimenu#opened
                     */

                    this.fireEvent( 'opened' );
                                    
                }).bind( this )
            }
         });

};



/**
 * Closes the mobimenu. Actually closes and shows the mobimenu with the required
 * visual effect.
 *
 * @param {Event} event The event that fired on the element which closes the 
 *                      mobimenu.
 * 
 * @fires Responsiville.Mobimenu#closing
 * @fires Responsiville.Mobimenu#closed
 * 
 * @return {void}
 */

Responsiville.Mobimenu.prototype.close = function ( event ) {

    this.log( 'close mobimenu' );

    /**
     * Called before the mobimenu has started closing.
     * 
     * @event Responsiville.Mobimenu#closing
     */

    this.fireEvent( 'closing' );



    this.$wrapperCloned.addClass( 'responsiville-mobimenu-closing' );



    this.$wrapperCloned.velocity({
        properties : { 
            top  : 0,
            left : '-100%'
        },
        options : { 
            duration : this.options.transition, 
            complete : (function () { 

                this.$wrapperCloned.removeClass( 'responsiville-mobimenu-closing' );
                this.$wrapperCloned.removeClass( 'responsiville-mobimenu-open' );
                this.$body.removeClass( 'responsiville-mobimenu-open-body' );



                /**
                 * Called after the mobimenu has been closed.
                 * 
                 * @event Responsiville.Mobimenu#closed
                 */

                this.fireEvent( 'closed' );

            }).bind( this )
        }
     });

};



/**
 * Handles the click event on the mobimenu open butoon. The menu opens and the
 * handler always returns true.
 * 
 * @return {boolean} Whether the event should propagate and allow default
 *                   behaviour. 
 */

Responsiville.Mobimenu.prototype.openButtonClick = function ( event ) {

    this.open();
    return false;
    
};



/**
 * Handles the click event on an anchor element inside the mobimenu which has an
 * internal link, ie starts with a "#". If the anchor points to an existing
 * element then the menu is closed so that the page can be scrolled to that
 * element. 
 * 
 * @param {Event} event The mouse click event that fired.
 *
 * @return {boolean} Whether the event should propagate and allow default
 *                   behaviour.
 */

Responsiville.Mobimenu.prototype.anchorHashClick = function ( event ) {

    // Check if the anchor points to an existing element. 

    var anchorPointsToExistingElement = jQuery( jQuery( event.target ).attr( 'href' ) ).length > 0;

    if ( anchorPointsToExistingElement ) {
        this.close();
    }
    
};



/**
 * Handles the click event on the mobimenu close button. The menu is closed and
 * the handler always returns false to stop default behaviour.
 * 
 * @return {boolean} Whether the event should propagate and allow default
 *                   behaviour. 
 */

Responsiville.Mobimenu.prototype.closeButtonClick = function (  ) {

    this.close();
    return false;
    
};



/**
 * Handles the click event on the mobimenu container body. The menu is closed
 * and the handler always returns false to stop default behaviour.
 * 
 * @param {Event} event The mouse click event that fired.
 * 
 * @return {boolean} Whether the event should propagate and allow default
 *                   behaviour.
 */

Responsiville.Mobimenu.prototype.menuContainerClick = function ( event ) {

    // If the event was propagated from a clicked link stop and let the link do what it was programmed to do.

    if ( event && event.target.nodeName.toLowerCase() == 'a' ) {
        return true;
    }

    // Otherwise close the mobimenu.

    this.close();
    return false;
    
};



/**
 * Handles the escape key up event to close the mobimenu via the keyboard
 * when it is open. One could argue thath it is pointless in mobile devices, but
 * burger menus have been used in desktop devices often as well.
 * 
 * @param {Event} event The event that fired on the keyboard.
 *                      
 * @return {boolean} Whether the event should propagate and allow default
 *                   behaviour.
 */

Responsiville.Mobimenu.prototype.escapeKeyUp = function ( event ) {

    // Check if escape key has been pressed.

    var ESCAPE_KEY = 27;

    if ( event && event.keyCode == ESCAPE_KEY ) {

        this.close();
        return false;

    }

    return true;

};