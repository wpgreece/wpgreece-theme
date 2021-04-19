<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Responsiville Parallax</h1>

        <p>
            Parallax is a visual effect which takes place as the user scrolls down the page and comes as a result of thi scrolling motion. One DOM element is watched as it enters the viewport, becomes visible, and then leaves the viewport, while another element, or elements, or even the same watched element, automatically changes some of its CSS properties. These properties are changed in proportion to the watched element&apos;s visible part within the viewport. So the parallax effect as a whole has a watched element, one or more elements whose CSS properties can be changed and a set of initial and final values for these properties.
        </p>

        <p>
             Here is how you can create a parallax effect <strong>automatically</strong>:
        </p>

        <pre><code class = "language-markup"><!--
            Element that parallaxes its own properties:

            <div class="responsiville-parallax"

                 data-responsiville-parallax-properties='{ 
                     "CSS-PROPERTY-NAME" : { 
                        "from" : FROM-VALUE, 
                        "to"   : TO-VALUE, 
                        "unit" : "UNIT" 
                    } 
                 }'
            >
            ...
            </div>

            Element that parallaxes the properties of other element(s):
            
            <div class="responsiville-parallax"
            
                 data-responsiville-parallax-elements='[
                     { 
                         "element": "ELEMENT-SELECTOR",
                         "properties" : {
                             "CSS-PROPERTY-NAME-1" : {
                                 "from": FROM-VALUE, 
                                 "to"  : TO-VALUE, 
                                 "unit": "UNIT"
                             },
                             "CSS-PROPERTY-NAME-2" : { 
                                 "from": FROM-VALUE, 
                                 "to"  : TO-VALUE, 
                                 "unit": "UNIT"
                             }
                         }
                     },
                     ...
                 ]'
            >
                ...
            </div>
        --></code></pre>
        
        <p>
            Be careful, in the first example the property used is <strong>properties</strong> while in the second example the property used is <strong>elements</strong>. Also, note that the contents of these <strong>data attibutes</strong> are not just Javascript objects, they are <strong>JSON strings</strong>! This means that the data attribute should be wrapped in <strong>single quotes</strong>, the key names should be wrapped in <strong>double quotes</strong> and the key values are proper Javascript <strong>primitives</strong> (ie 20 =&gt; number, "%" =&gt; string, etc).
        </p>

        <p>
            The class that designates the watched HTML element is <code>responsiville-parallax</code>. 
        </p>

        <p>
            Here is how you can create it <strong>on demand</strong>:
        </p>

        <pre><code class = "language-javascript">
            // The element affected by parallax is the watched element itself.
            var parallax1 = new Responsiville.Parallax({
                watch    : '.watched-element',
                properties : {
                    translateX: { from: -50,  to: -50, unit: '%' },
                    translateY: { from:  -35, to: -50, unit: '%' }
                }
            });

            // Only one other element affected by parallax.
            var parallax2 = new Responsiville.Parallax({
                watch    : '.watched-element',
                elements : {
                    element    : '.element',
                    properties : {
                        translateX: { from: -50,  to: -50, unit: '%' },
                        translateY: { from:  -35, to: -50, unit: '%' }
                    }
                }
            });

            // More than one other elements affected by parallax.
            var parallax3 = new Responsiville.Parallax({
                watch    : '.watched-element',
                elements : [
                    { 
                        element    : '.element-1',
                        properties : {
                            translateX: { from: -50,  to: -50, unit: '%' },
                            translateY: { from:  -35, to: -50, unit: '%' }
                        }
                    },
                    { 
                        element    : '.element-2',
                        properties : {
                            translateX: { from: -50,  to: -50, unit: '%' },
                            translateY: { from: -200, to: 150, unit: '%' }
                        }
                    }
                ]
            });
        </code></pre>

        <p>
            Also, instead of passing the initial and final values that produce the parallax animation effect, one may provide a <strong>function callback</strong> which will be called automatically and do whatever the developer programs it to do. The function callback will be given the <strong>element</strong> wrapped in jQuery and the <strong>percentage</strong> of the parallax effect as arguments.
        </p>

        <pre><code class = "language-javascript">
            var parallax = new Responsiville.Parallax({
                watch    : '.watched-element',
                elements : [
                    { 
                        element    : '.element',
                        properties : function ( $element, parallaxPercentage ) {
                            // Do something with $element and parallaxPercentage.
                        }
                    }
                ]
            });
        </code></pre>

        <p>
            Finally, one can define a parallax-like behaviour on a watched element (or its sub-elements) by adding a <strong>class</strong> to it when it appears on or disappears from the screen.
        </p>

        <pre><code class = "language-javascript">
            var parallax = new Responsiville.Parallax({
                watch      : '.watched-element',
                properties : {
                    "addClass"    : "appearClass",
                    "removeClass" : "disappearClass"
                }
            });
        </code></pre>



        <h2>API data attribute</h2>

        <p>
            If the parallax has not been created manually, which is the easiest and most common case, one can obtain an instance of the underlying <code>Responsiville.Parallax</code> Javascript object, so that it can manipulate the parallax via its API, by accessing its <code>responsiville-parallax-api</code> data attribute, like this:
        </p>

        <pre><code class = "language-javascript">
            // Obtain the underlying Responsiville.Parallax Javascript object.
            var parallax = $( '.responsiville-parallax' ).data( 'responsiville-parallax-api' );
        </code></pre>



        <h2>Default values</h2>

        <p>
            Here is its full list of settings and default values:
        </p>

        <script type = "text/javascript">
            document.write(
                '<pre><code class = "language-json">' +
                    js_beautify( JSON.stringify( Responsiville.Parallax.defaults ) ) +
                '</code></pre>'
            );
        </script>

        <p>
            <a href = "http://vanilla.nevma.gr/wp-content/docs/responsiville-jsdoc/" title = "Responsiville Javascript API" target = "_blank" class = "button">Responsiville Javascript API</a>
        </p>



        <h2>Working examples</h2>

        <p>
            Here is a full working example of a parallaxed element where the element itself is watched and its own CSS properties are being changed as the element scrolls in and out of the viewport:
        </p>

        <style type = "text/css">
            .parallax-example {
                position: relative;
                height: 40vh;
                background-image: url('img/photo4.jpg');
                background-repeat: no-repeat;
                background-position: 50% 0;
                background-size: 100% auto;
                margin-bottom: var(--text-rhythm);
            }
            .parallax-example .box {
                position: absolute;
                top: 0;
                left: 0;
                width: 20vh;
                height: 20vh;
                background-color: var(--color-red);
            }
            .parallax-example .box-2 {
                left: auto;
                right: 0;
            }
        </style>

        <div class = "parallax-example parallax-example-1 responsiville-parallax"
             data-responsiville-parallax-properties = '{ 
                "background-position-y": { "from": 0, "to": -20, "unit": "vh" }
            }'
        >
        </div>

        <p>
            Note that this kind of parallax effect is <strong>constant</strong>. It functions on the element continuously as the page scrolls down and then continuously as the page scrolls up. 
        </p>

        <p>
            And the code for this is:
        </p>

        <pre><code class = "language-markup"><!--
            <div class="parallax-example-1 responsiville-parallax"
                 data-responsiville-parallax-properties='{
                    "opacity": { "from": 0, "to": 1, "unit": "" },
                     "background-position-y" : { "from": 0, "to"  : -20, "unit": "vh" } 
                 }'
            >
                ...
            </div>
        --></code></pre>

        <h3>Parallax a containing element&apos;s properties</h3>

        <p>
            In this example the properties which are being parallaxed as a result of the viewport scrolling into and past the watched element belong to another element. This other element lies inside the watched element, however, this is not necessary.
        </p>

        <div class = "parallax-example parallax-example-2 responsiville-parallax"
             data-responsiville-parallax-elements = '{ 
                "element": ".parallax-example-2 .box",
                "properties": { 
                    "translateX": { "from": 0, "to": 40, "unit": "vh" }, 
                    "translateY": { "from": 0, "to": 20, "unit": "vh" } 
                }
            }'
        >

            <div class = "box"></div>

        </div>

        <p>
            And the code for this is:
        </p>

        <pre><code class = "language-markup"><!--
            <div class="parallax-example-2 responsiville-parallax"
                 data-responsiville-parallax-elements='{ 
                     "element" : ".parallax-example-2 .box", 
                     "properties" : { 
                         "translateX": { "from": 0, "to": 40, "unit": "vh" },
                         "translateY": { "from": 0, "to": 20, "unit": "vh" } 
                     }
                 }'
            >

                <div class="box"></div>

            </div>
        --></code></pre>

        <h3>Parallax more than one containing elements&apos; properties</h3>

        <p>
            More than one elements are parallaxed at the same time.
        </p>

        <div class = "parallax-example parallax-example-3 responsiville-parallax"
             data-responsiville-parallax-elements = '[
                {
                    "element": ".parallax-example-3 .box-1", 
                    "properties": { 
                        "translateX": { "from": "0", "to": "40", "unit": "vh" }, 
                        "translateY": { "from": 0, "to": 20, "unit": "vh" }
                    }
                },
                {
                    "element": ".parallax-example-3 .box-2",
                    "properties": {
                        "translateX": { "from": 0, "to": -40, "unit": "vh" },
                        "translateY": { "from": 0, "to": 20, "unit": "vh" }
                    }
                }
            ]'
        >
            
            <div class = "box box-1"></div>
            <div class = "box box-2"></div>

        </div>

        <p>
            And the code for this is:
        </p>

        <pre><code class = "language-markup"><!--
            <div class="parallax-example-3 responsiville-parallax"
                 data-responsiville-parallax-elements='[
                     {
                         "element": ".parallax-example-3 .box-1",
                         "properties": { 
                             "translateX": { "from": 0, "to": 40, "unit": "vh" }, 
                             "translateY": { "from": 0, "to": 20, "unit": "vh" }
                         }
                     }, 
                     {
                         "element": ".parallax-example-3 .box-2",
                         "properties": {
                             "translateX": { "from": 0, "to": -40, "unit": "vh" },
                             "translateY": { "from": 0, "to":  20, "unit": "vh" }
                         }
                     }
                ]'
            >
                <div class="box box-1"></div>
                <div class="box box-2"></div>

            </div>
        --></code></pre>

        <h3>Parallax by changing classes on element appearing and disappearing from screen</h3>

        <p>
            Instead of setting the actual properties that take effect on a parallaxed element we can set one or more classes to it as soon as it appears in the screen, that is the browser viewport. For instance, when we want to do this on the watched element itself:
        </p>

        <style type = "text/css">
            .parallax-example-4 {
                background-position: 50% 50%;
                transition-property: opacity, transform;
                transition-delay: 0.3s;
                transition-duration: 1s;
                transition-timing-function: cubic-bezier(0.42, 0.0, 0.58, 1.0);
                z-index: 1;
                opacity: 0.1;
                transform: translateY(100%);
            }
            .parallax-example-4.appearClass {
                opacity: 1;
                transform: translateY(0);
            }
        </style>
        <script type = "text/javascript">
            function testAppearFunction () {
                console.log( 'APPEAR' );
            }
            function testDisppearFunction () {
                console.log( 'DISAPPEAR' );
            }
        </script>

        <div class = "parallax-example parallax-example-4 responsiville-parallax"
             data-responsiville-parallax-offsetTop    = "200"
             data-responsiville-parallax-offsetBottom = "200"
             data-responsiville-parallax-onAppear     = "testAppearFunction"
             data-responsiville-parallax-onDisappear  = "testDisppearFunction"
             data-responsiville-parallax-runOnce      = "false"
             data-responsiville-parallax-properties   = '{ 
                "addClass"    : "appearClass",
                "removeClass" : "disappearClass"
            }'
        >
        </div>

        <p>
            And the code for this is:
        </p>

        <pre><code class = "language-markup"><!--

            <div class="parallax-example parallax-example-4 responsiville-parallax"
                 data-responsiville-parallax-offsetTop="200"
                 data-responsiville-parallax-offsetBottom="200"
                 data-responsiville-parallax-onAppear="testAppearFunction"
                 data-responsiville-parallax-onDisappear="testDisppearFunction"
                 data-responsiville-parallax-runOnce="false"
                 data-responsiville-parallax-properties='{ 
                    "addClass"    : "appearClass",
                    "removeClass" : "disappearClass"
                }'
            >
            </div>
        --></code></pre>

        <p>
            In the above example note that <strong>testAppearFunction</strong> and <strong>testDisppearFunction</strong> are Javascript functions that will run on the respective events. If simple strings instead of functions are given, they will be treated as classed to be added on the appear event and added on the disappear event. On the other hand the <strong>appearClass</strong> is a class name that will be added to the element once it appears and the <strong>disappearClass</strong> is a class name that will be added from the element once it disappears. All the previous settings can be set and run at the same time on the same element.
        </p>

        <p>
            And, of course, you can use all the previous combinations of properties and elements that they will affect in order to parallax the watched element or any other element(s) depending on it.
        </p>



    </article>



<?php include( 'footer.php' ); ?>