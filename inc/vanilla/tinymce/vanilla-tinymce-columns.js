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
 * Creates a TinyMCE plugin which adds some special buttons to the editor that
 * facilitate the insertion of rows with columns inside the editor's text. The
 * available rows may have 2, 3 or 4 columns. Columns cannot contain other rows
 * with columns inside them, in which case new rows will be inserted right after
 * them in the DOM.
 */

tinymce.create( 'tinymce.plugins.Vanilla', {

    /**
     * The TinyMCE editor instance the plugin instance is associated with.
     * 
     * @type {tinymce.Editor}
     */
    
    editor: null,


    /**
     * Controls whether column deletion via keyboard backspace and delete are
     * allowed. The reason for this is that, when deleting columns like this, 
     * the editor's DOM might become inconsistent. This is experimental and is
     * currently not enabled by default.
     * 
     * @type {Boolean}
     */
    
    DISALLOW_COLUMN_DELETION: false,



    /**
     * Initializes the TinyMCE plugin by declaring the desired commands and the
     * buttons that activate them. The commands add 2, 3 and 4 column rows to 
     * the editor's text. Each command has its own button.
     * 
     * @type {Function}
     * 
     * @param {tinymce.Editor} editor The TinyMCE editor.
     * @param {string}         url    The base url of the editor's assets.
     *
     * @return {void} Nothing!
     */

    init : function( editor, url ) {

        // Cache editor variable.

        this.editor = editor;

        

        if ( editor.plugins['vanillacolumns'].DISALLOW_COLUMN_DELETION ) {

            /*
                Deleting an empty column with a backspace or a button breaks the
                layout, so we can try to prevent these keystrokes. Hitting a new
                line with enter on an empty paragraph also breaks the layout, so
                we can try to prevent this, too! This is a bit experimental as a
                feature.
             */

            editor.on( 'keydown', function( event ) {

                var BACKSPACE = 8;
                var DELETE    = 46;
                var ENTER     = 13;



                // If backspace, delete or enter keys are hit.

                if ( event.keyCode == BACKSPACE || event.keyCode == DELETE || event.keyCode == ENTER ) {

                    var node   = editor.selection.getNode();
                    var range  = editor.selection.getRng();
                    var parent = node.parentNode;

                    // And we are inside an empty column which must be protected.

                    if ( editor.$( parent ).is( '.column' )  && range.startOffset == 0 ) {

                        // Then do not allow it to be deleted.

                        return false;

                    }

                    // Otherwise allow the keystroke.

                    return true;

                }

            });

        }



        /*
            Sets up a key combination unlock the user from inside an empty
            column. A backspace in an empty column will trigger the handler that
            restores the deleted columns while a new line in an empty column
            will break the layout. So with a Ctrl+Enter a new paragraph is
            inserted outside the columns where the user can focus the cursor.
         */

        editor.on( 'keydown', function( event ) {

            var ENTER = 13;

            if ( event.keyCode == ENTER && event.ctrlKey ) {

                var node = editor.selection.getNode();

                var $elementToInsertAfter = vanilla_get_element_to_insert_after( node )

                $elementToInsertAfter.after( editor.plugins['vanillacolumns'].createParagraph() );

                return false;

            }

            return true;

        });



        /**
         * After the editor has been initialized a mutation observer is added 
         * its document which detects columns being deleted by accident and
         * restores them. It restores all deleted columns, because it is very 
         * difficult to detect the particular column that was deleted.
         */

        editor.on( 'init', function ( event ) {

            var body = editor.getBody();

            // Add a mutation observer that checks for deleted columns in the TinyMCE DOM.
             
            var deletedColumnsObserver = new MutationObserver( function ( mutations ) {

                // Check if a column has been removed.

                var protectedNodeDeleted = false; 

                for ( var k = 0; k < mutations.length; k++ ) {

                    var mutation     = mutations[k];
                    var removedNodes = mutation.removedNodes;

                    if ( mutation.type != 'childList' || removedNodes.length == 0 ) {
                        continue;
                    }

                    for ( var i = 0; i < removedNodes.length; i++ ) {

                        var $removedNode = editor.$( mutation.removedNodes.item( i ) );
                        
                        protectedNodeDeleted = $removedNode.is( '.column' ); 

                        if ( protectedNodeDeleted ) {
                            break;
                        }

                    }
                    
                }

                // If no column was removed the do nothing.

                if ( ! protectedNodeDeleted ) {
                    return;
                } 

                

                // If a column was indeed removed then restore deleted columns in all rows.
                
                var $rows = editor.$( body ).find( '.row' );

                for ( var k = 0; k < $rows.length; k++ ) {

                    $row = $rows.eq( k );

                    var column50s = $row.find( '.column-50' );
                    if ( column50s.length > 0 ) {
                        for ( var m = column50s.length; m < 2; m++ ) {
                            $row.append( editor.plugins['vanillacolumns'].createColumn( 50 ) );
                        }
                    }
                    
                    var column33s = $row.find( '.column-33' );
                    if ( column33s.length > 0 ) {
                        for ( var m = column33s.length; m < 3; m++ ) {
                            $row.append( editor.plugins['vanillacolumns'].createColumn( 33 ) );
                        }
                    }
                    
                    var column25s = $row.find( '.column-25' );
                    if ( column25s.length > 0 ) {
                        for ( var m = column25s.length; m < 4; m++ ) {
                            $row.append( editor.plugins['vanillacolumns'].createColumn( 25 ) );
                        }
                    }

                }

            });

            deletedColumnsObserver.observe( body, { childList: true, subtree: true });



            // Add a mutation observer that checks for added elements in the TinyMCE DOM.
             
            var rowContentsObserver = new MutationObserver( function ( mutations ) {

                // Check the contents of a row were changed.

                var rowContentsChanged = false; 

                for ( var k = 0; k < mutations.length; k++ ) {

                    var mutation   = mutations[k];
                    var addedNodes = mutation.addedNodes;

                    if ( mutation.type != 'childList' || addedNodes.length == 0 ) {
                        continue;
                    }

                    rowContentsChanged = true;
                    break;
                    
                }

                // If no column was removed the do nothing.

                if ( ! rowContentsChanged ) {
                    return;
                } 

                

                // If a column was indeed removed then restore deleted columns in all rows.
                
                var $rows = editor.$( body ).find( '.row' );

                for ( var k = 0; k < $rows.length; k++ ) {

                    $row = $rows.eq( k );

                    var $children = $row.children();

                    for ( var i = 0; i < $children.length; i++ ) {
                        $child = $children.eq( i );
                        if ( $child.parent().is( '.row' ) &&  ! $child.is( '.column' ) ) {
                            $child.remove();
                        }
                    }

                }

            });

            rowContentsObserver.observe( body, { childList: true, subtree: true });
             
        });



        /**
         * Add two columns editor command.
         */

        editor.addCommand( 'twocolumns', function () {

            var $elementToInsertAfter = vanilla_get_element_to_insert_after( this.selection.getSel().focusNode )

            var row = this.plugins['vanillacolumns'].createRow( 50 );
             
            // Prefer "$element::after" because "editor::insertContent" seems to strip away the bogus BRs.

            $elementToInsertAfter.after( row );

            this.undoManager.add( this.getBody() );

        }, editor );



        /**
         * Add three columns editor command.
         */

        editor.addCommand( 'threecolumns', function () {
            
            var $elementToInsertAfter = vanilla_get_element_to_insert_after( this.selection.getSel().focusNode )

            var row = this.plugins['vanillacolumns'].createRow( 33 );
             
            // Prefer "$element::after" because "editor::insertContent" strips away the bogus BRs.

            $elementToInsertAfter.after( row );

            this.undoManager.add( this.getBody() );

        }, editor );



        /**
         * Add four columns editor command.
         */
        
        editor.addCommand( 'fourcolumns', function () {

            var $elementToInsertAfter = vanilla_get_element_to_insert_after( this.selection.getSel().focusNode )

            var row = this.plugins['vanillacolumns'].createRow( 25 );
             
            // Prefer "$element::after" because "editor::insertContent" strips away the bogus BRs.

            $elementToInsertAfter.after( row );

            this.undoManager.add( this.getBody() );

        }, editor );


        
        /**
         * Add two columns toolbar button.
         */

        editor.addButton( 'twocolumns', {
            title : 'Adds a two column row',
            cmd   : 'twocolumns'
        });



        /**
         * Add three columns toolbar button.
         */

        editor.addButton( 'threecolumns', {
            title : 'Adds a three column row',
            cmd   : 'threecolumns'
        });



        /**
         * Add four columns toolbar button.
         */

        editor.addButton( 'fourcolumns', {
            title : 'Adds a four column row',
            cmd   : 'fourcolumns'
        });

    },



    /**
     * Creates a - supposedly - empty paragraph with a bogus BR inside it.
     * 
     * @type {Function}
     *
     * @return {Element} The - supposedly - empty paragraph.
     */

    createParagraph : function () {

        var p  = this.editor.dom.create( 'p' );
        var br = this.editor.dom.create( 'br', { 'data-mce-bogus' : '1' } );

        this.editor.$( p ).append( br );

        return p;

    },



    /**
     * Creates a column to be positioned inside a row.
     * 
     * @type {Function}
     *
     * @param {int} percent A number indicating the type of columns we need to 
     *                      be created. For example: 50 will produce half 
     *                      columns, 33 will produce one third colums, 25 will
     *                      produce one quarter columns.
     *
     * @return {Element} The column DIV Element with an empty paragraph, which
     *                   means a paragraph with a bogus BR in it, so that the
     *                   user can click into it.
     */

    createColumn : function ( percent ) {

        var column = this.editor.dom.create( 'div', { 'class' : 'column column-' + percent + ' tinymce-column' } );
        var p      = this.createParagraph();

        this.editor.$( column ).append( p );

        return column;

    },



    /**
     * Creates a row with columns.
     * 
     * @type {Function}
     *
     * @param {int} percent A number indicating the type of columns we need to 
     *                      add in the row. For example: 50 will produce half 
     *                      columns, 33 will produce one third colums, 25 will
     *                      produce one quarter columns.
     *
     * @return {Element} The row DIV Element with all necessary columns.
     */

    createRow : function ( percent ) {

        var count = Math.round( 100 / percent );

        var row = this.editor.dom.create( 'div', { 'class' : 'row tinymce-row tinymce-row-span-' + count } );

        for ( var k = 0; k < count; k++ ) {
            var column = this.createColumn( percent );
            this.editor.$( row ).append( column );
        }

        return row;

    },



    /**
     * Returns information about this plugin.

     * @type {Function}
     *
     * @return {Object} The information.
     */

    getInfo : function () {

        return {
            longname  : 'Vanilla TinyMCE rows and columns plugin',
            author    : 'Nevma',
            authorurl : 'http://www.nevma.gr',
            infourl   : 'http://www.nevma.gr',
            version   : '1.0'
        };

    }

});



// Add the plugin which was just created to the plugin manager.

tinymce.PluginManager.add( 'vanillacolumns', tinymce.plugins.Vanilla );