<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Responsiville Responsive Element</h1>

        <p>
            The Responsive Element makes an element behave according to specific responsive breakpoints just like the whole of the web page does. In responsive web design one usually handles different screen dimensions as different breakpoints and sets various behaviours and stylings per breakpoint. With the responsive element one can do the same per element, not simply the page.
        </p>

        <p>
            Just like the desired classes are stacked in a <strong>mobile-first</strong> manner in responsive web pages the same happens to responsive elements: responsive breakpoint classes stack up from the smallest to the widest breakpoint mobile-first.
        </p>

        <pre><code class = "language-markup"><!--
            <div class="responsiville-responsiveelement"
                 data-responsiville-responsiveelement-breakpoints='[
                    { "name" : "breakpoint1", "width" : 360  },
                    { "name" : "breakpoint2", "width" : 768  },
                    { "name" : "breakpoint3", "width" : 1024 },
                    { "name" : "breakpoint4", "width" : 9999 }
                 ]'
            >

                ...

            </div>
        --></code></pre>

        <p>
            The class that designates this particular HTML element to become a responsive element is <code>responsiville-responsiveelement</code>.
        </p>

        <p>
            Here is how you can create it <strong>on demand</strong>:
        </p>

        <pre><code class = "language-javascript">
            var responsiveElement = new Responsiville.Responsiveelement({
                element     : '.element',
                breakpoints : [
                    { "name" : "breakpoint1", "width" : 360  },
                    { "name" : "breakpoint2", "width" : 768  },
                    { "name" : "breakpoint3", "width" : 1024 },
                    { "name" : "breakpoint4", "width" : 9999 }
                 ]
            });
        </code></pre>

        <p>
            Note that you do <strong>need</strong> to add one last breakpoint which represents all screens above your desired last breakpoint. This last breakpoint can be set with a very big integer value, ie <code>9999</code>, which exceeds all possible screens. Think of this breakpoint as all bigger screens to infinity. 
        </p>



        <h2>API data attribute</h2>

        <p>
            If the responsive element has not been created manually, which is the easiest and most common case, one can obtain an instance of the underlying <code>Responsiville.Responsiveelement</code> Javascript object, so that it can manipulate the popup via its API, by accessing its <code>responsiville-popup-api</code> data attribute, like this:
        </p>
        <pre><code class = "language-javascript">
            // Obtain the underlying Responsiville.Responsiveelement Javascript object.
            var responsiveElement = $( '.responsiville-responsiveelement' ).data( 'responsiville-responsiveelement-api' );
        </code></pre>



        <h2>Default values</h2>

        <p>
            Here is its full list of settings and default values:
        </p>

        <script type = "text/javascript">
            document.write(
                '<pre><code class = "language-json">' +
                    js_beautify( JSON.stringify( Responsiville.Responsiveelement.defaults ) ) +
                '</code></pre>'
            );
        </script>



        <h2>Working example</h2>

        <p>
            Here is a full working example:
        </p>

        <style type = "text/css">
            .example1 {
                padding: 2em;
                color: white;
            }
            .example1.breakpoint1 {
                background-color: orange;
            }
            .example1.breakpoint2 {
                background-color: red;
            }
            .example1.breakpoint3 {
                background-color: maroon;
            }
                .indicator {
                    display: none;
                }
                .breakpoint1 .indicator1 {
                    display: block;
                }
                .breakpoint2 .indicator1 {
                    display: none;
                }
                .breakpoint2 .indicator2 {
                    display: block;
                }
                .breakpoint3 .indicator2 {
                    display: none;
                }
                .breakpoint3 .indicator3 {
                    display: block;
                }
        </style>

        <div class = "responsiville-responsiveelement example1"
             data-responsiville-responsiveelement-breakpoints = '[
                { "name" : "breakpoint1", "width" : 600  },
                { "name" : "breakpoint2", "width" : 900  },
                { "name" : "breakpoint3", "width" : 9999 }
             ]'
        >

            This is a responsive element whose colour changes along with its width, starting from orange (0-600px), then red (601px-900px) and finally maroon (901px-infinity).

            <div>
                &mdash;&mdash;&mdash; <br />
                <span class = "indicator indicator1">0-600px</span>
                <span class = "indicator indicator2">601-900px</span>
                <span class = "indicator indicator3">901px-Infinity</span>
            </div>

        </div>



    </article>



<?php include( 'footer.php' ); ?>