/**
 * Scope which encapsulates and runs the initialisation scripts of the main
 * Responsiville object and all the Responsiville modules.
 *
 * @namespace Responsiville.Run
 */



// Responsiville Responsiveelement auto initialise (let's keep this first).

if ( Responsiville.Responsiveelement.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Responsiveelement.autoRun();
    });

}



// Responsiville Scrollmenu auto initialise (run it before Mobimenu and Megamenu).

if ( Responsiville.Scrollmenu.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Scrollmenu.autoRun();
    });

}



// Responsiville Mobimenu auto initialise.

if ( Responsiville.Mobimenu.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Mobimenu.autoRun();
    });

}



// Responsiville Megamenu auto initialise.

if ( Responsiville.Megamenu.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Megamenu.autoRun();
    });

}



// Responsiville Drawers auto initialise.

if ( Responsiville.Drawers.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Drawers.autoRun();
    });

}



// Responsiville Slideshow auto initialise.

if ( Responsiville.Slideshow.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Slideshow.autoRun();
    });

}



// Responsiville Accordion auto initialise.

if ( Responsiville.Accordion.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Accordion.autoRun();
    });

}



// Responsiville Parallax auto initialise.

if ( Responsiville.Parallax.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Parallax.autoRun();
    });

}



// Responsiville Equalheights auto initialise.

if ( Responsiville.Equalheights.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Equalheights.autoRun();
    });

}



// Responsiville Popup auto initialise.

if ( Responsiville.Popup.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Popup.autoRun();
    });

}



// Responsiville Lazymg auto initialise.

if ( Responsiville.Lazymg.AUTO_RUN ) {

    Responsiville.Main.getInstance().on( 'init', function () {
        Responsiville.Lazymg.autoRun();
    });

}