/**
 * The Debug scope of the Responsiville framework. Contains debugging methods
 * and properties which assist in the development of responsive web pages with 
 * the Responsiville framework. Not meant to be used autonomously even inside 
 * the scope of the framework.
 *
 * @namespace Responsiville.Debug
 */

Responsiville.Debug = {};



/**
 * Internet Explorer (at least up to version 10) does not support the console
 * group and groupEnd functions, so we point them to the usual log function.
 */

if ( typeof console.group === 'undefined' || typeof console.groupEnd === 'undefined' ) {

    console.group    = console.log;
    console.groupEnd = console.log;

}



/**
 * @var {boolean} RESPONSIVILLE_DEBUG
 * 
 * Global setting/flag for the framework debugging messages. If set before the
 * framework runs then that value is taken into account, otherwise it is
 * initialised to "false". This setting is useful only when the framework 
 * initialises automatically. In other cases it is up to the developer to
 * set it properly or leave it to its default value.
 *
 * @global
 */

var RESPONSIVILLE_DEBUG = typeof RESPONSIVILLE_DEBUG !== "undefined" ? RESPONSIVILLE_DEBUG : false;
    


/**
 * @var {boolean} RESPONSIVILLE_AUTO_INIT
 * 
 * Global setting/flag for the framework automatic initialisation process. If 
 * set before the framework scripts are included in the page HTML then that 
 * value is taken into account, otherwise it is initialised to "true". It is 
 * mainly useful when one wants to alter the default framework behaviour, which
 * is set to automatically initialise.
 *
 * @global
 */

var RESPONSIVILLE_AUTO_INIT;



/**
 * Special scope which contains debugging functions that may be injected in any 
 * object's prototype so that it is extended with debugging capabilities as if
 * it had inherited them. Not meant to be used autonomously.
 * 
 * @namespace Responsiville.Debug.Extensions
 */

Responsiville.Debug.Extensions = {};



/**
 * Prints the available functions of the current scope object. A quick and 
 * convenient way of printing an object's API. Responsiville objects are 
 * injected (ie they inherit) this method for convienence in debugging. It 
 * follows the debug option of the main Responsiville object in order to be
 * verbose or quiet.
 * 
 * @return {void}
 */

Responsiville.Debug.Extensions.printAPI = function () {

    var debug = this.options.debug;

    this.options.debug = true;



    var toLog = [ 'API' ];
    
    for ( var parameter in this ) {

        // Only print functions.
        
        if ( jQuery.isFunction( this[parameter] ) ) {
            
            toLog.push( parameter );
            toLog.push( this[parameter] );

        }
    }



    this.log.apply( this, toLog );

    this.options.debug = debug;

};



/**
 * Wrapper for the console log function that pretty prints log messages inside 
 * the log scope of the current scope object using its code name. Responsiville 
 * objects are injected (ie they inherit) this method for convienence in 
 * debugging. It follows the debug option of the main Responsiville object in 
 * order to be verbose or quiet.
 *
 * @param {...String} arguments Arbitrary number of string messages to be logged
 *                              in the browser console.
 *                              
 * @return {void}
 */

Responsiville.Debug.Extensions.log = function () {

    if ( ! this.options.debug ) {
        return;
    }



    // The current log entry is wrapped in a group in console.

    console.group( '[' + this.codeName + '/' + this.options.slug  + ']' );

    // Logs all given arguments one afer the other.

    for ( var k=0, length=arguments.length; k<length; k++ ) {
        console.log( arguments[k] );
    }

    console.groupEnd();

};



/**
 *
 * Wrapper for the console dir function that pretty prints an object inside the
 * log scope of the current scope object using its code name. Responsiville 
 * objects are  (ie they inherit) this method for convienence in debugging. It 
 * follows the debug option of the main Responsiville object in order to be
 * verbose or quiet.
 *
 * @param {...Object} arguments Arbitrary number of objects to be displayed in 
 *                              a pretty printed way in the browser console.
 * 
 * @return {void}
 */

Responsiville.Debug.Extensions.dir = function () {

    if ( ! this.options.debug ) {
        return;
    }



    // The current dir entry is wrapped in a group in console.

    console.group( '[' + this.codeName + '/' + this.options.slug + ']' );

    // Dirs all given arguments one afer the other.

    for ( var k=0, length=arguments.length; k<length; k++ ) {

        var argument = arguments[k];

        if ( jQuery.type( arguments[k] ) == 'string' ) {
            console.log( argument );
        } else if ( jQuery.isFunction( argument ) ) {
            console.log( argument );
        } else {
            console.dir( argument );
        }

    }

    console.groupEnd();

};



/**
 * Sets up the little debug panel of the Responsiville framework which lies
 * quietly at the edge of the screen to assist in responsive web page building.
 * It provides info on page load times, screen sizes and breakpoints, web
 * development documentation links and Responsiville documentation links. It is 
 * supposed to be turned off in production mode. It follows the debugUI option
 * of the main responsiville object in order to appear on hide.
 * 
 * @return {void}
 */

Responsiville.Debug.setupDebug = function () {

    var responsiville = Responsiville.Main.getInstance();

    if ( ! responsiville.options.debugUI ) {
        return;
    }



    // Create the debug panel.
    
    responsiville.$body.append(

        '<aside class = "responsiville-debug-controls ' + responsiville.options.debugPos + '">' +

            // For debugging the grid.

            '<section class = "responsiville-debug-control responsiville-debug-layout">' +
                '<p>' +
                    '<label for = "responsiville-debug-grid">' +
                        'Grid debug <input type = "checkbox" id = "responsiville-debug-grid" name = "responsiville-debug-grid" value = "responsiville-debug-grid">' +
                    '</label>' +
                '</p>' +
                '<p>' +
                    '<label for = "responsiville-debug-blocks">' +
                        'Text debug <input type = "checkbox" id = "responsiville-debug-blocks" name = "responsiville-debug-blocks" value = "responsiville-debug-blocks">' +
                    '</label>' +
                '</p>' +
                '<p>' +
                    '<label for = "responsiville-debug-semantic">' +
                        'Semantic debug <input type = "checkbox" id = "responsiville-debug-semantic" name = "responsiville-debug-semantic" value = "responsiville-debug-semantic">' +
                    '</label>' +
                '</p>' +
                '<p>' +
                    '<label for = "responsiville-debug-wpadminbar">' +
                        'WP admin bar <input type = "checkbox" id = "responsiville-debug-wpadminbar" name = "responsiville-debug-wpadminbar" value = "responsiville-debug-wpadminbar">' +
                    '</label>' +
                '</p>' +
            '</section>' +
            
            // For debugging screen sizes.

            '<section class = "responsiville-debug-control responsiville-debug-dimensions">' +
                '<p>[please wait&hellip;]</p>' +
            '</section>' +

            // For monitoring browser performance.

            '<section class = "responsiville-debug-control responsiville-debug-performance">' +
                '<p>[please wait&hellip;]</p>' +
            '</section>' +

            // Link to the responsiville test page, if we are in a page of the theme.

            '<section class = "responsiville-debug-control responsiville-debug-text">' +
                '<p>' + 
                    '<a class = "button button-small" href = "http://vanilla.nevma.gr/wp-content/docs/vanilla-apigen/" title = "Vanilla documentation" target = "_blank">Vanilla docs</a>' + 
                    '<a class = "button button-small" href = "http://vanilla.nevma.gr/wp-content/docs/responsiville-jsdoc/" title = "Responsiville documentation" target = "_blank">Responsiville docs</a>' +
                    '<a class = "button button-small" href = "http://vanilladev.nevma.gr/" title = "Vanilla demo" target = "_blank">Vanilla demo</a>' + 
                    '<a class = "button button-small" href = "http://vanilla.nevma.gr/wp-content/themes/vforvanilla/inc/vanilla/responsiville/demo" title = "Responsiville demo page" target = "_blank">Responsiville demo</a>' +
                '</p>' +
            '</section>' +

            // Toggles the panel on and off.

            '<button class = "responsiville-debug-toggle"></button>' + 

        '</aside>'

    );



    // Cache important debug elements.

    this.$debugControls    = jQuery( '.responsiville-debug-controls' );
    this.$debugPerformance = jQuery( '.responsiville-debug-dimensions' );
    this.$debugToggle      = jQuery( '.responsiville-debug-toggle' );



    // Handlers for debugging.

    jQuery( '.responsiville-debug-layout input[type="checkbox"]' ).on( 'change', function () {

        if ( jQuery( this ).is( ':checked' ) ) {
            jQuery( 'body' ).addClass( jQuery( this ).val() );
        } else {
            jQuery( 'body' ).removeClass( jQuery( this ).val() );
        }

    }).trigger( 'change' );

    jQuery( '.row' ).each( function () {

        jQuery( this ).
            append( '<p class = "class-info start">&lt;row&gt;</p>' ).
            append(  '<p class = "class-info end">&lt;/row&gt;</p>' );

    });
    
    jQuery( '[class*="column"]' ).each( function () {

        var classString = '';
        var classList = jQuery( this ).get( 0 ).classList.value.split( ' ' );
        for ( var k=0, length=classList.length; k<length; k++ ) {
            var className = classList[k];
            if ( className.indexOf( 'column' ) > -1 ) {
                classString += className + ' ';
            }
        }
        classString = jQuery.trim( classString );

        jQuery( this ).
            append( '<p class = "class-info start">&lt;' + classString + '&gt;</p>' ).
            append(  '<p class = "class-info end">&lt;/'  + classString + '&gt;</p>' );

    });

    jQuery( 'header, footer, nav, main, aside, article, section, h1, h2, h3, h4, h5, h6' ).each( function () {

        if ( jQuery( this ).is( '.responsiville-debug-controls' ) ||
             jQuery( this ).parent( '.responsiville-debug-controls' ).length > 0 ) {
            return;
        }

        jQuery( this ).append( '<p class = "semantic-info">' + this.tagName.toLowerCase() + '</p>' )

    });



    // Handler for the button that toggles the debug panel itself.

    this.$debugToggle.on( 'click', (function () {

        if ( this.$debugToggle.is( '.responsiville-debug-toggle-closed' ) ) {
            this.openDebugPanel();
        } else {
            this.closeDebugPanel();
        }
    
    }).bind( this ) );

    if ( responsiville.getProperty( 'debug-panel-on' ) ) {
        this.openDebugPanel();
    } else {
        this.closeDebugPanel();
    }



    // Shows load performance data on page load.
    
    responsiville.$window.on( 'load', (function () {

        // Delay just a tad, so that the load event has had time to complete.

        window.setTimeout( this.showDebugLoadPerformance, 10 );


    }).bind( this ));



    // Show dimensions debug on window resize.

    responsiville.on( 'resize', this.showDebugUIDimensions.bind( this ) );

    jQuery( this.showDebugUIDimensions.bind( this ) );

};



/**
 * Shows the dimensions of the current browser inner window in the Responsiville
 * debug panel. This is intended to represent the current device screen when 
 * developing and debugging. It also shows the current responsive breakpoint 
 * along with a respective icon.
 * 
 * @return {void}
 */

Responsiville.Debug.showDebugUIDimensions = function () {

    var responsiville = Responsiville.Main.getInstance();

    if ( ! responsiville.options.debugUI ) {
        return; 
    }

    this.$debugPerformance.html( 
        '<p>' +
            window.innerWidth + 'x' + window.innerHeight + 'px ' + 
            responsiville.currentBreakpoint.name + ' ' + 
            '<span class = "responsiville-debug-dimensions-icon ' + responsiville.currentBreakpoint.name + '">' + 
                responsiville.currentBreakpoint.icon + 
            '</span> ' + 
        '</p>'
    );

};



/**
 * Shows the most significant page loading performance statistics inside the
 * Responsiville debug panel (like DOMContentReady and load events).
 * 
 * @return {void}
 */

Responsiville.Debug.showDebugLoadPerformance = function () {

    // Get the performance data.

    var performance = 
        window.performance || 
        window.mozPerformance || 
        window.msPerformance || 
        window.webkitPerformance;

    var responseStart    = ( ( performance.timing.responseStart            - performance.timing.requestStart ) / 1000 ).toFixed( 2 );
    var responseEnd      = ( ( performance.timing.responseEnd              - performance.timing.requestStart ) / 1000 ).toFixed( 2 );
    var domLoading       = ( ( performance.timing.domLoading               - performance.timing.requestStart ) / 1000 ).toFixed( 2 );
    var domInteractive   = ( ( performance.timing.domInteractive           - performance.timing.requestStart ) / 1000 ).toFixed( 2 );
    var domContentLoaded = ( ( performance.timing.domContentLoadedEventEnd - performance.timing.requestStart ) / 1000 ).toFixed( 2 );
    var domComplete      = ( ( performance.timing.domComplete              - performance.timing.requestStart ) / 1000 ).toFixed( 2 );
    var load             = ( ( performance.timing.loadEventEnd             - performance.timing.requestStart ) / 1000 ).toFixed( 2 );

    var responseStartDiff    = ( responseStart    - 0                ).toFixed( 2 );
    var domContentLoadedDiff = ( domContentLoaded - responseStart    ).toFixed( 2 );
    var loadDiff             = ( load             - domContentLoaded ).toFixed( 2 );



    // Add it to the debug panel.
    
    jQuery( '.responsiville-debug-performance' ).html( 

        '<table class = "vanilla" cellspacing = "0" cellpadding = "0">' +
            '<thead>' +
                '<tr>' +
                    '<th></th><th></th><th>Time</th><th>dt</th>' +
                '<tr>' +
            '</thead>' +
            '<tbody>' + 
                
                // Request sent.

                '<tr title = "Browser sends the request">' + 
                    '<td>Request Start</td><td>&mdash;&gt;' + '</td><td>' + '0.00' + '</td><td>' + '&mdash;' + '</td>' + 
                '</tr>' + 

                // Requested started receiving.

                '<tr title = "Time to first byte - browser received the first byte of the response">' + 
                    '<td>TtFB</td><td>&mdash;&gt;' + '</td><td>' + responseStart + '</td><td>' + responseStartDiff + '</td>' + 
                '</tr>' + 
                            
                // DOM and CSSOM is ready.

                '<tr title = "Synchronous scripts run, DOM &amp; CSSOM ready, render tree formed">' + 
                    '<td>DOMContentLoaded</td><td>&mdash;&gt;' + '</td><td>' + domContentLoaded + '</td><td>' + domContentLoadedDiff + '</td>' + 
                '</tr>' + 

                // Page fully loaded.

                '<tr title = "Page is fully loaded and rendered, images are loaded">' + 
                    '<td>Load</td><td>&mdash;&gt;' + '</td><td>' + load + '</td><td>' + loadDiff + '</td>' +
                '</tr>' +
            
            '</tbody>' + 
        '</table>'

    );

};



/**
 * Opens up the Responsiville debug panel.
 * 
 * @return {void}
 */

Responsiville.Debug.openDebugPanel = function () {

    this.$debugToggle.removeClass( 'responsiville-debug-toggle-closed' );
    this.$debugControls.removeClass( 'responsiville-debug-controls-closed' );

    Responsiville.Main.getInstance().setProperty( 'debug-panel-on', true );

};




/**
 * Closes the Responsiville debug panel.
 * 
 * @return {void}
 */

Responsiville.Debug.closeDebugPanel = function () {

    this.$debugToggle.addClass( 'responsiville-debug-toggle-closed' );
    this.$debugControls.addClass( 'responsiville-debug-controls-closed' );

    Responsiville.Main.getInstance().setProperty( 'debug-panel-on', false );

};