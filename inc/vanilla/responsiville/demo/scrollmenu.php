<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Responsiville Scrollmenu</h1>

        <p>
            The Responsiville scrollmenu is an element that becomes fixed in position, usually at the top of the screen, following the user scroll events, once the page has scrolled beyond the point where it would otherwise become non-visible. The idea is usually implemented on navigation elements, but it can actually be any kind of HTML element the developer needs.
        </p>

        <p>
            Here is an example, where one can define a scrollmenu automatically by adding the <code>responsiville-scrollmenu</code> class to it:
        </p>

        <pre><code class = "language-markup"><!--
            <nav class="navigation horizontal responsiville-scrollmenu">
                <ul>
                    <li>
                        <a href="#">Menu 1</a>
                        <ul>
                            <li><a href="#">Menu 1-1</a></li>
                            <li><a href="#">Menu 1-2</a></li>
                            <li><a href="#">Menu 1-3</a></li>
                            <li><a href="#">Menu 1-4</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Menu 2</a>
                        <ul>
                            <li><a href="#">Menu 2-1</a></li>
                            <li><a href="#">Menu 2-2</a></li>
                            <li><a href="#">Menu 2-3</a></li>
                            <li><a href="#">Menu 2-4</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Menu 3</a>
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
            Note that the designated class is added to the whole container that we want to make a scrollmenu.
        </p>

        <p>
            One should know that the scrollmenu module is a tad obtrusive in their HTML because it <strong>clones</strong> the original element that is supposed to become a scrollmenu, and acts on the clone, so that it will not interfere with its rendering in any way.
        </p>

        <p>
            Here is how one could create a scrollmenu in a non-automatic way:
        </p>

        <pre><code class = "language-javascript">
            var scrollmenu = new Responsiville.Scrollmenu({
                element : '.responsiville-scrollmenu',
                enter   : 'small, mobile, tablet',
                leave   : 'laptop, desktop, large, xlarge'
            });
        </code></pre>



        <h2>API data attribute</h2>

        <p>
            If the scrollmenu has not been created manually, which is the easiest and most common case, one can obtain an instance of the underlying <code>Responsiville.Scrollmenu</code> Javascript object, so that it can manipulate the scrollmenu via its API, by accessing its <code>responsiville-scrollmenu-api</code> data attribute, like this:
        </p>
        <pre><code class = "language-javascript">
            // Obtain the underlying Responsiville.Scrollmenu Javascript object.
            var scrollmenu = $( '.responsiville-scrollmenu' ).data( 'responsiville-scrollmenu-api' );
        </code></pre>



        <h2>Default values</h2>

        <p>
            Here is its full list of settings and default values:
        </p>

        <script type = "text/javascript">
            document.write(
                '<pre><code class = "language-json">' +
                    js_beautify( JSON.stringify( Responsiville.Scrollmenu.defaults ) ) +
                '</code></pre>'
            );
        </script>

        <p>
            <a href = "http://vanilla.nevma.gr/wp-content/docs/responsiville-jsdoc/" title = "Responsiville Javascript API" target = "_blank" class = "button">Responsiville Javascript API</a>
        </p>



        <h2>Working examples</h2>

        <p>
            Here is a full working example based on the above case:
        </p>

        <style type = "text/css">
            .responsiville-mobimenu-wrapper nav {
                min-height: 100%;
                background-color: white;
            }
            .responsiville-mobimenu-wrapper button {
                color: var(--color-gray-dark) ! important;
            }
                .responsiville-megamenu-example ul ul {
                    display: none;
                }
                .responsiville-megamenu-example ul,
                .responsiville-megamenu-example li {
                    padding: 0 ! important;
                    margin: 0 ! important;
                    display: block ! important;
                    list-style-type: none;
                }
                .responsiville-megamenu-example li {
                    margin-right: 2rem ! important;
                    padding: 0.5rem 1rem ! important;
                    background-color: white;
                }
                .responsiville-megamenu-example li li {
                    padding: 0.5rem 1rem ! important;
                    margin-right: 0 ! important;
                }
                    .responsiville-megamenu-example ul a {
                        padding: 0 ! important;
                        border: none;
                        white-space: nowrap;
                        word-break: keep-all;
                        color: var(--color-gray-dark) ! important;
                    }
        </style>

        <p>
            Now, in order for the menu below to display its behaviour as a scrollmenu, one has to scroll down the page enough for it to be <strong>&quot;scrolled out of sight&quot;</strong>. This means that the user has to scroll down at least that much so the menu is no more in the viewable part of the screen.
        </p>

        <div class = "grid-showcase">
            <div class = "row" data-info = ".row">
                <div class = "column-100 with-contents" data-info = ".column-100">
                    <div class = "the-contents">
                        <div class = "responsiville-scrollmenu responsiville-megamenu-example"
                             data-responsiville-scrollmenu-zindex = "1000">
                            <nav class = "navigation horizontal responsiville-mobimenu clear">
                                <ul>
                                    <li>Menu (A):</li>
                                    <li>
                                        <a href = "#" class = "responsiville-megamenu">Menu 1</a>
                                        <ul>
                                            <li><a href = "#">Menu A.1-1</a></li>
                                            <li><a href = "#">Menu A.1-2</a></li>
                                            <li><a href = "#">Menu A.1-3</a></li>
                                            <li><a href = "#">Menu A.1-4</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href = "#" class = "responsiville-megamenu">Menu 2</a>
                                        <ul>
                                            <li><a href = "#">Menu A.2-1</a></li>
                                            <li><a href = "#">Menu A.2-2</a></li>
                                            <li><a href = "#">Menu A.2-3</a></li>
                                            <li><a href = "#">Menu A.2-4</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href = "#" class = "responsiville-megamenu">Menu 3</a>
                                        <ul>
                                            <li><a href = "#">Menu A.3-1</a></li>
                                            <li><a href = "#">Menu A.3-2</a></li>
                                            <li><a href = "#">Menu A.3-3</a></li>
                                            <li><a href = "#">Menu A.3-4</a></li>
                                            <li><a href = "#">Menu A.3-5</a></li>
                                            <li><a href = "#">Menu A.3-6</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "row small-group-2" data-info = ".row">
                <div class = "column-50 with-contents" data-info = ".column-50">
                    <div class = "the-contents">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere beatae eligendi, delectus modi nesciunt, non obcaecati asperiores eius quisquam quo, dolores minima. Eum dolorum, ducimus aspernatur minima, quaerat vero, velit nulla accusamus ipsam iure ex. Culpa corporis a in accusamus consequatur, alias qui, reiciendis iusto!
                        </p>
                    </div>
                </div>
                <div class = "column-50 with-contents" data-info = ".column-50">
                    <div class = "the-contents">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam officia, deserunt vero fugiat odio perspiciatis, voluptatem itaque rerum natus deleniti id molestias eaque quam ea beatae fugit corporis nisi, dolorem inventore modi consequatur quo. Similique.
                        </p>
                    </div>
                </div>
                <div class = "column-50 with-contents" data-info = ".column-50">
                    <div class = "the-contents">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, vero natus accusamus eum temporibus, tenetur recusandae odit soluta. Assumenda, aperiam?
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, facere neque. Repellat odit architecto quas, eveniet omnis aspernatur fugiat, et, dignissimos, ad culpa quisquam perferendis!
                        </p>
                    </div>
                </div>
                <div class = "column-50 with-contents" data-info = ".column-50">
                    <div class = "the-contents">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est dolor odit ab quam repellendus alias incidunt distinctio dolores. Voluptatibus explicabo, rerum tempora repudiandae mollitia, blanditiis accusantium deleniti libero numquam perspiciatis veritatis doloribus id maiores quos.
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus consectetur ratione reiciendis voluptatem nostrum quis accusantium fugit? Ipsam deleniti, vero.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <p>
            Note that the above example <strong>combines a megamenu as well as a mobimenu as well as a scrollmenu</strong> all of them implemented on the same original element. This is totally possible and, actually, quite commonly necessary in responsive web design. However, one has to be extra careful about styling all these four states (original state, megamenu state, mobimenu state, scrollmenu state) and also about the breakpoints where each of them is enabled and disabled. For instance the megamenu is meaningful in big screens, where the user has a mouse, while the mobimenu is meaningful in small, touch enabled, screens, while the scrollmenu could be meaningful in all screens.
        </p>



        <h3>With an external megamenu container</h3>

        <p>
            What if the <strong>megamenu</strong> has an <strong>external</strong> container, ie the container of the megamenu is not a sibling of the element that activates it? And what if the same megamenu can have <strong>mobimenu</strong> and <strong>scrollmenu</strong> behaviour all at in the same web page? Well, here&apos;s what happens then: 
        </p>

        <style type = "text/css">
            .responsiville-megamenu-example-external {
                margin-bottom: var(--text-rhythm);
            }
                .responsiville-megamenu-example-external-container {
                    width: 80rem;
                    padding-bottom: 2rem ! important;
                    background-color: white;
                    position: absolute;
                    top: 100%;
                }
                .responsiville-megamenu-example-external-container {
                    padding: 1rem;
                }
                .responsiville-scrollmenu-enabled .responsiville-megamenu-example-external-container {
                    width: 100%;
                }
        </style>

        <div class = "responsiville-scrollmenu responsiville-megamenu-example responsiville-megamenu-example-external"
             data-responsiville-scrollmenu-zindex = "1001">
            <nav class = "navigation horizontal responsiville-mobimenu clear">
                <ul>
                    <li>Menu (B):</li>
                    <li>
                        <a href = "#">Menu 1</a>
                    </li>
                    <li>
                        <a href = "#" class = "responsiville-megamenu" data-responsiville-megamenu-external = "true" data-responsiville-megamenu-element = ".responsiville-megamenu-example-external-container">Menu 2 (ext)</a>
                    </li>
                    <li>
                        <a href = "#">Menu 3</a>
                    </li>
                </ul>
                <div class = "row nexus responsiville-megamenu-example-external-container">
                    <div class = "small-column-33">
                        <strong>Title 1</strong> <br />
                        Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                        <a href = "#" title = "">A link B.1</a>
                    </div>
                    <div class = "small-column-33">
                        <strong>Title 2</strong> <br />
                        Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor, iusto! <br />
                        <a href = "#" title = "">A link B.2</a>
                    </div>
                    <div class = "small-column-33">
                        <strong>Title 3</strong> <br />
                        Some text. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis quia culpa voluptatum optio explicabo dolor. <br />
                        <a href = "#" title = "">A link B.3</a>
                    </div>
                </div>
            </nav>
        </div>

        <div class = "grid-showcase">
            <div class = "row small-group-2" data-info = ".row">
                <div class = "column-50 with-contents" data-info = ".column-50">
                    <div class = "the-contents">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere beatae eligendi, delectus modi nesciunt, non obcaecati asperiores eius quisquam quo, dolores minima. Eum dolorum, ducimus aspernatur minima, quaerat vero, velit nulla accusamus ipsam iure ex. Culpa corporis a in accusamus consequatur, alias qui, reiciendis iusto!
                        </p>
                    </div>
                </div>
                <div class = "column-50 with-contents" data-info = ".column-50">
                    <div class = "the-contents">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam officia, deserunt vero fugiat odio perspiciatis, voluptatem itaque rerum natus deleniti id molestias eaque quam ea beatae fugit corporis nisi, dolorem inventore modi consequatur quo. Similique.
                        </p>
                    </div>
                </div>
                <div class = "column-50 with-contents" data-info = ".column-50">
                    <div class = "the-contents">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, vero natus accusamus eum temporibus, tenetur recusandae odit soluta. Assumenda, aperiam?
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, facere neque. Repellat odit architecto quas, eveniet omnis aspernatur fugiat, et, dignissimos, ad culpa quisquam perferendis!
                        </p>
                    </div>
                </div>
                <div class = "column-50 with-contents" data-info = ".column-50">
                    <div class = "the-contents">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est dolor odit ab quam repellendus alias incidunt distinctio dolores. Voluptatibus explicabo, rerum tempora repudiandae mollitia, blanditiis accusantium deleniti libero numquam perspiciatis veritatis doloribus id maiores quos.
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus consectetur ratione reiciendis voluptatem nostrum quis accusantium fugit? Ipsam deleniti, vero.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <p>
            But beware, all the above examples have one thing in common. Regardless of whether the megamenu container is a sibling of the megamenu activator or an external container, <strong>the megamenu container is still a descendant of the outer scrollmenu container</strong>! We advise that you keep things this way, otherwise unnecessary complexity creeps into the code. 
        </p>



        <h3>One menu to rule them all</h3>

        <p>
            Scrollmenu > mobimenu > drawers > megamenu
        </p>

        <pre><code class = "language-markup"><!--
            <header>
                <nav class="responsiville-scrollmenu">
                    <div class="responsiville-mobimenu">
                        <ul class="responsiville-drawers">
                            <li><a>...</a></li>
                            <li>
                                <a class="responsiville-megamenu">...</a>
                                <ul>
                                    <li><a>...</a></li>
                                    <li><a>...</a></li>
                                    <li><a>...</a></li>
                                </ul>
                            </li>
                            <li><a>...</a></li>
                            <li><a>...</a></li>
                        </ul>
                    </div>
                </nav>
            </header>
        --></code></pre>

    </article>



<?php include( 'footer.php' ); ?>