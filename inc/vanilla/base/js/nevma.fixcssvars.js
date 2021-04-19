/**
 * Namespace for functions related to fixing CSS variables in browsers that do 
 * not support them. Reads the CSS variables declared to the root element (that
 * is the :root, ie the HTML element) and inserts on the fly a new stylesheet
 * with all the CSS selectors which use CSS variables, but with the CSS 
 * variables replaced with their actual effective values. This way one can have
 * dynamic (ie responsive) CSS variables to their elements. The only convention
 * made so far is that the CSS variables may only be declared on the root 
 * element and all other CSS variables will be ignored. The reason for this is
 * that we cannot yet combine the CSS variables from multiple active elements on
 * the web page. In order to achieve this we use the CSSutilities library which
 * has to make an AJAX request for each CSS file on the page and read it anew
 * because the browser will have ignored every rule with CSS variables, since we
 * are talking for browsers that do not support them. With proper caching this
 * should not produce any noticeable overhead.
 *
 * @namespace FixCSSVars
 */

var FixCSSVars = {};



/**
 * Controls the debug option of the namespace functions.
 * 
 * @type {boolean}
 */

FixCSSVars.debug = false;



/**
 * The ID of the CSS stylesheet element which will contain the CSS rules with
 * CSS variables replaced by their effective values.
 * 
 * @type {String}
 */

FixCSSVars.cssID = 'fixcssvars-css';



/**
 * Checks whether CSS variables are supported.
 * 
 * @return {boolean} Whether CSS variables are supporrted.
 */

FixCSSVars.supported = function () {

    // Create a dummy element with a CSS variable and then query it to see if the CSS variable has had effect.

    var $testElement = jQuery( '<span style = "--test-var: 999px; font-size: var(--test-var);">Fix css vars test span!</span>' ).appendTo( 'body' );
    var supported = $testElement.css( 'font-size' ) == '999px';
    
    $testElement.remove();

    FixCSSVars.debug && console.log( 'CSS variables supported: ' + supported );

    return supported;

};



/**
 * Takes an element and returns all the CSS variables that are effective on it 
 * at the given time and their values. This means that all cascades are taken
 * care of and only active rules are returned.
 *
 * @param {string|Element} element The element or selector whose CSS variables
 *                                 are to be retrieved.
 * 
 * @return {Object} Associative array with CSS variables and their values.
 */

FixCSSVars.getCSSVariablesByElement = function ( element ) {

    // Take all CSS rule sets that are effective on the element.
            
    var cssRules = CSSUtilities.getCSSRules( jQuery( element ).get( 0 ), 'all', 'properties' );

    var cssVariables = {};



    // Iterate over these rule sets.

    for ( var k = 0; k < cssRules.length; k++ ) {

        var cssRule = cssRules[k];
        var properties = cssRule.properties;

        // For each rule set iterate over its rules.

        for ( var property in properties ) {

            var propertyObject = properties[property];

            // Keep the ones that actually declare CSS variables.

            if ( property.indexOf( '--' ) != 0 ) {
                continue;
            }


            if ( propertyObject.status != 'active' ) {
                continue;
            }
            
            cssVariables[property] = propertyObject.value;

        }

    }



    // Check for nested CSS variables.
    
    var nestedCSSVariablesExist = true;
    var maxNestLevel = 10;
    var level = 1; 

    while ( nestedCSSVariablesExist ) {

        nestedCSSVariablesExist = false;

        // Iterate all CSS variables and search for CSS variables in them.

        for ( var property in cssVariables ) {

            var value = cssVariables[property];
            var hasNestedCSSVariables = value.indexOf( 'var(' ) > -1;

            nestedCSSVariablesExist = nestedCSSVariablesExist || hasNestedCSSVariables;

            // CSS variable does contain nested CSS variables. 

            if ( hasNestedCSSVariables ) {

                // Replace all possible CSS variables in its value.

                for ( var p in cssVariables ) {

                    var v = cssVariables[p];
                    value = value.replace( 'var(' + p + ')', v );
                    value = value.replace( new RegExp( 'var\\(' + p + '\\)', 'gi' ), v );

                }
                
                cssVariables[property] = value;

            }

        }

        level++;


        if ( level > maxNestLevel ) {
            break;
        }

    }

    FixCSSVars.debug && console.log( 'CSS variables for element ' + element + ':' );
    FixCSSVars.debug && console.dir( cssVariables );

    return cssVariables;

};



/**
 * Gets all the CSS rules of the current page which contain CSS variables.
 * 
 * @return {Array} An array of all the CSS rules of the page which contain CSS
 *                 variables as objects of the form { name, rule, value }.
 */

FixCSSVars.getCSSSelectorsWithVariables = function () {

    // Get all CSS rule sets on the page.

    var cssRules = CSSUtilities.getCSSStyleSheetRules();

    var selectorsWithVariables = [];

    

    // Iterate over them.

    for ( var k = 0; k < cssRules.length; k++ ) {

        var cssRule = cssRules[k];
        var properties = cssRule.properties;

        // For each rule set iterate over its rules.

        for ( var property in properties ) {

            var value = properties[property];

            // Keep the ones that use CSS variables in their values.

            if ( value.indexOf( 'var(' ) < 0 ) {
                continue;
            }
            
            selectorsWithVariables.push({
                name: cssRule.selector,
                rule: property,
                value: value
            });

        }

    }

    FixCSSVars.debug && console.log( 'CSS selectors with variables:' );
    FixCSSVars.debug && console.dir( selectorsWithVariables );



    return selectorsWithVariables;

};



/**
 * Generates a new stylesheet at the end of the HEAD element which contains all
 * CSS rules that normally contained CSS variables, only now the CSS variables
 * have been replaced by their actual effective values.
 *
 * @return {void}
 */

FixCSSVars.generateShimCSS = function () {

    // Get all the variables declared on the root element.

    var rootVars = FixCSSVars.getCSSVariablesByElement( ':root' );

    // Get all the CSS rules with CSS variables in their values.

    var selectorsWithVariables = FixCSSVars.getCSSSelectorsWithVariables();

    

    // Iterate over the CSS rules with variables in their values to generate the shim CSS.

    var shimCSS = '';

    for ( var k = 0; k < selectorsWithVariables.length; k++ ) {

        var selectorWithVariables = selectorsWithVariables[k];

        shimCSS += selectorWithVariables.name + " { ";
        shimCSS += selectorWithVariables.rule + ": ";

        var value = selectorWithVariables.value;

        // Replace every CSS variable with its efffective value based on the root element.

        for ( var rootVar in rootVars ) {
            value = value.replace( new RegExp( 'var\\(' + rootVar + '\\)', 'gi' ), rootVars[rootVar] );
        }

        shimCSS += value + "; }\n\n";

    }

    FixCSSVars.debug && console.log( 'CSS shim generated: ' );
    FixCSSVars.debug && console.log( shimCSS );



    // Create and append a new CSS stylesheet where CSS variables have been replaced with their effective values.    

    var head  = jQuery( 'head' ).get( 0 );

    var style = document.createElement( 'style' );
    style.id = FixCSSVars.cssID;
    style.type = 'text/css';



    // Remove previous stylesheet if already generated before.

    jQuery( '#' + FixCSSVars.cssID ).remove();

    if ( style.styleSheet ) {
        style.styleSheet.cssText = shimCSS;
    } else {
        style.appendChild( document.createTextNode( shimCSS ) );
    }



    // Append shim CSS to head.

    head.appendChild( style );
    
};



/**
 * Checks if CSS variables are supported and, if not, generates the shim CSS.
 *
 * @return {void}
 */

FixCSSVars.exec = function () {

    if ( FixCSSVars.supported() ) {
        return;
    }

    FixCSSVars.debug && console.log( 'Loading CSSUtilities library' );

    CSSUtilities.define( 'mode', 'author' );
    CSSUtilities.define( 'async', true );

    CSSUtilities.init( function () {

        FixCSSVars.debug && console.log( 'CSSUtilities library loaded' );
        FixCSSVars.generateShimCSS();

        // After the CSS variables have been replaced, run the equalheights script once again, just in case. 
        
        jQuery( '.responsiville-equalheights' ).each( function () {
            jQuery( this ).data( 'responsiville-equalheights-api' ).runElements(); 
        });

    });

};