/*******************************************************************************
 *
 * These Javascript flags act as an intermediate between a theme that is Vanilla
 * enabled and uses the Responsiville framework. It declares Javascript flags
 * needed by Responsiville, but are declared in PHP flags in the Vanilla enabled
 * theme and have then been localised to Javascript via `wp_localize_script`.
 */

    RESPONSIVILLE_AUTO_INIT    =    RESPONSIVILLE.AUTO_INIT;
    RESPONSIVILLE_DEBUG        =    RESPONSIVILLE.DEBUG;

//  ^^^ Responsiville               ^^^ PHP flag localised
//      Javascript flag                 in Javascript
// 
//******************************************************************************