jQuery( function ( $ ) {

    // Fix CSS vars support shim on every breakpoint change.
    
    FixCSSVars.debug = VANILLA.DEBUG;
    FixCSSVars.exec();

    Responsiville.Main.getInstance().on( 'change', function () {

        FixCSSVars.exec();

    });


    
    
    // Thumbnail popups in galleries.
    
    $( '.gallery' ).each( function () {

        $( 'a', this ).anchorPopup();
    
    });

    // Thumbnail popups in captioned images.
    
    $( '.wp-caption a' ).anchorPopup();

    // Thumbnail popups in usual images.
        
    $( '[class*=size]' ).each( function () {

        var $parent = $( this ).parent();

        if (   $parent.is( 'a' ) && 
             ! $parent.parent().is( '.wp-caption' ) &&
             ! $parent.parent().is( '.gallery-icon' ) ) {

            $parent.anchorPopup();

        }

    });



    // Responsive videos, maps, slides, iframes inside text.
    
    $( '.text iframe' ).each( function () {

        $( this ).parent().addClass( 'video-wrapper ratio-16x9' );
    
    });



    // Fix greek uppercase characters.
    
    $( '.forum-titles li, .page-container h1, .sidebar-menu li a, .widgettitle, .post-category a, .more-news h2, .read-more, footer h4, #footer-navigation li a, .bbp-breadcrumb p, bbp-breadcrumb-current' ).greekUppercase();



    // Responsive tables. 
    
    // $( '.text table' ).wrap( '<div class = "responsive-table"/>' );

    /*
        .responsive-table {
            overflow-x: auto;
        }
    */

});