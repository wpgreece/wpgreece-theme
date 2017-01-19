<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Initialising Responsiville</h1>

        <p>
            The easiest way to initialise Responsiville is via the automatic method described in the previous section. This method is also the default one. However, if you want to control the way the way and the timing of the initialisation of Responsiville you can do it manually.
        </p>



        <h2>The automatic way</h2>

        <p>
            If you do not set anything, which means that the default values are in effect, the Responsiville framework initialises automatically. The global variable which controls this behaviour is <code>RESPONSIVILLE_AUTO_INIT</code>. This value propagates from the main Responsiville object (more on this later on) to all the Responsiville modules. This means that if you set it to <code>true</code> then the main Responsiville object and all its included modules will actually automatically initialise. But if you set it to <code>false</code> this means that you will have to initialise the main Responsiville and each of its modules manually.
        </p>



        <h2>The manual way</h2>

        <p>
            In order to initialise Responsiville the manual way one has to turn off the automatic initialisation by setting the <code>RESPONSIVILLE_AUTO_INIT</code> to <code>false</code>. This has to be done somewhere before the Responsiville scripts are included in the HTML. Then, one can initialise the framework whenever they need, but it is recommended to do this either upon the <code>DOMContentLoaded</code> event or as shortly after it as possible. For instance in jQuery terms one could do:
        </p>

        <pre><code class = "language-javascript">
            $( function () {
            
                // Initialise the Responsiville framework main object.
                var responsiville = new Responsiville.Main({
                    debug   : true,
                    debugUI : true
                });
                
            });
        </code></pre>

        <p>
            And this is its full set of settings:
        </p>

        <script type = "text/javascript">
            document.write(
                '<pre><code class="language-json">' +
                    js_beautify( JSON.stringify( Responsiville.Main.defaults ) ) +
                '</code></pre>'
            );
        </script>

        <p>
            Note that the breakpoints themselves are part of the initialisation settings of the framework. This means that the developer may add breakpoints, if they see it necessary, in order to further fine tune the appearance of a web page across devices. 
        </p>



    </article>



<?php include( 'footer.php' ); ?>