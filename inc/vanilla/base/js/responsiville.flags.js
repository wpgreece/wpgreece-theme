/**
 * These Javascript flags act as an intermediate between a theme that is Vanilla
 * enabled and uses the Responsiville framework. It declares Javascript flags
 * needed by Responsiville, but are declared in PHP flags in the Vanilla enabled
 * theme and have then been localised to Javascript via `wp_localize_script`.
 */

    RESPONSIVILLE_AUTO_INIT = VANILLA.RESPONSIVILLE_AUTO_INIT;
    RESPONSIVILLE_DEBUG     = VANILLA.RESPONSIVILLE_DEBUG;

/*  ^^^ Responsiville         ^^^ PHP flags localised
 *      global flags              in Javascript
 **/