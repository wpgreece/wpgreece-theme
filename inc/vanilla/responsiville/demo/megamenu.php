<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Responsiville Megamenu</h1>

        <p>
            The megamenu implements what has come to be known as a -well- &quot;mega menu&quot;. A megamenu consists of an element that activates it and an element that opens up when the first element is activated. The activation trigger is usually a mouseover on the activator element. The element which opens up can be anything from a a simple list of links to a complex HTML element.
        </p>

        <p>
            The most common example of a megamenu is a dropdown list of links.
        </p>

        <p>
            Here is an example, with a nested unordered list of links. Whereever an anchor element has a sibling unordered list with links, then this anchor is marked with a <code>responsiville-megamenu</code> class. It is this anchor that is the megamenu and, when it is hovered on, the hidden menu element appears:
        </p>

        <pre><code class = "language-markup"><!--
            <nav class="navigation horizontal">
                <ul>
                    <li>
                        <a href="#" class="responsiville-megamenu">Menu 1</a>
                        <ul>
                            <li><a href="#">Menu 1-1</a></li>
                            <li><a href="#">Menu 1-2</a></li>
                            <li><a href="#">Menu 1-3</a></li>
                            <li><a href="#">Menu 1-4</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="responsiville-megamenu">Menu 2</a>
                        <ul>
                            <li><a href="#">Menu 2-1</a></li>
                            <li><a href="#">Menu 2-2</a></li>
                            <li><a href="#">Menu 2-3</a></li>
                            <li><a href="#">Menu 2-4</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="responsiville-megamenu">Menu 3</a>
                        <ul>
                            <li><a href="#">Menu 3-1</a></li>
                            <li><a href="#">Menu 3-2</a></li>
                            <li><a href="#">Menu 3-3</a></li>
                            <li><a href="#">Menu 3-4</a></li>
                            <li><a href="#">Menu 3-5</a></li>
                            <li><a href="#">Menu 3-6</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        --></code></pre>

        <p>
            If nothing else is defined then, by default, the first sibling of the activator element is considered to be the container for the megamenu contents. But it is up the developer to set something else.
        </p>

        <p>
            Here is how one could create a megamenu in a non-automatic way:
        </p>

        <pre><code class = "language-javascript">
            var megamenu = new Responsiville.Megamenu({
                activator : '.responsiville-megamenu',
                element   : '.responsiville-megamenu-element',
                enter     : 'laptop, desktop, large, xlarge',
                leave     : 'small, mobile, tablet'
            });
        </code></pre>



        <h2>API data attribute</h2>

        <p>
            If the megamenu has not been created manually, which is the easiest and most common case, one can obtain an instance of the underlying <code>Responsiville.Megamenu</code> Javascript object, so that it can manipulate the megamenu via its API, by accessing its <code>responsiville-megamenu-api</code> data attribute, like this:
        </p>
        <pre><code class = "language-javascript">
            // Obtain the underlying Responsiville.Megamenu Javascript object.
            var megamenu = $( '.responsiville-megamenu' ).data( 'responsiville-megamenu-api' );
        </code></pre>



        <h2>Default values</h2>

        <p>
            Here is its full list of settings and default values:
        </p>

        <script type = "text/javascript">
            document.write(
                '<pre><code class = "language-json">' +
                    js_beautify( JSON.stringify( Responsiville.Megamenu.defaults ) ) +
                '</code></pre>'
            );
        </script>

        <p>
            <a href = "http://vanilla.nevma.gr/wp-content/docs/responsiville-jsdoc/" title = "Responsiville Javascript API" target = "_blank" class = "button">Responsiville Javascript API</a>
        </p>



        <h2>Working examples</h2>

        <p>
            Here is a full, everyday working example based on the above case:
        </p>

        <style type = "text/css">
            .responsiville-megamenu-example {
                margin-bottom: var(--vertical-rhythm);
            }
                .responsiville-megamenu-example ul ul {
                    display: none;
                }
                .responsiville-megamenu-example ul,
                .responsiville-megamenu-example li {
                    padding: 0 !important;
                    margin: 0 !important;
                    list-style-type: none;
                    background-color: white;
                }
                .responsiville-megamenu-example li {
                    margin-right: 2rem !important;
                }
                .responsiville-megamenu-example li li {
                    margin-right: 0 !important;
                }
                    .responsiville-megamenu-example a {
                        padding: 0 !important;
                        border: none;
                        white-space: nowrap;
                        word-break: keep-all;
                    }
        </style>

        <nav class = "navigation horizontal responsiville-megamenu-example clear">
            <ul>
                <li>
                    <a href = "#" class = "responsiville-megamenu">Menu 1</a>
                    <ul>
                        <li><a href = "#">Menu 1-1</a></li>
                        <li><a href = "#">Menu 1-2</a></li>
                        <li><a href = "#">Menu 1-3</a></li>
                        <li><a href = "#">Menu 1-4</a></li>
                    </ul>
                </li>
                <li>
                    <a href = "#" class = "responsiville-megamenu">Menu 2</a>
                    <ul>
                        <li><a href = "#">Menu 2-1</a></li>
                        <li><a href = "#">Menu 2-2</a></li>
                        <li><a href = "#">Menu 2-3</a></li>
                        <li><a href = "#">Menu 2-4</a></li>
                    </ul>
                </li>
                <li>
                    <a href = "#" class = "responsiville-megamenu">Menu 3</a>
                    <ul>
                        <li><a href = "#">Menu 3-1</a></li>
                        <li><a href = "#">Menu 3-2</a></li>
                        <li><a href = "#">Menu 3-3</a></li>
                        <li><a href = "#">Menu 3-4</a></li>
                        <li><a href = "#">Menu 3-5</a></li>
                        <li><a href = "#">Menu 3-6</a></li>
                    </ul>
                </li>
            </ul>
        </nav>



        <h3>Vertical menu, horizontal megamenu</h3>

        <p>
            The menu is now laid out in a vertical arrangement, so the megamenus flow better from left to right, rather than from top to bottom. We use the <code>slide-ltr</code> slide effect for this. 
        </p>

        <style type = "text/css">
            .responsiville-megamenu-example-vertical ul {
                display: inline-block;
            }
            .responsiville-megamenu-example-vertical ul ul {
                top: 0;
                left: 100%;
            }
                .responsiville-megamenu-example-vertical li {
                    display: inline-block;
                }
                    .responsiville-megamenu-example-vertical a {
                        display: inline-block;
                    }
        </style>

        <nav class = "navigation vertical responsiville-megamenu-example responsiville-megamenu-example-vertical clear">
            <ul>
                <li>
                    <a href = "#" class = "responsiville-megamenu" data-responsiville-megamenu-effect = "slide-ltr">Menu 1</a>
                    <ul>
                        <li><a href = "#">Menu 1-1</a></li>
                        <li><a href = "#">Menu 1-2</a></li>
                        <li><a href = "#">Menu 1-3</a></li>
                        <li><a href = "#">Menu 1-4</a></li>
                    </ul>
                </li>
                <li>
                    <a href = "#" class = "responsiville-megamenu" data-responsiville-megamenu-effect = "slide-ltr">Menu 2</a>
                    <ul>
                        <li><a href = "#">Menu 2-1</a></li>
                        <li><a href = "#">Menu 2-2</a></li>
                        <li><a href = "#">Menu 2-3</a></li>
                        <li><a href = "#">Menu 2-4</a></li>
                    </ul>
                </li>
                <li>
                    <a href = "#" class = "responsiville-megamenu" data-responsiville-megamenu-effect = "slide-ltr">Menu 3</a>
                    <ul>
                        <li><a href = "#">Menu 3-1</a></li>
                        <li><a href = "#">Menu 3-2</a></li>
                        <li><a href = "#">Menu 3-3</a></li>
                        <li><a href = "#">Menu 3-4</a></li>
                        <li><a href = "#">Menu 3-5</a></li>
                        <li><a href = "#">Menu 3-6</a></li>
                    </ul>
                </li>
            </ul>
        </nav>



        <h3>Menu with larger elements</h3>

        <p>
            And here is an example with some larger elements:
        </p>

        <pre><code class = "language-markup"><!--
            <style type="text/css">
                .responsiville-megamenu-example .submenu {
                    width: 50vw !important;
                    padding-bottom: 2rem !important;
                    background-color: white;
                }
            </style>

            <nav class="navigation horizontal">
                <ul>
                    <li>
                        <a href="#">Menu 1</a>
                    </li>
                    <li>
                        <a href="#" class="responsiville-megamenu">Menu 2</a>
                        <div class="row submenu">
                            <div class="small-column-33">
                                <strong>Title 1</strong> <br />
                                Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                                <a href="#">A link 1</a>
                            </div>
                            <div class="small-column-33">
                                <strong>Title 2</strong> <br />
                                Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                                <a href="#">A link 2</a>
                            </div>
                            <div class="small-column-33">
                                <strong>Title 3</strong> <br />
                                Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor. <br />
                                <a href="#">A link 3</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="#">Menu 3</a>
                    </li>
                </ul>
            </nav>
        --></code></pre>

        <p>
            Which renders something like this:
        </p>

        <style type = "text/css">
            .responsiville-megamenu-example .submenu {
                width: 50vw !important;
                background-color: white;
            }
                .responsiville-megamenu-external-example-container {
                    padding: 1em 0;
                }
        </style>

        <nav class = "navigation horizontal responsiville-megamenu-example clear">
            <ul>
                <li>
                    <a href = "#">Menu 1</a>
                </li>
                <li>
                    <a href = "#" class = "responsiville-megamenu">Menu 2</a>
                    <div class = "row submenu">
                        <div class = "clear responsiville-megamenu-external-example-container">
                            <div class = "small-column-33">
                                <strong>Title 1</strong> <br />
                                Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                                <a href = "#" title = "">A link 1</a>
                            </div>
                            <div class = "small-column-33">
                                <strong>Title 2</strong> <br />
                                Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                                <a href = "#" title = "">A link 2</a>
                            </div>
                            <div class = "small-column-33">
                                <strong>Title 3</strong> <br />
                                Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor. <br />
                                <a href = "#" title = "">A link 3</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href = "#">Menu 3</a>
                </li>
            </ul>
        </nav>

        <p>
            It is worth noticing that the megamenu module sets special classes on the elements of the megamenu to indicate their <strong>states</strong>, so that one can control their styling as they see fit at any point. These classes refer to the activator element, as well as the the actual menu that opens and closes and their states, ie opening, open, closing, closed, active, etc.
        </p>



        <h3>External megamenu</h3>

        <p>
            Usually, and this is the default, the element which consists the megamenu itself lies under the same parent as the activator element, ie they are siblings. This sometimes poses restrictions on how the megamenu can be styled. It is possible for the megamenu to lie somewhere <strong>externally</strong>, ie anywhere in the page. This can be designated with the <code>external</code> property.
        </p>

        <pre><code class = "language-markup"><!--
            <style type="text/css">
                .responsiville-megamenu-external-example {
                    padding-bottom: 2rem !important;
                    background-color: white;
                }
            </style>

            <nav class="navigation horizontal">
                <ul>
                    <li>
                        <a href="#">Menu 1</a>
                    </li>
                    <li>
                        <a href="#" class="responsiville-megamenu" 
                                    data-responsiville-megamenu-external="true"
                                    data-responsiville-megamenu-element=".responsiville-megamenu-external-example">
                            Menu 2
                        </a>
                    </li>
                    <li>
                        <a href="#">Menu 3</a>
                    </li>
                </ul>
            </nav>

            <div class="row responsiville-megamenu-external-example">
                <div class="small-column-33">
                    <strong>Title 1</strong> <br />
                    Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                    <a href="#">A link 1</a>
                </div>
                <div class="small-column-33">
                    <strong>Title 2</strong> <br />
                    Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                    <a href="#">A link 2</a>
                </div>
                <div class="small-column-33">
                    <strong>Title 3</strong> <br />
                    Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor. <br />
                    <a href="#">A link 3</a>
                </div>
            </div>
        --></code></pre>

        <p>
            Which renders something like this:
        </p>

        <style type = "text/css">
            .responsiville-megamenu-external-example {
                background-color: white;
            }
                .responsiville-megamenu-external-example-container {
                    padding: 1em 0;
                }
        </style>

        <nav class = "navigation horizontal responsiville-megamenu-example clear">
            <ul>
                <li>
                    <a href = "#" class = "responsiville-megamenu">Menu 1</a>
                </li>
                <li>
                    <a href = "#" class = "responsiville-megamenu" 
                                  data-responsiville-megamenu-external = "true"
                                  data-responsiville-megamenu-element = ".responsiville-megamenu-external-example">
                        Menu 2
                    </a>
                </li>
                <li>
                    <a href = "#" class="responsiville-megamenu">Menu 3</a>
                </li>
            </ul>
            <div class = "row responsiville-megamenu-external-example">
                <div class = "clear responsiville-megamenu-external-example-container">
                    <div class = "small-column-33">
                        <strong>Title 1</strong> <br />
                        Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                        <a href = "#" title = "">A link 1</a>
                    </div>
                    <div class = "small-column-33">
                        <strong>Title 2</strong> <br />
                        Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                        <a href = "#" title = "">A link 2</a>
                    </div>
                    <div class = "small-column-33">
                        <strong>Title 3</strong> <br />
                        Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor. <br />
                        <a href = "#" title = "">A link 3</a>
                    </div>
                </div>
            </div>
        </nav>

        <p>
            Now the megamenu element can be styled beyond the strict boundaries of the activator&apos;s container. Unfortunately, although being quite powerful, this method requires some extra CSS styling by the developer for the megamenu, because its default stying no longer holds outside its boundaries.
        </p>



    </article>



<?php include( 'footer.php' ); ?>