<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Responsiville Accordion</h1>

        <p>
            The accordion is an element that consists of many other elements, which we call accordion panels, that open and close, sort of like a real accordion expands and shrinks. Here is how you can create an accordion <strong>automatically</strong>:
        </p>

        <pre><code class = "language-markup"><!--
            <div class="responsiville-accordion"

                 data-responsiville-accordion-duration="300"
                 data-responsiville-accordion-delay="50"
                 data-responsiville-accordion-enter="laptop, desktop, large, xlarge"
                 data-responsiville-accordion-leave="small, mobile, tablet">

                <div class="responsiville-accordion-panel">
                    <div class="responsiville-accordion-header">
                        Opens and closes the panel when clicked.
                    </div>
                    <div class="responsiville-accordion-excerpt">
                        Optional excerpt visible when the panel is closed.
                    </div>
                    <div class="responsiville-accordion-content">
                        The actual full content of the panel. Can be any HTML content you wish.
                    </div>
                    <div class="responsiville-accordion-footer">
                        Optional footer of the panel.
                    </div>
                </div>

                ...

            </div>
        --></code></pre>

        <p>
            You may use as many panels as you wish.
        </p>

        <p>
            The class that designates this particular HTML element -and its contents- to become an accordion is <code>responsiville-accordion</code>. Also, note that its children follow a specific pattern for their class naming. You can look these details up in the API documentation. The rest is taken care by the framework.
        </p>

        <p>
            Here is how you can create it <strong>on demand</strong>:
        </p>

        <pre><code class = "language-javascript">
            var accordion = new Responsiville.Accordion({
                container : '.responsiville-accordion',
                duration  : 300,
                delay     : 50,
                enter     : 'laptop, desktop, large, xlarge',
                leave     : 'small, mobile, tablet'
            });
        </code></pre>



        <h2>API data attribute</h2>

        <p>
            If the accordion has not been created manually, which is the easiest and most common case, one can obtain an instance of the underlying <code>Responsiville.Accordion</code> Javascript object, so that it can manipulate the accordion via its API, by accessing its <code>responsiville-accordion-api</code> data attribute, like this:
        </p>
        <pre><code class = "language-javascript">
            // Obtain the underlying Responsiville.Accordion Javascript object.
            var accordion = $( '.responsiville-accordion' ).data( 'responsiville-accordion-api' );
        </code></pre>



        <h2>Default values</h2>

        <p>
            Here is its full list of settings and default values:
        </p>

        <script type = "text/javascript">
            document.write(
                '<pre><code class = "language-json">' +
                    js_beautify( JSON.stringify( Responsiville.Accordion.defaults ) ) +
                '</code></pre>'
            );
        </script>



        <h2>Working example</h2>

        <p>
            Here is a full working example which showcases all the possible building blocks of an accordion:
        </p>

        <div class = "grid-showcase">
            <div class = "row responsiville-accordion" data-info = ".row">
                <div class = "small-column-100 responsiville-accordion-panel with-contents" data-info = ".small-column-100 responsiville-accordion-panel">
                    <div class = "the-contents">
                        <div class = "responsiville-accordion-header">
                            <strong>This is the accordion panel header. Click it to open/close it.</strong>
                        </div>
                        <div class = "responsiville-accordion-excerpt">
                            <em>This is the accordion panel excerpt. It is visible at all times as an excerpt of the accordion panel content. It is an optional element.</em>
                        </div>
                        <div class = "responsiville-accordion-content">
                            <br />
                            This is the accordion panel contents. It can be any HTML content you like. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus consequuntur animi perspiciatis impedit, inventore porro, repudiandae molestias, voluptates quae sapiente placeat aspernatur voluptatibus doloremque iste itaque culpa accusantium, hic officiis voluptas provident neque officia dignissimos maiores! Vitae, reprehenderit hic nobis voluptatem mollitia ab numquam distinctio possimus aliquam animi pariatur neque, dolores modi repellat ut quos, quae cumque voluptatibus eligendi a sint odio assumenda ratione natus! Quibusdam beatae consequatur eligendi aspernatur, praesentium neque, harum adipisci ex. Corporis dignissimos laudantium quia laboriosam fugiat reiciendis iusto mollitia sequi esse cum. Laborum voluptatem explicabo unde reiciendis iusto quaerat quibusdam atque, veniam, illum sed!
                            <br />
                            <br />
                        </div>
                        <div class = "responsiville-accordion-footer">
                            <em>This is the accordion panel footer. Follows the same logic as the excerpt.</em>
                        </div>
                    </div>
                </div>
                <div class = "small-column-100 responsiville-accordion-panel with-contents" data-info = ".small-column-100 responsiville-accordion-panel">
                    <div class = "the-contents">
                        <div class = "responsiville-accordion-header">
                            <strong>This is the header. There is no excerpt or footer.</strong>
                        </div>
                        <div class = "responsiville-accordion-content">
                            <br />
                            This is the accordion panel contents. It can be any HTML content you like. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus consequuntur animi perspiciatis impedit, inventore porro, repudiandae molestias, voluptates quae sapiente placeat aspernatur voluptatibus doloremque iste itaque culpa accusantium, hic officiis voluptas provident neque officia dignissimos maiores! Vitae, reprehenderit hic nobis voluptatem mollitia ab numquam distinctio possimus aliquam animi pariatur neque, dolores modi repellat ut quos, quae cumque voluptatibus eligendi a sint odio assumenda ratione natus! Quibusdam beatae consequatur eligendi aspernatur, praesentium neque, harum adipisci ex. Corporis dignissimos laudantium quia laboriosam fugiat reiciendis iusto mollitia sequi esse cum. Laborum voluptatem explicabo unde reiciendis iusto quaerat quibusdam atque, veniam, illum sed!
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
                <div class = "small-column-100 responsiville-accordion-panel with-contents" data-info = ".small-column-100 responsiville-accordion-panel">
                    <div class = "the-contents">
                        <div class = "responsiville-accordion-header">
                            <strong>This is the header. There is no excerpt or footer.</strong>
                        </div>
                        <div class = "responsiville-accordion-content">
                            <br />
                            This is the accordion panel contents. It can be any HTML content you like. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus consequuntur animi perspiciatis impedit, inventore porro, repudiandae molestias, voluptates quae sapiente placeat aspernatur voluptatibus doloremque iste itaque culpa accusantium, hic officiis voluptas provident neque officia dignissimos maiores! Vitae, reprehenderit hic nobis voluptatem mollitia ab numquam distinctio possimus aliquam animi pariatur neque, dolores modi repellat ut quos, quae cumque voluptatibus eligendi a sint odio assumenda ratione natus! Quibusdam beatae consequatur eligendi aspernatur, praesentium neque, harum adipisci ex. Corporis dignissimos laudantium quia laboriosam fugiat reiciendis iusto mollitia sequi esse cum. Laborum voluptatem explicabo unde reiciendis iusto quaerat quibusdam atque, veniam, illum sed!
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <h3>A clearer example</h3>

        <p>
            In this example you see the final output of the accordion without outlining its building blocks.
        </p>

        <style type = "text/css">
            .responsiville-accordion2 .responsiville-accordion-panel {
                border: 1px solid var(--color-gray);
                border-radius: 3px;
                padding: var(--text-rhythm);
                padding-bottom: 0;
                margin-bottom: calc(0.5*var(--text-rhythm))
            }

            .responsiville-accordion2 .responsiville-accordion-header {
                margin: 0;
                padding: 0;
                margin-bottom: var(--text-rhythm);
            }
        </style>

        <div class = "responsiville-accordion responsiville-accordion2">
            <div class = "responsiville-accordion-panel">
                <h4 class = "responsiville-accordion-header">
                    This is the accordion panel header. Click it to open/close it.
                </h4>
                <p class = "responsiville-accordion-excerpt">
                    <em>This is the accordion panel excerpt. It is visible at all times as an excerpt of the accordion panel content. It is an optional element.</em>
                </p>
                <div class = "responsiville-accordion-content">
                    <p>
                        This is the accordion panel contents. It can be any HTML content you like. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus consequuntur animi perspiciatis impedit, inventore porro, repudiandae molestias, voluptates quae sapiente placeat aspernatur voluptatibus doloremque iste itaque culpa accusantium, hic officiis voluptas provident neque officia. 
                    </p>
                    <p>
                        Dignissimos maiores! Vitae, reprehenderit hic nobis voluptatem mollitia ab numquam distinctio possimus aliquam animi pariatur neque, dolores modi repellat ut quos, quae cumque voluptatibus eligendi a sint odio assumenda ratione natus! Quibusdam beatae consequatur eligendi aspernatur, praesentium neque, harum adipisci ex. Corporis dignissimos laudantium quia laboriosam fugiat reiciendis iusto mollitia sequi esse cum. Laborum voluptatem explicabo unde reiciendis iusto quaerat quibusdam atque, veniam, illum sed!
                    </p>
                </div>
                <p class = "responsiville-accordion-footer">
                    <em>This is the accordion panel footer. Follows the same logic as the excerpt.</em>
                </p>
            </div>
            <div class = "responsiville-accordion-panel">
                <h4 class = "responsiville-accordion-header">
                    This is the accordion panel header. Click it to open/close it.
                </h4>
                <p class = "responsiville-accordion-excerpt">
                    <em>This is the accordion panel excerpt. It is visible at all times as an excerpt of the accordion panel content. It is an optional element.</em>
                </p>
                <div class = "responsiville-accordion-content">
                    <p>
                        This is the accordion panel contents. It can be any HTML content you like. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus consequuntur animi perspiciatis impedit, inventore porro, repudiandae molestias, voluptates quae sapiente placeat aspernatur voluptatibus doloremque iste itaque culpa accusantium officia. 
                    </p>
                    <p>
                        Dignissimos maiores! Vitae, reprehenderit hic nobis voluptatem mollitia ab numquam distinctio possimus aliquam animi pariatur neque, dolores modi repellat ut quos, quae cumque voluptatibus eligendi a sint odio assumenda ratione natus! Quibusdam beatae consequatur eligendi aspernatur, praesentium. Corporis laudantium quia laboriosam fugiat reiciendis iusto mollitia sequi esse cum. Laborum voluptatem explicabo unde reiciendis iusto quaerat quibusdam atque, veniam, illum sed!
                    </p>
                </div>
                <p class = "responsiville-accordion-footer">
                    <em>This is the accordion panel footer. Follows the same logic as the excerpt.</em>
                </p>
            </div>
            <div class = "responsiville-accordion-panel">
                <h4 class = "responsiville-accordion-header">
                    This is the accordion panel header. Click it to open/close it.
                </h4>
                <p class = "responsiville-accordion-excerpt">
                    <em>This is the accordion panel excerpt. It is visible at all times as an excerpt of the accordion panel content. It is an optional element.</em>
                </p>
                <div class = "responsiville-accordion-content">
                    <p>
                        This is the accordion panel contents. It can be any HTML content you like. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus consequuntur animi perspiciatis impedit, inventore porro, repudiandae molestias, voluptates quae sapiente placeat aspernatur voluptatibus doloremque iste itaque culpa accusantium, hic officiis voluptas provident neque officia. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis tenetur beatae adipisci atque?
                    </p>
                    <p>
                        Dignissimos maiores! Vitae, reprehenderit hic nobis voluptatem mollitia ab numquam distinctio possimus aliquam animi pariatur neque, dolores modi repellat ut quos, quae cumque voluptatibus eligendi a sint odio assumenda ratione natus! Quibusdam beatae consequatur eligendi aspernatur, praesentium neque, harum adipisci ex. Corporis dignissimos laudantium quia laboriosam fugiat reiciendis iusto mollitia sequi esse cum. Laborum voluptatem explicabo unde reiciendis iusto quaerat quibusdam atque, veniam, illum sed!
                    </p>
                </div>
                <p class = "responsiville-accordion-footer">
                    <em>This is the accordion panel footer. Follows the same logic as the excerpt.</em>
                </p>
            </div>
        </div>



        <h3>The simplest, yet most common example</h3>

        <p>
            In this example the accordion panels consist of only their headers and contents. There are no excerpts or footers.
        </p>

        <div class = "responsiville-accordion responsiville-accordion2">
            <div class = "responsiville-accordion-panel">
                <h4 class = "responsiville-accordion-header">
                    This is the accordion panel header. Click it to open/close it.
                </h4>
                <div class = "responsiville-accordion-content">
                    <p>
                        Dignissimos maiores! Vitae, reprehenderit hic nobis voluptatem mollitia ab numquam distinctio possimus aliquam animi pariatur neque, dolores modi repellat ut quos, quae cumque voluptatibus eligendi a sint odio assumenda ratione natus! Quibusdam beatae consequatur eligendi aspernatur, praesentium neque, harum adipisci ex. Corporis dignissimos laudantium quia laboriosam fugiat reiciendis iusto mollitia sequi esse cum. Laborum voluptatem explicabo unde reiciendis iusto quaerat quibusdam atque, veniam, illum sed!
                    </p>
                </div>
            </div>
            <div class = "responsiville-accordion-panel">
                <h4 class = "responsiville-accordion-header">
                    This is the accordion panel header. Click it to open/close it.
                </h4>
                <div class = "responsiville-accordion-content">
                    <p>
                        This is the accordion panel contents. It can be any HTML content you like. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus consequuntur animi perspiciatis impedit, inventore porro, repudiandae molestias, voluptates quae sapiente placeat aspernatur voluptatibus doloremque iste itaque culpa accusantium, hic officiis voluptas provident neque officia. 
                    </p>
                    <p>
                        Dignissimos maiores! Vitae, reprehenderit hic nobis voluptatem mollitia ab numquam distinctio possimus aliquam animi pariatur neque, dolores modi repellat ut quos, quae cumque voluptatibus eligendi a sint odio assumenda ratione natus! Quibusdam beatae consequatur eligendi aspernatur, praesentium neque, harum adipisci ex. Corporis dignissimos laudantium quia laboriosam fugiat reiciendis iusto mollitia sequi esse cum. Laborum voluptatem explicabo unde reiciendis iusto quaerat quibusdam atque, veniam, illum sed! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam inventore cupiditate, distinctio magni provident repellendus.
                    </p>
                </div>
            </div>
            <div class = "responsiville-accordion-panel">
                <h4 class = "responsiville-accordion-header">
                    This is the accordion panel header. Click it to open/close it.
                </h4>
                <div class = "responsiville-accordion-content">
                    <p>
                        This is the accordion panel contents. It can be any HTML content you like. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus consequuntur animi perspiciatis impedit, inventore porro, repudiandae molestias, voluptates quae sapiente placeat aspernatur voluptatibus doloremque iste itaque culpa accusantium, hic officiis voluptas provident neque officia. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed quis doloremque architecto nisi quidem, expedita, maiores aliquid recusandae ex laborum reiciendis? Perferendis porro quo magni aut sed accusantium maiores nemo mollitia, recusandae ipsum voluptate quisquam.
                    </p>
                    <p>
                        Dignissimos maiores! Vitae, reprehenderit hic nobis voluptatem mollitia ab numquam distinctio possimus aliquam animi pariatur neque, dolores modi repellat ut quos, quae cumque voluptatibus eligendi a sint odio assumenda ratione natus! Quibusdam beatae consequatur eligendi aspernatur, praesentium neque, harum adipisci ex. Corporis dignissimos laudantium quia laboriosam fugiat reiciendis iusto mollitia sequi esse cum. Laborum voluptatem explicabo unde reiciendis iusto quaerat quibusdam atque, veniam, illum sed!
                    </p>
                </div>
            </div>
        </div>



    </article>



<?php include( 'footer.php' ); ?>