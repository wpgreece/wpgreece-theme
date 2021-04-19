<?php include( 'header.php' ); ?>



    <article class = "text">



        <h1>Responsiville icon fonts</h1>

        <p>
            Responsiville comes with a set pf predefined icon fonts which have been created in <a href = "http://fontello.com" target="_blank">Fontello</a>. Use the Responsiville Fontello icon font <a href = "../fonts/config.json" target="_blank">configuration file</a> in order to extend them. You can find the current Responsiville icon fonts here:
        </p>

        <style type = "text/css">
            .icon-demo {
                text-align: center;
                margin-bottom: var(--text-rhythm) !important;
            }
                .icon {
                    margin-bottom: calc(1.5 * var(--text-rhythm));
                }
                    .glyph {
                        display: block;
                        margin-bottom: calc(0.333 * var(--text-rhythm));
                        font-family: 'Responsiville icons';
                        font-size: 150%;
                        cursor: hand;
                        cursor: pointer;
                    }
                    .icon-info {
                        font-family: 'Anonymous Pro', Consolas, monospace;
                        display: none;
                        font-size: 85%;
                        line-height: 1.2;
                    }
                    .show-info .icon-info {
                        display: block;
                    }
        </style>

        <script type = "text/javascript">
            $( function () {
                function toggleChange () {
                    if ( $( '#toggle' ).is( ':checked' ) ) {
                        $( '.icon-demo' ).addClass( 'show-info' );
                    } else {
                        $( '.icon-demo' ).removeClass( 'show-info' );
                    }
                }
                $( '#toggle' ).on( 'change', toggleChange );
                toggleChange();
                function search () {
                    var value = $.trim( $( 'input[name=search]' ).val() );
                    $( '.icon-demo' ).
                        find( '.icon' ).
                            each( function () {
                                var $this = $( this );
                                if ( value == '' || $this.is( '[data-css*="' + value + '"]' ) ) {
                                    $this.css( 'display', 'block' );
                                } else {
                                    $this.css( 'display', 'none' );
                                }
                            });
                }
                $( 'input[name=search]' ).on( 'keyup', Responsiville.throttle( search ) );
                $( 'input[name=search]' ).focus();
                search();
                $( '.clear-search' ).on( 'click', function () {
                    $( 'input[name=search]' ).val( '' );
                    search();
                    return false;
                });
            });
        </script>

        <?php $json = json_decode( file_get_contents( '../fonts/config.json' ) ); ?>

        <div class = "icon-demo row">
            <div class = "small-column-100">
                <p>
                    <input class = "input-medium inline" type = "text" name = "search" value = "" size = "20" placeholder = "icon name..." />
                    <a href = "#" class = "clear-search smaller">clear</a>
                    <label class = "smaller" for = "toggle">
                        <input type = "checkbox" id = "toggle" name = "toggle" value = "on" />
                        Toggle icon info
                    </label>
                </p>
            </div>
            <?php foreach ( $json->glyphs as $glyph ) : ?>
            <?php
                $css = $glyph->css;
                $decimal = $glyph->code;
                $hexadecimal = dechex( $decimal );
            ?>
            <div class = "icon small-column-50 tablet-column-33 laptop-column-25 xlarge-column-20" data-css = "<?php echo $css; ?>">
                <span class = "glyph" title = "<?php echo $css; ?> - dec <?php echo $decimal; ?> - hex <?php echo $hexadecimal; ?>">&#x<?php echo $hexadecimal; ?>;</span>
                <span class = "icon-info">
                    dec <?php echo $decimal; ?> <br />
                    hex 0x<?php echo $hexadecimal; ?> <br />
                    HTML &amp;#x<?php echo $hexadecimal; ?>; <br />
                    CSS \<?php echo $hexadecimal; ?> <br />
                    JS \u<?php echo $hexadecimal; ?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>



        <h3>Usage in developmet</h3>

        <pre><code class = "language-css">
            .element {
                font-family: 'Responsiville icons';
            }
            
            .element::before {
                content: '\e815';
                font-family: 'Responsiville icons';
            }
        </code></pre>

        <pre><code class = "language-markup"><!--
            <p>
                Here is an icon used directly in HTML like this: &#xe811;.
            </p>
        --></code></pre>

        <pre><code class = "language-javascript">
            var string_with_icon_font_for_html = 'This is an icon font: &amp;#xe811;.';
            var string_with_icon_font = 'This is an icon font: \ue811.';
        </code></pre>

        <p>
            You can find the Responsiville iconf font in a standalone page here:
        </p>

        <p class = "element">
            <a href = "../fonts/demo.html" title = "Responsiville icon fonts" target = "_blank" class = "button">Responsiville icon fonts</a>
        </p>

    </article>



<?php include( 'footer.php' ); ?>