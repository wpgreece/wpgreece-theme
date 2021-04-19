<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Responsiville Lazymg</h1>

        <p>
            The Lazymg is a module that causes images to lazy load. This means that it prevents an image from loading when a page normally loads and then loads it when it appears in the browser viewport. This way images do not load until the time they are necessary to be viewed by the visitor, thus saving significant load time and bandwidth.
        </p>

        <pre><code class = "language-markup"><!--
            <p>
                <img src="" alt="This is an image"
                     class="responsiville-lazymg"
                     data-responsiville-lazymg-src="img/image.jpg"/>
            </p>
        --></code></pre>

        <p>
            The class that designates this particular HTML element to become a lazy loading image is <code>responsiville-lazymg</code>. We normally keep its <code>src</code> attribute empty, so we make sure the corresponding image does not load along with the page. The <code>data-responsiville-lazymg-src</code> data attribute sets the actual image that will eventually be loaded when the image enters the viewport. 
        </p>

        <p>
            Here is how you can create it <strong>on demand</strong>:
        </p>

        <pre><code class = "language-javascript">
            var lazymg = new Responsiville.Lazymg({
                element : '.element'
            });
        </code></pre>



        <h2>API data attribute</h2>

        <p>
            One can obtain an instance of the underlying <code>Responsiville.Lazymg</code> Javascript object, so that it can manipulate the lazy loading image via its API, by accessing its <code>responsiville-lazymg-api</code> data attribute, like this:
        </p>
        <pre><code class = "language-javascript">
            // Obtain the underlying Responsiville.Lazymg Javascript object.
            var lazymg = $( '.responsiville-lazymg' ).data( 'responsiville-lazymg-api' );
        </code></pre>



        <h2>Default values</h2>

        <p>
            Here is its full list of settings and default values:
        </p>

        <script type = "text/javascript">
            document.write(
                '<pre><code class = "language-json">' +
                    js_beautify( JSON.stringify( Responsiville.Lazymg.defaults ) ) +
                '</code></pre>'
            );
        </script>

        <p>
            <a href = "http://vanilla.nevma.gr/wp-content/docs/responsiville-jsdoc/" title = "Responsiville Javascript API" target = "_blank" class = "button">Responsiville Javascript API</a>
        </p>



        <h2>Working examples</h2>

        <p>
            Here is a full working example:
        </p>

        <p>
            <img src = "" alt = "This is an image" 
                 class = "responsiville-lazymg"
                 data-responsiville-lazymg-src = "img/photo3.jpg" />
        </p>

        <p>
            And the code for this is:
        </p>

        <pre><code class = "language-markup"><!--
            <p>
                <img src="" alt=""
                     class="responsiville-lazymg"
                     data-responsiville-lazymg-src="img/photo3.jpg"/>
            </p>
        --></code></pre>



        <h3>Another example with 2 consecutive images</h3>

        <p>
            <img src = "" alt = "This is an image" 
                 class = "responsiville-lazymg" 
                 data-responsiville-lazymg-src = "img/photo2.jpg" />
            <img src = "" alt = "This is an image" 
                 class = "responsiville-lazymg" 
                 data-responsiville-lazymg-src = "img/photo1.jpg" />
        </p>

        

        <h3>Lazy load an image in CSS background</h3>

        <p>
            This time the image is <strong>not</strong> an <code>IMG</code> element. It is a CSS background image that can be lazy loaded as well. 
        </p>

        <style type = "text/css">
            .example1 {
                height: 40vh;
                background-position: 50% 0;
                background-attachment: fixed;
                margin-bottom: var(--text-rhythm);
            }
            .responsiville-lazymg {
                transition-property: opacity, height;
                transition-duration: 1s;
                opacity: 0;
            }
            .responsiville-lazymg-loaded {
                opacity: 1;
            }
        </style>

        <div class = "example1 responsiville-lazymg"
            data-responsiville-lazymg-src = "img/photo4.jpg"
            data-responsiville-lazymg-cssBackground = "true">
        </div>

        <p>
            And the code for this is:
        </p>
        
        <pre><code class = "language-markup"><!--
            <style type="text/css">
                .example1 {
                    background-attachment: fixed;
                    background-position: 50% 0;
                    height: 40vh;
                }
            </style>

            <div class="example1 responsiville-lazymg"
                data-responsiville-lazymg-src="img/photo4.jpg"
                data-responsiville-lazymg-cssBackground="true">
            </div>
        --></code></pre>



        <h3>Already loaded image</h3>
        <p>
            This image will have probably loaded by the time Lazymg tries to handle it
        </p>
        <p>
            <img src = "img/photo5.jpg" alt = "This is an image" class = "responsiville-lazymg" />
        </p>



    </article>



<?php include( 'footer.php' ); ?>