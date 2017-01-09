/**
 * Shortcode JS
 * All the JS that's required for all the shortcode goodness to work well.
 */

jQuery( function ( $ ) {

    // Slideshows
    $( '.nevma-slideshow' ).slideshow({
        slide: '.slide',
        next: '.next',
        previous: '.prev',
        navigation: '.slideshow-nav a',
        navigationSelectedClass: 'selected',
        slideshow: false,
        slideshowSpeed: 3000,
        slideshowForward: true,
        startFromIndex: 1,
        transition: 'fade',
        transitionSpeed: 400,
        mouseOverFreeze: true,
        resizeMode: 'auto',
    });

    // Accordions
    var allTitles = $( '.nevma-accordion > .panel-title' );
    var allPanels = $( '.nevma-accordion > .panel' ).hide();

    // Open any slides that are open by default
    panelState( $( '.nevma-accordion > .panel-title.active'), $( '.nevma-accordion > .panel.active'), 'open' );

    $( '.nevma-accordion > .panel-title' ).click(function() {
        
        var trigger = $( this );
        var target = trigger.next();

        if ( ! target.hasClass( 'active' ) ){
            panelState( trigger, target, 'open');
        } else {
            panelState( trigger, target, 'close');
        }

        return false;
    });

    function panelState( trigger, target, action ){
        if ( action == 'open' ){
            allTitles.removeClass( 'active' );
            allPanels.removeClass( 'active' ).slideUp();

            target.addClass( 'active' ).slideDown();
            trigger.addClass( 'active' );
        } else {
            allPanels.removeClass( 'active' ).slideUp();
            
            trigger.removeClass( 'active' );            
            target.removeClass( 'active' ).slideUp();
        }
    }

    // Use Chosen on select fields if the Chosen plugin is loaded.
    function loadChosen( elements ){
        if ( $.isFunction( $.fn.chosen ) ) {
            elements.chosen({ 
                disable_search_threshold: 5
            });
        }
    }

    // Use Chosen on non-GF select fields
    var nonGformSelects = $( 'form select' ).not( '.gform_wrapper select' );
    loadChosen( nonGformSelects );

    // Fire this each time a Gravity From is rendered (even after ajax submissions).
    $( document ).bind( 'gform_post_render', function( event, formID ){ 

        // Use Chosen on this form's select fields.        
        var gformSelects = $( '#gform_' + formID + ' select' );
        loadChosen( gformSelects );

    });

});