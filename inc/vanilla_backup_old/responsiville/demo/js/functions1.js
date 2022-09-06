jQuery( function () {

    var page = document.location.href;
    page = page.substring( page.lastIndexOf( '/' ) + 1 );

    $( '.sidebar a[href="' + page + '"]' ).
        addClass( 'selected' ).
        closest( 'ul' ).
        siblings( 'a' ).
        addClass( 'selected-parent' );

});