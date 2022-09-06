jQuery( function ( $ ) {

    // Fix CSS vars support shim once in the beginning.
    
    FixCSSVars.debug = VANILLA.DEBUG;
    FixCSSVars.exec();

    // Fix CSS vars support shim on every breakpoint change.
    
    Responsiville.Main.getInstance().on( 'change', function () {

        FixCSSVars.exec();

    });

});