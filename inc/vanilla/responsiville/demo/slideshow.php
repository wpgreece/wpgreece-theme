<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Responsiville Slideshow</h1>

        <p>
            The Responsiville slideshow implements the idea of a rotating set of similar elements. It has also come to be known as a carousel, but this actually depends on the type of animation its elements use to rotate. The slideshow consists of a slideshow container and its containing slides. The slideshow container may have as many slides as necessary.
        </p>

        <p>
            Here is an example, where one can define a slideshow automatically by adding the <code>responsiville-slideshow</code> class to it:
        </p>

        <pre><code class = "language-markup"><!--
            <div class="responsiville-slideshow"

                 data-responsiville-slideshow-resizemode="maxSlide"
                 data-responsiville-slideshow-enter="laptop, desktop, large, xlarge"
                 data-responsiville-slideshow-leave="small, mobile, tablet">

                <article>
                    <h2>Slide title 1</h2>
                    <p>
                        Slide text 1. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero mollitia porro explicabo pariatur! Eum, nobis?
                    </p>
                    <img src="image1.jpg" alt="" />
                </article>
                <article>
                    <h2>Slide title 2</h2>
                    <p>
                        Slide text 2. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus animi, fugit tempore.
                    </p>
                    <img src="image2.jpg" alt="" />
                </article>
                <article>
                    <h2>Slide title 3</h2>
                    <p>
                        Slide text 3. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et nostrum at possimus eius, facilis veniam nobis error.
                    </p>
                    <img src="image3.jpg" alt="" />
                </article>
            </div>
        --></code></pre>

        <p>
            If nothing more specific is defined, then all the direct children of the slideshow container will become its slides. If you wish to differentiate this default, common behaviour you may specify exactly which elements inside the container should be regarded as its slides.
        </p>

        <p>
            Note that the module settings which are declared through data attributes and contain uppercase letters in their names, like the <code>resizeMode</code>, they are written in HTML with <strong>all lowercase</strong> letters, because HTML is case insensitive.
        </p>

        <p>
            Here is how one could create a scrollmenu in a non-automatic way:
        </p>

        <pre><code class = "language-javascript">
            var slideshow = new Responsiville.Slideshow({
                container  : '.responsiville-slideshow',
                resizeMode : 'maxSlide',
                enter      : 'laptop, desktop, large, xlarge',
                leave      : 'small, mobile, tablet'
            });
        </code></pre>

        <p>
            What the slideshow module does when it is <strong>disabled</strong>, that is in the breakpoints where it &quot;leaves&quot;, is that it tries to leave the DOM exactly as it was even before the module ever run in the first place. This way it is as less obtrusive as possible and either allows the content to flow as naturally as possible or it just lets the developer style it as they see fit.
        </p>



        <h3>Automatic navigation elements</h3>

        <p>
            The navigation elements of the slideshow are created automatically by the module. These are <strong>one bullet for each slide</strong>, so that the user can choose any slide they like on demand, <strong>a next and a previous button</strong>, so that the user can move forwards and backwards in the slideshow. The developer needs <strong>not</strong> create any navigation elements for the slideshow. They can simply style the ones that the module creates any way they see fit.
        </p>

        <p>
            However, one can also define their own navigation elements and use the same classes as the original ones. They will function properly as long as they are found inside the slideshow container.
        </p>



        <h2>API data attribute</h2>

        <p>
            If the slideshow has not been created manually, which is the easiest and most common case, one can obtain an instance of the underlying <code>Responsiville.Slideshow</code> Javascript object, so that it can manipulate the slideshow via its API, by accessing its <code>responsiville-slideshow-api</code> data attribute, like this:
        </p>
        <pre><code class = "language-javascript">
            // Obtain the underlying Responsiville.Slideshow Javascript object.
            var slideshow = $( '.responsiville-slideshow' ).data( 'responsiville-slideshow-api' );

            // Programmatically select the next slide of the slideshow.
            slideshow.next();

            // Programmatically select the previous slide of the slideshow.
            slideshow.previous();
        </code></pre>



        <h2>Default values</h2>

        <p>
            Here is its full list of settings and default values:
        </p>

        <script type = "text/javascript">
            document.write(
                '<pre><code class = "language-json">' +
                    js_beautify( JSON.stringify( Responsiville.Slideshow.defaults ) ) +
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
            .responsiville-slideshow-example {
                margin-bottom: var(--text-rhythm);
            }
                .responsiville-slideshow .slide .excerpt {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    padding: 0 2em 2em 2em;
                    margin: 0;
                    opacity: 0.85;
                    color: var(--color-gray-dark);
                    background-color: var(--color-gray-light);
                }
        </style>

        <div class = "responsiville-slideshow responsiville-slideshow-example" 

             data-responsiville-slideshow-bulletspos = "bc"
             data-responsiville-slideshow-effect     = "slide"
             data-responsiville-slideshow-resizemode = "maxSlide">

            <div class = "slide">
                <img src = "img/photo4.jpg" alt = "" />
                <div class = "excerpt">
                    <h3>This is the title of slide 1</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius a nemo voluptate eligendi dolorem aut minima illum, tenetur earum! Error tenetur et animi fugiat ab.
                    </p>
                </div>
            </div>
            <div class = "slide">
                <img src = "img/photo3.jpg" alt = "" />
                <div class = "excerpt">
                    <h3>This is the title of slide 2</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nobis, unde nulla. Magni, delectus facilis saepe praesentium dolor. Voluptate, facere!
                    </p>
                </div>
            </div>
            <div class = "slide">
                <img src = "img/photo1.jpg" alt = "" />
                <div class = "excerpt">
                    <h3>This is the title of slide 3</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore odio, recusandae eum quibusdam quasi magnam quo. Animi.
                    </p>
                </div>
            </div>
            <div class = "slide">
                <img src = "img/photo2.jpg" alt = "" />
                <div class = "excerpt">
                    <h3>This is the title of slide 4</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore odio, recusandae eum quibusdam quasi magnam quo. Animi.
                    </p>
                </div>
            </div>
        </div>

        <p>
            And the code for this is:
        </p>

        <pre><code class = "language-markup"><!--
            <div class="responsiville-slideshow responsiville-slideshow-example" 

                 data-responsiville-slideshow-bulletspos="bc"
                 data-responsiville-slideshow-effect="slide"
                 data-responsiville-slideshow-resizemode="maxSlide">

                <div class="slide">
                    <img src="img/photo4.jpg" alt="" />
                    <div class="excerpt">
                        <h3>This is the title of slide 1</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius a nemo voluptate eligendi dolorem aut minima illum, tenetur earum! Error tenetur et animi fugiat ab.
                        </p>
                    </div>
                </div>
                <div class="slide">
                    <img src="img/photo3.jpg" alt="" />
                    <div class="excerpt">
                        <h3>This is the title of slide 2</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam nobis, unde nulla. Magni, delectus facilis saepe praesentium dolor. Voluptate, facere!
                        </p>
                    </div>
                </div>
                <div class="slide">
                    <img src="img/photo1.jpg" alt="" />
                    <div class="excerpt">
                        <h3>This is the title of slide 3</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore odio, recusandae eum quibusdam quasi magnam quo. Animi.
                        </p>
                    </div>
                </div>
                <div class="slide">
                    <img src="img/photo2.jpg" alt="" />
                    <div class="excerpt">
                        <h3>This is the title of slide 4</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore odio, recusandae eum quibusdam quasi magnam quo. Animi.
                        </p>
                    </div>
                </div>
            </div>
        --></code></pre>



    </article>



<?php include( 'footer.php' ); ?>