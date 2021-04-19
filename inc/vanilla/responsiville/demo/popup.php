<?php include( 'header.php' ); ?>



    <article class = "text">

       <h1>Responsiville Popup</h1>
        <p>
            The popup is an element that stands above the other elements of the page, in order to provide a message to the user like in a <strong>modal window</strong>. The contents of the popup may be any valid HTML possible. The popup structure is as follows:
        </p>
        <dl>
            <dt><code>.responsiville-popup-container-wrapper</code></dt>
            <dd>
                <dl>
                    <dt><code>.responsiville-popup-contents</code></dt>
                    <dd>
                        <dl>
                            <dt>
                                <code>.responsiville-popup-contents-inner</code><br />
                                ...
                            </dt>
                        </dl>
                    </dd>
                </dl>
            </dd>
        </dl>
        <p>
            In order for a popup to exist, it needs two things: a) its <strong>contents</strong> which can be an element or some HTML and b) another element or some code to <strong>activate</strong>. But remember: a popup is not its activator. Its activator is simply a way to open and close the popup. The popup is its contents!
        </p>

        <h3>Create it automatically</h3>
        <p>
            Here is how you can create a popup <strong>automatically</strong> by defining the popup through its activator <code>.responsiville-popup-activator</code>. A <strong>button</strong> with a <code>data-responsiville-popup-element</code> data attribute that points to the element that holds the popup contents:
        </p>
        <pre><code class = "language-markup"><!--
            <button class="responsiville-popup-activator"
                    title="Popup button"
                    data-responsiville-popup-element="#popup">
                Popup activator
            </button>
        --></code></pre>

        <p>
            An <strong>anchor</strong> <code>a</code> with an <code>href</code> attribute that points to the element that holds the popup contents: 
        </p>
        <pre><code class = "language-markup"><!--
            <a href="#popup"
               title="Popup anchor"
               class="button responsiville-popup-activator">
                Popup activator
            </a>
        --></code></pre>
            
        <p>
            The actual popup contents which can be any HTML element.
        </p>
        <pre><code class = "language-markup"><!--
            <div class="hidden">
                <div id="popup" class="popup-example">
                    <h3>This is a title</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure laudantium possimus officia repellat cupiditate aliquid. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla odit ullam optio explicabo id consectetur illum? Repellat debitis iure iste.
                    </p>
                    <p>
                        <button>A button</button>
                    </p>
                </div>
            </div>
        --></code></pre>

        <h3>Create it with Javascript</h3>
        <p>
            Here is how you can create it <strong>on demand</strong> with code:
        </p>
        <pre><code class = "language-javascript">
            // By defining its activator.
            var popup = new Responsiville.Popup({
                activator : '.responsiville-popup-activator'
            });

            // By defining its contents element.
            var popup = new Responsiville.Popup({
                element : '#popup-example'
            });

            // By defining its contents as HTML.
            var popup = new Responsiville.Popup({
                contents : 
                    '&lt;h3>This is a title&lt;/h3&gt;' +
                    '&lt;p&gt;' +
                        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure laudantium possimus officia repellat cupiditate aliquid. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla odit ullam optio explicabo id consectetur illum? Repellat debitis iure iste.' +
                    '&lt;/p&gt;' +
                    '&lt;p&gt;' +
                        '&lt;button&gt;A button&lt;/button&gt;' +
                    '&lt;/p&gt;'
            });

            // Open the popup.
            popup.openPopup();
        </code></pre>



        <h2>API data attribute</h2>

        <p>
            If the popup has not been created manually, which is the easiest and most common case, one can obtain an instance of the underlying <code>Responsiville.Popup</code> Javascript object, so that it can manipulate the popup via its API, by accessing its <code>responsiville-popup-api</code> data attribute, like this:
        </p>
        <pre><code class = "language-javascript">
            // Obtain the underlying Responsiville.Popup Javascript object.
            var popup = $( '.responsiville-popup-activator' ).data( 'responsiville-popup-api' );
        </code></pre>



        <h2>Default values</h2>

        <p>
            Here is its full list of settings and default values:
        </p>

        <script type = "text/javascript">
            document.write(
                '<pre><code class = "language-json">' +
                    js_beautify( JSON.stringify( Responsiville.Popup.defaults ) ) +
                '</code></pre>'
            );
        </script>

    </article>



    <article class = "text">

        <h2>Working examples</h2>
        <p>Here are some working examples on the popup usage.</p>
        <h3>Example 1:</h3> 
        <p>
            A popup with simple HTML contents in a hidden element: 
        </p>
        <p>
            <button class = "button-small responsiville-popup-activator" 
                    title = "Popup button 1 simple"
                    data-responsiville-popup-element = "#popup-example-1">
                Popup button 1 simple
            </button>
        </p>
    
    </article>

    <style type="text/css">
        .popup-example h3 {
            margin-top: calc(0.5 * var(--text-rhythm));
        }
    </style>



    <article class = "text">
    
        <h3>Example 2:</h3>
        <p>
            The same popup but with an anchor activator and the close button inside the contents. 
        </p>
        <p>
            <a href  = "#popup-example-1" 
               class = "button button-small responsiville-popup-activator" 
               title = "Popup button 2 anchor"
               data-responsiville-popup-closePosition = "in">
                Popup button 2 anchor
            </a>
        </p>

    </article>
    
    <div class = "hidden text">
        <div id = "popup-example-1" class = "popup-example text">
            <h2>This is a title</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure laudantium possimus officia repellat cupiditate aliquid. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla odit ullam optio explicabo id consectetur illum? Repellat debitis iure iste. Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, consectetur earum quam porro iure cum nostrum dolorem repudiandae repellendus, voluptate cumque sint fuga.
            </p>
        </div>
    </div>



    <article class = "text">

        <h3>Example 3:</h3> 
        <p>
            A similar popup, but with long contents. 
        </p>
        <p>
            <button class = "button-small responsiville-popup-activator" 
                    title = "Popup 3 long contents"
                    data-responsiville-popup-element = "#popup-example-3">
                Popup 3 long contents
            </button>
        </p>

    </article>
    
    <div class = "hidden text">
        <div id = "popup-example-3" class = "popup-example text">
            <h2>This is a title</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure laudantium possimus officia repellat cupiditate aliquid. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla odit ullam optio explicabo id consectetur illum? Repellat debitis iure iste.
            </p>
            <h3>Another title here</h3>
            <p>
                Commodi, natus? Adipisci, error corporis reprehenderit incidunt voluptatum ipsa nostrum at doloremque sequi modi repellendus maiores architecto animi, aperiam eius omnis tempora non voluptates reiciendis, iste exercitationem odit aliquid eligendi! In ad, eos eligendi quis similique commodi dolorum eum molestias, earum tempore totam consequatur! Iste, suscipit sed? Voluptatibus debitis quibusdam atque voluptatum eveniet perspiciatis tempore ab at earum!
            </p>
            <blockquote>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum cum dignissimos cumque quod natus laboriosam fuga officiis aut, nulla, modi, adipisci minima excepturi perspiciatis quia?
            </blockquote>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit alias, blanditiis eaque obcaecati! Fuga fugit minima nihil ipsa error ex ratione quam, perferendis et, tenetur porro vitae aspernatur exercitationem tempore eos temporibus nostrum possimus sit? Iure ab quod ea? Natus cum magni saepe rerum, molestias voluptatibus fugit aspernatur!
            </p>
        </div>
    </div>



    <article class = "text">

        <h3>Example 4:</h3>
        <p>
            A popup which allows to overflow the window height if necessary: 
        </p>
        <p>
            <button class = "button-small responsiville-popup-activator" 
                    title = "Popup 4 overflow"
                    data-responsiville-popup-element       = "#popup-example-4"
                    data-responsiville-popup-closePosition = "in"
                    data-responsiville-popup-overflow      = "true"
                    data-responsiville-popup-maxWidth      = "50vw">
                Popup 4 overflow
            </button>
        </p>

    </article>
    
    <div class = "hidden text">
        <div id = "popup-example-4" class = "popup-example text">
            <h2>This is a title</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure laudantium possimus officia repellat cupiditate aliquid. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla odit ullam optio explicabo id consectetur illum? Repellat debitis iure iste.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum modi repudiandae iure nostrum doloribus qui, culpa recusandae hic magni, cum sint, et deserunt quaerat in ad earum voluptatem perferendis eaque consequatur provident unde! Fuga odit quos veritatis veniam possimus doloremque nobis eum aliquid corporis sit.
            </p>
            <h3>Lorem ipsum dolor sit amet.</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta nisi culpa, magnam facilis ipsam, similique illum aliquam officia dolores sequi mollitia numquam soluta minus quibusdam sint esse neque nesciunt repellat velit deleniti voluptates reprehenderit animi. Officia doloribus quo, repellendus nam.
            </p>
            <ul>
                <li>Lorem ips amet consectetur adipisicing elit. Veniam, tempora.</li>
                <li>Lipsum dolor sit amet consectetur adipisicing elit. Aut sequi excepturi vel consectetur.</li>
                <li>Dictuma emet ipsum dolor sit amet consectetur adipisicing elit. Nostrum ipsa consequatur illum!</li>
                <li>Ipsum iure itaque repellat aliquam cumque, fugiat voluptate! Vitae, omnis quia ad id ea laboriosam?</li>
                <li>Neque, et in illo sapiente maxime ullam, distinctio porro ab quaerat sit ipsam eius nam?</li>
            </ul>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos natus dolore, eaque accusamus id, quisquam saepe, quod, ducimus reprehenderit ipsum aperiam praesentium totam mollitia? Quis facilis obcaecati, molestiae amet aliquam at cupiditate enim voluptas facere recusandae dicta eum iure culpa. Magni, voluptatibus, accusamus.
            </p>
            <blockquote>
                Aliquam debitis, quaerat velit, vel veritatis laborum assumenda architecto qui corrupti nobis totam cum incidunt, non nesciunt nemo quidem in blanditiis beatae. Unde necessitatibus iusto accusantium, similique ad debitis eaque.
            </blockquote>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate illo quae voluptas eaque quaerat nulla fugiat, minus eius ipsa fuga dolore, autem hic. Ratione voluptatem fuga ipsum vero doloribus quis laboriosam odio dolore non voluptate. Ipsa officia numquam id minus maxime at et, non sint porro!
            </p>
            <h3>Lorem ipsum dolor sit amet, consectetur.</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed ducimus vitae rerum, asperiores, qui velit, perferendis dolorem aspernatur eius, illo laboriosam consequuntur eligendi assumenda blanditiis possimus maxime totam aliquid sapiente libero dolores quasi incidunt accusamus est. Deserunt est commodi, esse, adipisci repellat dolorum enim dolor.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet modi aspernatur, quae vitae architecto minima pariatur tempore, voluptatum repellat porro veniam sapiente aperiam quisquam et alias optio labore recusandae totam consequatur aliquam nam suscipit earum! Rerum alias ut iusto officia, sint esse.
            </p>
        </div>
    </div>



    <article class = "text">

        <p>One can also manipulate the popup directlry with code.</p>
        <h3>Example 5:</h3>
        <p>
            A popup whose contents are given as an HTML string.
        </p>
        <p>
            <button id = "popup-example-5" class = "button-small" title = "Popup 5 HTML string">Popup 5 HTML string</button>
        </p>

    </article>

    <script type = "text/javascript">
        var responsiville = Responsiville.Main.getInstance();
        responsiville.on( 'init', function () {
            var popup5 = new Responsiville.Popup({
                contents : 
                    '<div class="popup-example text">' +
                        '<h2>Title</h2>' +
                        '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi voluptas debitis quae dolorem illum perspiciatis molestias non tenetur neque fugiat eaque cum, ipsum eligendi totam voluptates iure, quis sed suscipit doloremque odit! Aspernatur culpa quae, cupiditate consectetur velit animi deleniti laudantium illum quibusdam natus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis quaerat esse eveniet sequi, neque culpa, blanditiis assumenda animi consectetur exercitationem delectus consequatur vero! Eveniet!</p>' +
                    '</div>'
            });
            jQuery( '#popup-example-5' ).on( 'click', function () {
                popup5.openPopup();
            });
        });
    </script>



    <article class = "text">

        <h3>Example 6:</h3>
        <p>
            A popup whose contents change on the fly. 
        </p>
        <p>
            <button id = "popup-example-6" class = "button-small" title = "Popup 6 change on the fly">Popup 6 change on the fly</button>
        </p>

    </article>

    <script type = "text/javascript">
        var responsiville = Responsiville.Main.getInstance();
        responsiville.on( 'init', function () {
            var popup6 = new Responsiville.Popup({
                contents : 
                    '<div class="popup-example text">' +
                        '<h2>Title</h2>' +
                        '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi voluptas debitis quae dolorem illum perspiciatis molestias non tenetur neque fugiat eaque cum, ipsum eligendi totam voluptates iure, quis sed suscipit doloremque odit! Aspernatur culpa quae, cupiditate consectetur velit animi deleniti laudantium illum quibusdam natus.</p>' +
                        '<p><button title = "Change contents">Change contents</button></p>' + 
                    '</div>'
            });
            popup6.$contents.find( 'button' ).on( 'click', function () {
                popup6.setContents( '<p>Popup contents are set on the fly!</p>' );
            });
            jQuery( '#popup-example-6' ).on( 'click', function () {
                popup6.openPopup();
            });
        });
    </script>



    <article class = "text">

        <h3>Example 7:</h3>
        <p>
            A popup with self closing button inside. 
        </p>
        <p>
            <button id = "popup-example-7" class = "button-small" title = "Popup 7 close inside">Popup 7 close inside</button>
        </p>

    </article>

    <script type = "text/javascript">
        var responsiville = Responsiville.Main.getInstance();
        responsiville.on( 'init', function () {
            var popup7 = new Responsiville.Popup({
                contents : 
                    '<div class="popup-example text">' +
                        '<h2>Title</h2>' +
                        '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qapernatur culpa quae, cupiditate consectetur velit animi deleniti laudantium illum quibusdam natus. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolor ipsam ducimus reiciendis pariatur amet. Doloremque quod nihil saepe dolorum at. Hic eaque ad corrupti explicabo tenetur fugit laborum molestias impedit. Id, voluptates nihil.</p>' +
                        '<p class = "text-right"><button class = "responsiville-popup-close-button" title = "Close popup">Close popup</button></p>' + 
                    '</div>'
            });
            jQuery( '#popup-example-7' ).on( 'click', function () {
                popup7.openPopup();
            });
        });
    </script>



    <article class = "text">

        <h3>Example 8:</h3>
        <p>
            A popup with images loading inside it dynamically. Note that the popup dimensions will adapt to the image dimensions once the images have completed loading. 
        </p>
        <p>
            <button id = "popup-example-8" class = "button-small" title = "Popup 8 images dynamic">Popup 8 images dynamic</button>
        </p>

    </article>

    <script type = "text/javascript">
        var responsiville = Responsiville.Main.getInstance();
        responsiville.on( 'init', function () {
            var popup8 = new Responsiville.Popup({
                overflow      : true,
                closePosition : 'in',
                contents      : 
                    '<div class="popup-example text">' +
                        '<h2>Title</h2>' +
                        '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qapernatur culpa quae, cupiditate consectetur velit animi deleniti laudantium illum quibusdam natus.</p>' +
                        '<p><button class = "popup-example-8-button" title = "Change contents">Change contents</button></p>' + 
                    '</div>'
            });
            popup8.$contents.find( '.popup-example-8-button' ).on( 'click', function () {
                popup8.setContents(
                    '<div class="popup-example text">' +
                        '<h2>Popup title</h2>' +
                        '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qapernatur culpa quae, cupiditate consectetur velit animi deleniti laudantium illum quibusdam natus.</p>' +
                        '<p><img src = "img/photo1.jpg" alt = "Image"/></p>' + 
                        '<p><img src = "img/photo3.jpg" alt = "Image"/></p>' + 
                        '<h3>Another title is here</h3>' + 
                        '<p>Consectetur adipisicing elit. Qapernatur culpa quae, cupiditate consectetur velit animi deleniti laudantium illum quibusdam natus. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint id sed neque exercitationem!</p>' +
                        '<p><img src = "img/photo2.jpg" alt = "Image"/></p>' + 
                    '</div>'
                );
            });
            jQuery( '#popup-example-8' ).on( 'click', function () {
                popup8.openPopup();
            });

        });
    </script>



<?php include( 'footer.php' ); ?>