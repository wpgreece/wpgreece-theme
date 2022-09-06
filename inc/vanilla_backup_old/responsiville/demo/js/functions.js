jQuery( function () {

    // Setup navigation between sections based on the available sections.

    var navigation_html = '';

    jQuery( 'section' ).each( function () {
    
        var title = jQuery( this ).find( 'h1' ).text();
        var id    = jQuery( this ).attr( 'id' );

        if ( ! title || ! id ) {
            
            return;

        }

        navigation_html += '<li><a href = "#' + id + '" title = "' + title + '">' + title + '</a></li>';
        
    });
    
    jQuery( '.main-navigation ul' ).html( navigation_html );
    
    

    // Menu selected action handler.
    
    jQuery( '.main-navigation a' ).on( 'click', function () {
        
        var $this = jQuery( this );
        
        jQuery( '.main-navigation a' ).removeClass( 'selected' );
        $this.addClass( 'selected' );

        jQuery( 'section' ).removeClass( 'target' );

    });
    
    

    // Show the selected section or the first available section on load.

    if ( window.location.hash == '' ) {

        jQuery( '.main-navigation a' ).removeClass( 'selected' );
        jQuery( '.main-navigation a' ).eq( 0 ).addClass( 'selected' );
        jQuery( 'section' ).eq( 0 ).addClass( 'target' );
        
    } else {
        
        jQuery( '.main-navigation a' ).removeClass( 'selected' );
        jQuery( '.main-navigation a' ).filter( '[href="' + window.location.hash + '"]' ).addClass( 'selected' );
        jQuery( window.location.hash ).addClass( 'target' );
        
    }

});