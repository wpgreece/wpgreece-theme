/**
 * Takes an element and returns its highest parent, or the element itself, after
 * which it is most suitable for a row with columns to be inserted. For instance
 * when the element is a table td cell the the row of columns should be inserted
 * after the table and not inside the cell. Also, if the element is already
 * inside a column then the new row of columns should be inserted after the 
 * parent row.
 * 
 * @param {Element} element The element whose highest parent we seek.
 * 
 * @return {tinyMCE.dom.DOMQuery} The highest parent element object.
 */

function vanilla_get_element_to_insert_after ( element ) {

    var $highestParent = tinymce.dom.DomQuery( element ).closest( '.mceTemp, .wpview-wrap, p, blockquote, pre, table, ul, ol, dl, h1, h2, h3, h4, h5, h6' );
    
    if ( $highestParent.length > 0 ) {

        var $evenHigherParent = $highestParent.eq( 0 ).closest( '.row, blockquote, table' );

        if ( $evenHigherParent.length > 0 ) {
            $highestParent = $evenHigherParent;
        }

    }

    return $highestParent;

}



/**
 * Creates a TinyMCE plugin which adds a special button to the editor that 
 * facilitates the insertion of accordion elements.
 */

tinymce.create( 'tinymce.plugins.VanillaAccordion', {

    /**
     * The TinyMCE editor instance the plugin instance is associated with.
     * 
     * @type {tinymce.Editor}
     */
    
    editor: null,


    /**
     * Initializes the TinyMCE plugin by declaring the desired command and the
     * button that activates it. The command adds an accordion element shortcode
     * to the text.
     * 
     * @type {Function}
     * 
     * @param {tinymce.Editor} editor The TinyMCE editor.
     * @param {string}         url    The base url of the editor's assets.
     *
     * @return {void} Nothing!
     */

    init : function( editor, url ) {

        this.editor = editor;

        /**
         * Add accordion element editor command.
         */

        editor.addCommand( 'accordion', function () {

            var $elementToInsertAfter = vanilla_get_element_to_insert_after( this.selection.getSel().focusNode )

            var accordionHTML = 
                '<p>' + 
                    '[accordion]<br />' +
                        '[accordion-panel]<br />' + 
                            '[accordion-header]<h3>Title&hellip;</h3>[/accordion-header]<br />' + 
                            '[accordion-excerpt]<p><em>Excerpt&hellip;</em></p>[/accordion-excerpt]<br />' + 
                            '[accordion-content]<p>Content&hellip;</p>[/accordion-content]<br />' + 
                        '[/accordion-panel]<br />' + 
                    '[/accordion]' +
                '</p>';

            $elementToInsertAfter.after( accordionHTML );

            this.undoManager.add( this.getBody() );

        }, editor );



        /**
         * Add accordion element toolbar button.
         */

        editor.addButton( 'accordion', {
            title : 'Adds an accordion element',
            cmd   : 'accordion'
        });

    },

    

    /**
     * Returns information about this plugin.

     * @type {Function}
     *
     * @return {Object} The information.
     */

    getInfo : function () {

        return {
            longname  : 'Vanilla TinyMCE accordion plugin',
            author    : 'Nevma',
            authorurl : 'http://www.nevma.gr',
            infourl   : 'http://www.nevma.gr',
            version   : '1.0'
        };

    }

});



// Add the plugin which was just created to the plugin manager.

tinymce.PluginManager.add( 'vanillaaccordion', tinymce.plugins.VanillaAccordion );