/**
 * Creates and initialises the equal heights elements. 
 * 
 * @class
 * @extends   Responsiville.Debug
 * @extends   Responsiville.Events
 * 
 * @author    Nevma, info@nevma.gr
 * @license   Nevma Copyright (c) http://www.nevma.gr
 * 
 * @fires     Responsiville.Equalheights#init
 * 
 * @classdesc A utility class that takes a set of elements and gives them all
 *            the same height, ie the height of the tallest of them. It is 
 *            responsive and allows for grouping the elements in rows. It can 
 *            run in an automatic way so that it groups elements in the same 
 *            way that they naturally flow in rows as they are being rendered by
 *            the browser.
 *
 * @param {Object} options The initialisation options of the module.
 * 
 * @property {boolean} options.debug       Whether to print debug messages in
 *                                         the  browser console.
 * @property {boolean} options.slug        A special codename for the instance
 *                                         of the element, to be used as a class
 *                                         on its container and as a key in
 *                                         arrays where it is grouped with other
 *                                         elements of its kind. 
 * @property {string}  options.container   The parent element under which the 
 *                                         elements will be found. If null then 
 *                                         the direct parent of the elements
 *                                         will be taken into account.
 * @property {string}  options.elements    The element that contains the
 *                                         elements which will eventually take
 *                                         up the same  height. If left null
 *                                         then the direct elements if the
 *                                         parent will be taken into account.
 * @property {string}  options.children    Sometimes it's not the actual
 *                                         elements themselves that we want to
 *                                         make equal height but some other
 *                                         elements inside them, so that we can
 *                                         have consistent rows of of content.
 *                                         This option is a selector that
 *                                         defines which children inside the
 *                                         specified elements should become
 *                                         equal height.
 * @property {string}  options.resize      Whether to also run on window resize,
 *                                         as well as each breakpoint change. Of
 *                                         course, throttled.
 * @property {string}  options.checkImages Whether to check for images inside
 *                                         the elements that are going to get
 *                                         equal heights and run when the images
 *                                         have all been loaded and all element
 *                                         heights have been finalised.
 * @property {string}  options.enter       Comma separated list of breakpoints
 *                                         in which the module enters, wihch
 *                                         means it is enabled.
 * @property {string}  options.leave       Comma separated list of breakpoints
 *                                         in which the module leaves, which
 *                                         means it is disabled.
 */

Responsiville.Equalheights = function ( options ) {

    // Responsiville must be initialised.

    if ( ! Responsiville.Main.getInstance() ) {

        throw new Error( 'Responsiville instantiation error: the framework has not been initialised, call new Responsiville::Main() and then Responsiville::init().' );

    }



    // General settings setup.

    this.options       = jQuery.extend( this.options, Responsiville.Equalheights.defaults, options );
    this.codeName      = 'responsiville.equalheights';
    this.responsiville = Responsiville.Main.getInstance();
    this.imagesLoaded  = 0;



    // Cache important DOM elements.

    this.$body     = this.responsiville.$body;
    this.$document = this.responsiville.$document;
    this.$window   = this.responsiville.$window;

    this.$container = jQuery( this.options.container );



    // Check for developer settings inside main element's data attributes.

    for ( var key in this.options ) {

        var value = this.$container.data( 'responsiville-equalheights-' + key );

        if ( typeof value !== 'undefined' ) {
            this.options[key] = value;
        }

    }

    // Uniqueue element slug.

    if ( this.options.slug == '' ) {
        Responsiville.Equalheights.elementsCounter = Responsiville.Equalheights.elementsCounter !== undefined ? ++Responsiville.Equalheights.elementsCounter : 0;
        this.options.slug = this.codeName.replace( '.', '-' ) + '-' + Responsiville.Equalheights.elementsCounter;
    }

    // Take special care for enter/leave breakpoints possibly given as HTML data attributes.
    
    var htmlBreakpoints = Responsiville.determineEnableDisableBreakpoints({ 
        enter: this.$container.data( 'responsiville-equalheights-enter' ),
        leave: this.$container.data( 'responsiville-equalheights-leave' ) 
    });

    if ( htmlBreakpoints !== null ) {
        this.options.enter = htmlBreakpoints.enter;
        this.options.leave = htmlBreakpoints.leave;
    }
    


    // Main equal heights elements.
    
    if ( options.elements === undefined ) {

        this.$elements = this.$container.find( this.options.elements );

        if ( this.$elements.length === 0 ) {
            this.$elements = this.$container.children();
        }
        
    } else {
        
        this.$elements = this.$container.find( this.options.elements );
        
    }

    
    
    // If no elements found raise an error.
    
    if ( this.$elements.length === 0 ) {

        this.log( 'Responsiville.Equalheights instantiation error: no elements found (' + this.options.elements + ').' );
        return;

    }



    // Add this object as a main element's data attribute for API usage.
    
    this.$container.data( 'responsiville-api', this );
    this.$container.data( 'responsiville-equalheights-api', this );

    // Uniquely identify this element.
    
    this.$container.addClass( this.options.slug );



    // Images inside equal heights elements.

    this.$images = [];



    // Initialises the equalheights.

    this.enabled = false;        
    this.setupEvents();

    this.log( 'equalheights initialised' );



    /**
     * Called after the module has been initialised.
     * 
     * @event Responsiville.Equalheights#init
     */

    this.fireEvent( 'init' );

};



// Extend with logging functions.

Responsiville.extend( Responsiville.Equalheights, Responsiville.Debug.Extensions );

// Extend with event handling mechanism.

Responsiville.extend( Responsiville.Equalheights, Responsiville.Events );



/**
 * @property {boolean} AUTO_RUN Controls whether this module should run by 
 *                              default, without the developer calling it, using
 *                              its default settings. Defaults to true.
 */

Responsiville.Equalheights.AUTO_RUN = typeof RESPONSIVILLE_AUTO_INIT !== 'undefined' ? RESPONSIVILLE_AUTO_INIT : true;



/**
 * @property {Object} defaults Default values for this module settings.
 */

Responsiville.Equalheights.defaults = {
    debug       : false,
    slug        : '',
    container   : '.responsiville-equalheights',
    elements    : '.responsiville-equalheights-element',
    children    : null,
    resize      : true,
    checkImages : true,
    enter       : 'small, mobile, tablet, laptop, desktop, large, xlarge',
    leave       : ''
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

Responsiville.Equalheights.autoRun = function () {

    jQuery( Responsiville.Equalheights.defaults.container ).each( function () {

        new Responsiville.Equalheights({
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

Responsiville.Equalheights.prototype.setupEvents = function () {

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
 * Enables the equalheights.
 *
 * @fires Responsiville.Equalheights#enabled
 * 
 * @return {void}
 */

Responsiville.Equalheights.prototype.enable = function () {

    this.log( 'enable equalheights' );



    // Avoid registering the same handlers more than once. 

    if ( ! this.enabled ) {

        // Run on breakpoint change. 
        
        this.responsiville.on( 'change', this.getBoundFunction( this.runElements ) );

        // Also run on window resize if set to do so.
        
        if ( this.options.resize ) {
            this.responsiville.on( 'resize', this.getBoundFunction( this.runElements ) );
        }

        // Run once as well now.

        this.runElements();

        // Mark module as enabled.
        
        this.enabled = true;

        // Check which images have loaded and wait for the rest of them.
    
        if ( this.options.checkImages ) {

            this.$images = this.$elements.find( 'img' );

            var images = [];

            for ( k=0, length=this.$images.length; k < length; k++ ) {

                var image = this.$images.eq( k ).attr( 'src' );
                images.push( image );
                if ( Responsiville.hasImageLoaded( image ) ) {
                    this.imagesLoaded++;
                } 

            }

            Responsiville.onImagesLoaded( images, { single: this.getBoundFunction( this.imageLoaded ) } );
            
        }

    }



    /**
     * Called after the module has been enabled.
     * 
     * @event Responsiville.Equalheights#enabled
     */

    this.fireEvent( 'enabled' );

};



/**
 * Disables the equalheights.
 * 
 * @fires Responsiville.Equalheights#disabled
 * 
 * @return {void}
 */

Responsiville.Equalheights.prototype.disable = function () {

    this.log( 'disable equalheights' );



    // Avoid de-registering the same handlers more than once. 
    
    if ( this.enabled ) {

        // Stop running on breakpoint change. 
        
        this.responsiville.off( 'change', this.getBoundFunction( this.runElements ) );

        // Also stop runing on window resize if it had been set to do so.
        
        if ( this.options.resize ) {
            this.responsiville.off( 'resize', this.getBoundFunction( this.runElements ) );
        }

        // Restore elements' height to auto.

        if ( this.options.children ) {
            this.$elements.find( this.options.children ).css( 'height', 'auto' );
        } else {
            this.$elements.css( 'height', 'auto' );
        }

        // Mark module as disabled.

        this.enabled = false;

    }



    /**
     * Called after the module has been disabled.
     * 
     * @event Responsiville.Equalheights#disabled
     */
    
    this.fireEvent( 'disabled' );

};



/**
 * Callback that runs when an image inside an element in the equal heights 
 * module has successfully loaded.
 * 
 * @fires Responsiville.Equalheights#image.loaded
 * 
 * @param {Event} event The image loaded event that originally fired.
 * 
 * @return {void}
 */

Responsiville.Equalheights.prototype.imageLoaded = function ( event ) {

    // If all images have finished ther run once.

    this.imagesLoaded++;

    if ( this.imagesLoaded == this.$images.length ) {
        this.runElements();
    }



    /**
     * Called after an image inside an equal heights element has loaded. Passes
     * the image event as an argument.
     * 
     * @event Responsiville.Equalheights#image.loaded
     */

    this.fireEvent( 'image.loaded', [ event ] );

};



/**
 * Runs when an image inside an element in the equal heights module has aborted
 * loading due to any error.
 * 
 * @fires Responsiville.Equalheights#image.error
 * 
 * @param {Event} event The image error event that originally fired.
 * 
 * @return {void}
 */

Responsiville.Equalheights.prototype.imageError = function ( event ) {

    // If all images have finished ther run once.
    
    this.imagesLoaded++;

    if ( this.imagesLoaded == this.$images.length ) {
        this.runElements();
    }



    /**
     * Called after an image inside an equal heights element was unable to load
     * due to an error. Passes the image event as an argument.
     * 
     * @event Responsiville.Equalheights#image.error
     */

    this.fireEvent( 'image.error', [ event ] );

};



/**
 * Makes all elements inside the given range take up equal height.
 *
 * @param {int} startIndex The starting point of the range inside the given
 *                         elements array.
 * @param {int} endIndex   The ending point of the range inside the given
 *                         elements array.
 * 
 * @return {void}
 */

Responsiville.Equalheights.prototype.equalise = function ( $elements ) {

    var k                = 0;
    var m                = 0;
    var height           = 0;
    var maxHeight        = 0;
    var $element         = null;

    if ( this.options.children ) {

        // Case where children of the elements inside the container are to be equalised.
        
        var childrenSelectors = Responsiville.splitAndTrim( this.options.children );
    	var childrenSelector  = null;

        for ( m = 0, length = childrenSelectors.length; m < length; m++ ) {

            childrenSelector = childrenSelectors[m];

            maxHeight = 0;

            for ( k = 0, length = $elements.length; k < length; k++ ) {

                $element = $elements.eq( k ).find( childrenSelector );
                $element.css( 'height', 'auto' );
                height = $element.outerHeight();
                maxHeight = height > maxHeight ? height : maxHeight;

            }

            $elements.find( childrenSelector ).css( 'height', maxHeight + 'px' );

        }

    } else {

        // Case where the elements inside the container themselves are to be equalised.

        for ( k = 0, length = $elements.length; k < length; k++ ) {

            $element = $elements.eq( k );
            $element.css( 'height', 'auto' );
            height = $element.outerHeight();
            maxHeight = height > maxHeight ? height : maxHeight;

        }

        $elements.css( 'height', maxHeight + 'px' );

    }

};



/**
 * Runs through elements and groups them in bunches, ie groups that take up full
 * rows of content pertaining to the given container and for each breakpoint, in
 * order to make them take up equal heights. The algorithm used to achieve this
 * is based on iterating over the given elements and detecting where a new row
 * of elements has begun (row refers to what the user sees according to what the
 * browser has rendered).
 *
 * @fires Responsiville.Equalheights#running.elements
 * @fires Responsiville.Equalheights#run.elements
 * 
 * @return {void}
 */

Responsiville.Equalheights.prototype.runElements = function () {

    this.log( 'equalising heights' );

    /**
     * Called before running through the elements to equalise heights.
     * 
     * @event Responsiville.Equalheights#running.elements
     */

    this.fireEvent( 'running.elements' );



    // Split the elements in rows which will be equalised, until all the elements are exhausted.
    
    var k         = 0;
    var $elements = this.$elements;

    while ( $elements.length > 0 ) {

    	// Create an empty set of elements which will be the current row of elements.

    	var $row = jQuery();



    	// Run through the remaining elements.

    	while ( $elements.length > 0 ) {

			var $currentElement = $elements.eq( 0 );

            // Skip any hidden elements that will hinder the row change detection.
            
    		if ( ! $currentElement.is( ':visible' ) ) {

    			$elements = $elements.slice( 1 );
    			continue;

    		}



    		// If the row is empty add the current (visible) element unconditionally.
    		
    		if ( $row.length == 0 ) {

    			$row      = $row.add( $currentElement );
    			$elements = $elements.slice( 1 );
				continue;    			

    		}



    		// Check if a row change has occured.
    		
    		var currentElementRect  = $currentElement.get( 0 ).getBoundingClientRect();
    		var previousElementRect = $row.eq( $row.length - 1 ).get( 0 ).getBoundingClientRect();

    		var isChangingRow = Math.round( currentElementRect.left ) < Math.round( previousElementRect.right );
            
            if ( isChangingRow ) {

    			// The element will be handled at the next iteration as part of the next row.
    			break;

    		} else {

                // Add the element to the elements of the current row.

    			$row = $row.add( $currentElement );
    			$elements = $elements.slice( 1 );
    			continue;

    		}

    	}



        // Equalise this complete row!
          
    	this.equalise( $row );

    }



    /**
     * Called after running through the elements to equalise heights.
     * 
     * @event Responsiville.Equalheights#run.elements
     */

    this.fireEvent( 'run.elements' );

};