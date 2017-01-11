<!DOCTYPE html>

<html lang = "en">

    <head>



        <meta charset = "utf-8" />
        <meta name = "viewport" content = "width=device-width, initial-scale=1, user-scalable=1, minimal-ui" />
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1" />
        <title>Responsiville &mdash; Grid system, CSS reset, HTML5 framework, by Nevma &copy;</title>
        <link rel = "shortcut icon" type = "image/ico" href = "http://www.nevma.gr/favicon.ico" />



        <!-- Responsiville CSS declarations -->

        <link rel = "stylesheet" type = "text/css" href = "../css/responsiville.def.css" />
        <link rel = "stylesheet" type = "text/css" href = "../css/responsiville.bugsy.css" />
        <link rel = "stylesheet" type = "text/css" href = "../css/responsiville.moressette.css" />
        <link rel = "stylesheet" type = "text/css" href = "../css/responsiville.ingrid.css" />
        <link rel = "stylesheet" type = "text/css" href = "../css/responsiville.accordion.css" />
        <link rel = "stylesheet" type = "text/css" href = "../css/responsiville.megamenu.css" />
        <link rel = "stylesheet" type = "text/css" href = "../css/responsiville.mobimenu.css" />
        <link rel = "stylesheet" type = "text/css" href = "../css/responsiville.scrollmenu.css" />
        <link rel = "stylesheet" type = "text/css" href = "../css/responsiville.slideshow.css" />

        <!-- Third party CSS decarlations -->

        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css?family=Averia+Serif+Libre:300,300i">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css?family=Anonymous+Pro:400,400i">

        <link rel = "stylesheet" type = "text/css" href = "prism/prism.css" />

        <!-- Current page styles -->

        <link rel = "stylesheet" type = "text/css" href = "css/style1.css" />



        <!-- Third party Javascript libraries -->

        <script type = "text/javascript" charset = "utf-8" src = "js/jquery-3.1.0.min.js"></script>

        <script type = "text/javascript" charset = "utf-8" src = "../../base/js/velocity.min.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../../base/js/hammer.min.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../../base/js/jquery.hammer.js"></script>

        <script type = "text/javascript" charset = "utf-8" src = "prism/prism.js"></script>

        <script type = "text/javascript" charset = "utf-8" src = "beautify/beautify.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "beautify/beautify-css.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "beautify/beautify-html.js"></script>

        <!-- Responsiville Javascript files -->

        <script type = "text/javascript">

            RESPONSIVILLE_AUTO_INIT = true;
            RESPONSIVILLE_DEBUG     = true;

        </script>

        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.def.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.bugsy.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.events.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.main.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.main.run.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.accordion.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.equalheights.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.megamenu.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.mobimenu.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.scrollmenu.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.slideshow.js"></script>
        <script type = "text/javascript" charset = "utf-8" src = "../js/responsiville.run.js"></script>

        <!-- Entry script for tests -->

        <script type = "text/javascript" charset = "utf-8" src = "js/functions1.js"></script>



    </head>



    <body>

        <main class = "wrapper row">



            <aside class = "sidebar small-column-15">

                <header class = "sidebar-header row">
                    <!-- <p>
                        Responsiville &lt;{[]}&gt;
                    </p> -->
                    <div class = "column-60 center logo">
                        <img src = "img/logo.png" alt = "Responsiville" />
                    </div>
                </header>

                <!-- <h3>Menu</h3> -->
                
                <nav class = "main-navigation navigation vertical">
                    <ul>
                        <li>
                            <a href = "demo.php">About</a>
                            <ul>
                                <li><a href = "installing.php">Installing</a></li>
                                <li><a href = "initialising.php">Initialising</a></li>
                                <li><a href = "api.php">API</a></li>
                                <li><a href = "license.php">Licence</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href = "grid.php">The grid</a>
                            <ul>
                                <li><a href = "grid-building.php">Grid building</a></li>
                                <li><a href = "clearing-floats.php">Clearing floats</a></li>
                                <li><a href = "grid-debugging.php">Grid debugging</a></li>
                                <!--
                                    Grid margins
                                    Grid shifting
                                -->
                            </ul>
                        </li>
                        <li>
                            <a href = "reset.php">CSS reset</a>
                            <ul>
                                <li><a href = "typography.php">Typography</a></li>
                                <li><a href = "images.php">Images</a></li>
                                <li><a href = "videos-iframes.php">Videos &amp; iframes</a></li>
                                <li><a href = "tables.php">Tables</a></li>
                                <li><a href = "forms.php">Forms</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href = "reset.php">Javascript modules</a>
                            <ul>
                                <li><a href = "main-events.php">Main/Events</a></li>
                                <li><a href = "accordion.php">Accordion</a></li>
                                <li><a href = "equalheights.php">Equalheights</a></li>
                                <li><a href = "megamenu.php">Megamenu</a></li>
                                <li><a href = "mobimenu.php">Mobimenu</a></li>
                                <li><a href = "scrollmenu.php">Scrollmenu</a></li>
                                <li><a href = "slideshow.php">Slideshow</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav> <!-- .main-navigation -->

            </aside> <!-- .sidebar -->



            <section class = "content small-column-85 small-margin-15">



                <header class = "header-credits">
                    <p>
                        Responsiville framework &copy; 2014-<?php echo date( 'Y' ); ?> Nevma.gr
                    </p>
                </header> <!-- .header-credits -->