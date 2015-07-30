/**
 * Spyropress Builder
 */
var builder = null;
(function($){

// Init Engine
$(document).ready( function() {
    builder.init();
});

// Logger
$.log = function (text) {
    if (typeof (window['console']) != 'undefined') console.log(text);
};

/**
 * Builder
 */
builder = {

    // Options
    opts: { },

    // Dialogs
    dialogs: {
        delete_row: '#builder-delete-row',
        delete_column: '#builder-delete-column',
        delete_module: '#builder-delete-module',
        error: '#builder-error-popup',
        module: '#builder-modules',
        reset: '#builder-reset-popup',
        popup_wrapper: '#builder-popup-wrapper',
        row_options: '#builder-row-options',

        modal: {
            opacity: '65',
            overlayId: 'builder-popup-overlay',
            containerId: 'builder-popup-placeholder',
            minWidth:840,
            maxWidth:840,
            minHeight:450,
            maxHeight:540,
            close: true,
            closeClass: 'builder-popup-close',
            onClose: function(dialog) {
                
                // properly destroy the editor on cancel
                $( '.builder-rich-text', builder.dialogs.popup_wrapper ).each(function() {
                    var $this = $(this)
                        tiny_ed = $this.attr('id');
    
                    r = tinyMCE.remove( tinyMCE.get( tiny_ed ) );
                });           
            
            
                builder.spinner.hide_reorder();
                builder.spinner.hide_column();
                $.modal.close();
                
                //builder.modules.editing = null;
            }
        },

        small_modal: {
            opacity: '65',
            overlayId: 'builder-popup-overlay',
            containerId: 'builder-popup-placeholder',
            minWidth:400,
            maxWidth:840,
            minHeight:450,
            maxHeight:540,
            close: true,
            closeClass: 'builder-popup-close',
            onClose: function(dialog) {
                // properly destroy the editor on cancel
                $( '.builder-rich-text', builder.dialogs.popup_wrapper ).each(function() {
                    var $this = $(this)
                        tiny_ed = $this.attr('id');
    
                    r = tinyMCE.remove( tinyMCE.get( tiny_ed ) );
                });           
            
            
                builder.spinner.hide_reorder();
                builder.spinner.hide_column();
                $.modal.close();
                
                //builder.modules.editing = null;
            }
        },
    },

    init: function() {

        $builder = $( '#builder' );
        if( ! $builder.length ) return false;

        // insert into DOM
        $( '#titlediv' ).after( $builder );

        this.rows.init();
        this.columns.init();
        this.modules.init();

        this.bind_triggers();
        this.tabs();
        this.options_list();
    },

    bind_triggers: function() {
        var b = this;

        // Reset Trigger
        $( b ).bind( 'do-reset-builder', b.reset_builder );
    },

    tabs: function() {
        var b = this,
            $tabs = $( 'a', '#builder-tabs' );

        $tabs.click( function( event ) {
            event.preventDefault();

            var $this = $(this),
                target = $this.attr('href'),
                $target = $(target);

            if( $target.is( ':visible' ) ) return false;

            $this.addClass( 'nav-tab-active' ).siblings().each(function() {
                $$this = $(this);
                $$this.removeClass( 'nav-tab-active' );
                $( $$this.attr( 'href' ) ).hide();
            });

            switch( target ) {
                case '#postdivrich':
                case '#postdiv':
                b.toggle_media_buttons('wordpress');
                $target.fadeIn();
                break;
            case '#builder-data':
                b.toggle_media_buttons('build');
                b.welcome.show();
                $target.fadeIn();
                break;
            }
        });

        // hide tab content if its not the active tab
        $tabs.each(function() {
            $this = $(this);
            if ( $this.hasClass( 'nav-tab-active' ) ) {
                $this.trigger('click');
            }
        });
    },

    toggle_media_buttons: function( target ) {
        var mediaButtons = $( '#wp-content-media-buttons' );

        switch ( target ) {
            case 'wordpress':
                $( '#wp-content-editor-tools' ).append( mediaButtons );
                break;
            case 'build':
                $( '#builder-media-toolbar' ).append( mediaButtons );
                break;
        }
    },

    options_list: function() {
        var b = this;

        // global 'click' off handler
        $( 'body' ).click( function() {
            if ( $( '#builder-option-list' ).is( ':visible' ) )
                b.toggle_options_list();
        });

        // option_list handler
        $( '.toggle-option-list' ).live( 'click', function( event ) {
            event.preventDefault();
            b.toggle_options_list();
        });

        // error popup close handler
        $( '#builder-error-popup-close' ).live( 'click', function(event) {
            event.preventDefault();

            b.helpers.hide_popup_activity( b.dialogs.error );
            b.spinner.hide_reorder();
            b.spinner.hide_column();
        });

        // reset_button handler
        $( '#reset-builder-data' ).click( function( event ) {
            event.preventDefault();

            // pop dialog
            $( b.dialogs.reset ).modal( b.dialogs.small_modal );

            $( '#builder-reset-confirm', b.dialogs.reset ).click(function( event ) {
                event.preventDefault();

                if ( !b.resetting ) {
                    b.resetting = true;

                    b.helpers.show_popup_activity( b.dialogs.reset );
                    $( '#builder-sortables-container' ).slideUp( 'normal', function() {
                        b.helpers.do_ajax( 'reset_builder', { }, 'do-reset-builder' );
                    });
                }
            });

            $( '#builder-reset-popup-close', b.dialogs.reset ).click( function( event ) {
                event.preventDefault();
                b.resetting = false;
            });
        });
    },

    toggle_options_list: function() {
        $( '#builder-option-list' ).fadeToggle();

        var $list = $( '.builder-options', '.builder-header' );

        if ( $list.hasClass( 'builder-options-active' ) ) {
            $list.removeClass( 'builder-options-active' );
        }
        else {
            $list.addClass( 'builder-options-active' );
        }
    },

    reset_builder: function( event, result ) {
        var b = this;

        // resetting data
        b.modules.editing = null;
        b.modules.deleting = null;

        if ( !result.success ) {
            b.helpers.do_error(result);
            return false;
        }

        $.modal.close();
        $( '#builder-sortables-container' ).children( '.builder-row' ).remove().end()
            .slideDown( 'normal', function() {
                b.welcome.show();
            });

        b.resetting = false;
        return true;
    },

}; // builder_end

/**
 * Builder Rows
 */
builder.rows = {

    init: function() {
        var b = builder,
            r = this;

        this.bind_triggers();

        // row sortables
        $( '#builder-sortables-container' ).sortable({
            axis: 'y',
            tolerance: 'pointer',
            cancel: '.builder-row-delete',
            forcePlaceholderSize: true,
            handle: '.builder-row-handle',
            helper: 'clone',
            items: '.builder-row',
            opacity: 0.8,
            revert: 300,
            placeholder: 'builder-row-draggable-placeholder',
            update: r.reorder_rows
        });

        // selector drawer handler
        $( '#builder-row-add' ).click( function( event ){
            event.preventDefault();
            r.toggle_row_drawer();
        });

        // insert row handler
        $( '#builder' ).on( 'click', '.row-action-add', function(event) {
            event.preventDefault();

            var row_type = $(this).data( 'row-type' );
            $( '#builder-rows' ).slideToggle( 'normal', function() {

                if ( !r.inserting ) {
                    r.inserting = true;

                    if ( !b.opts.welcome_removed ) {
                        b.welcome.hide();
                    }

                    $( '#rows-loader' ).slideDown( 'fast', function() {

                        if ( $( '#post_ID' ).val() < 0 ) {
                            b.helpers.init_auto_save( 'rows.add_row', row_type );
                            return false;
                        }

                        b.helpers.do_ajax( 'new_row', { row_type: row_type }, 'do-add-row' );
                    });
                }
            });
        });

        // Row Toggle
        $( '#builder' ).on( 'click', '.toggle-row', function(event) {
            event.preventDefault();

            var $this = $(this).parents('.builder-row');
            $this.find('.toggle-container').slideToggle('normal', function(){
                $this.toggleClass('active');
            });
        });

        // Delete Row Selectors
        $( '#builder' ).on( 'click', '.builder-row-delete', function( event ) {
            event.preventDefault();

            var row_id = $(this).parents('.builder-row').attr('id');

            $( b.dialogs.delete_row ).modal( b.dialogs.small_modal );
            $( '#builder-delete-row-confirm', b.dialogs.delete_row ).click(function() {
                if ( !r.removing ) {
                    r.removing = true;

                    b.helpers.show_popup_activity( b.dialogs.delete_row );
                    b.helpers.do_ajax( 'delete_row', { row_id: row_id }, 'do-delete-row' );
                }
            });
        });

        // Row Options
        $( '#builder' ).on( 'click', '.builder-row-options', function( event ){
            event.preventDefault();

            var row_id = $(this).parents('.builder-row').attr('id');

            r.editing_row = row_id;
            b.spinner.show_reorder();
            b.helpers.do_ajax( 'edit_row', { row_id: row_id }, 'edit-module-response' );
        });
        
        // Row Option Form Submit Button
        $( 'body' ).on( 'click', '#row-option-form-submit', function( event ) {
            event.preventDefault();

            $(this).closest('form').submit();
        });
        
        $( 'form.builder-row-option-form' ).live( 'submit', function( event ) {
            event.preventDefault();
            
            var $this = $(this),
                m = builder.modules;
            
            b.messenger.clear_message();
            b.helpers.show_popup_activity( $this );
            
            save_callback_data = {
                form_id: $this.attr('id'),
                is_valid: true
            };
            
            $( b ).trigger( 'do-module-save-callback', [save_callback_data] );
            if ( false === save_callback_data.is_valid ) {
                b.helpers.hide_popup_activity( b.dialogs.popup_wrapper );
                return false;
            }
            
            var data = {
                'form_data': $this.formParams(),
                'row_id': r.editing_row,
                'module_type': $(':input[name=module_type]', $this).val(),
            };
            
            b.helpers.do_ajax( 'save_row', data, 'submit-row-form-response' );
            return true;
        
        });
        
        // Close Module Edit Popup
        $( '#builder-row-option-close' ).live( 'click', function( event ) {
            event.preventDefault();
            
            b.spinner.hide_reorder();
        });
    },

    bind_triggers: function() {
        var b = builder,
            r = this;

        $( b ).bind( 'do-add-row', r.row_added );
        $( b ).bind( 'do-delete-row', r.row_deleted );
        $( b ).bind( 'do-reorder-rows', r.rows_reordered );
        $( b ).bind( 'submit-row-form-response', r.submit_row_form );
    },

    row_added: function( event, row ) {
        var b = builder,
            r = builder.rows;

        $('#rows-loader').hide();
        r.inserting = false;

        if ( !row.success ) {
            b.helpers.do_error( row );
            return false;
        }

        $( '#builder-sortables-container' ).append( $( row.html ) ).sortable( 'refresh' );

        b.modules.init_sortables();
        b.messenger.set_message( row.message, 'confirm' );

        // trigger after row inserted
        $( b ).trigger( 'new-row-inserted', row );

        return true;
    },

    row_deleted: function( event, row ) {
        var b = builder,
            r = builder.rows;

        if ( !row.success ) {
            b.helpers.do_error( row );
            return false;
        }
        
        // moving column drawer away
        $( '#builder-rows' ).after( $( '#builder-columns-container' ) );

        $( '#' + row.row_id, '#builder-sortables-container' ).slideUp('fast',function() {
            $(this).remove();
            $.modal.close();
            b.helpers.hide_popup_activity( b.dialogs.delete_row );
        });

        b.messenger.set_message( row.message, 'confirm' );
        r.removing = false;
        return true;
    },

    reorder_rows: function( event, ui ) {
        var b = builder,
            items = $('#builder-sortables-container').sortable('toArray');

        b.spinner.show_reorder();
        b.helpers.do_ajax( 'reorder_rows', { order:items.toString() }, 'do-reorder-rows' );
    },

    rows_reordered: function( event, result ) {
        var b = builder;

        if ( !result.success ) {
            b.helpers.do_error( ret );
            return false;
        }

        b.spinner.hide_reorder();
        b.messenger.set_message( result.message, 'confirm' );
        return true;
    },
    
    submit_row_form: function( event, row ) {
        var b = builder,
            r = builder.rows;
        
        if ( !row.success ) {
            b.helpers.do_error(row);
            return false;
        }
        
        r.editing_row = null;
        b.messenger.set_message( row.message, 'confirm' );
        $.modal.close();
        b.spinner.hide_reorder();
        b.helpers.hide_popup_activity( b.dialogs.popup_wrapper );
        return false;
    },

    toggle_row_drawer: function() {
        $( '#builder-rows' ).slideToggle();
    }

}; // rows_end

/**
 * Builder Columns
 */
builder.columns = {

    init: function() {
        var b = builder,
            c = this;

        this.bind_triggers();

        // Column Selector Drawer
        $( '#builder' ).on( 'click', '.builder-row-add-column', function( event ) {
            event.preventDefault();

            for_row = $(this).parents('.builder-row').attr('id');
            c.toggle_column_drawer( for_row );
        });

        // Insert Column Selectors
        $( '#builder' ).on( 'click', '.column-action-add', function( event ) {
            event.preventDefault();

            var $this = $(this),
                $container = $('#builder-columns-container'),
                column_type = $this.data( 'column-type' ),
                row_id = $container.parents( '.builder-row' ).attr( 'id' );

            $container.slideUp();

            if ( !c.inserting ) {
                c.inserting = true;

                builder.spinner.show_column( row_id );
                b.helpers.do_ajax( 'new_column', { col_type: column_type, row_id: row_id }, 'do-add-column' );

                return true;
            }
        });

        // Delete Column Selectors
        $( '#builder' ).on( 'click', '.builder-column-delete', function( event ) {
            event.preventDefault();

            var $this = $(this),
                row_id = $this.parents( '.builder-row' ).attr( 'id' ),
                column_id = $this.parents( '.builder-row-column' ).attr( 'id' );

            $( b.dialogs.delete_column ).modal( b.dialogs.small_modal );

            $( '#builder-delete-column-confirm', b.dialogs.delete_column ).click( function() {

                if ( !c.removing ) {
                    c.removing = true;
                    var data = {
                        row_id: row_id,
                        col_id: column_id
                    };

                    b.helpers.show_popup_activity( b.dialogs.delete_column );
                    b.helpers.do_ajax( 'delete_column', data, 'do-delete-column' );
                }
            });
        });
    },

    bind_triggers: function() {
        var b = builder,
            c = builder.columns;

        $( b ).bind( 'do-add-column', c.column_added );
        $( b ).bind( 'do-delete-column', c.column_deleted );
    },

    column_added: function( event, column ) {
        var b = builder,
            c = builder.columns;

        b.spinner.hide_column();
        c.inserting = false;

        if ( !column.success ) {
            b.helpers.do_error( column );
            return false;
        }

        row_id = '#' + column.row_id;

        $( '.builder-row-column:last', row_id ).after( $( column.html ) );
        $( '.row-empty', row_id ).remove();

        b.modules.init_sortables();
        b.messenger.set_message( column.message, 'confirm' );

        $( b ).trigger( 'new-column-inserted', column );
        return true;
    },

    column_deleted: function( event, column ) {
        var b = builder,
            c = builder.columns;

        if ( !column.success ) {
            b.helpers.do_error( column );
            return false;
        }

        row_id = '#' + column.row_id;

        $( '#' + column.col_id, '#builder-sortables-container' ).fadeOut( 'fast',function() {
            $(this).remove();

            $row = $( '.builder-row-columns', row_id );
            $row.empty();
            $row.append( $( column.html ) );

            if( b.helpers.hasColumns( column.row_id ) ) {
                $( '.row-empty', row_id ).remove();
            }

            $.modal.close();
            b.helpers.hide_popup_activity( b.dialogs.delete_column );
        });

        b.messenger.set_message( column.message, 'confirm' );
        c.removing = false;

        return true;
    },

    toggle_column_drawer: function( for_row ) {
        var b = builder,
            c = builder.columns;
            $drawer = $( '#builder-columns-container' ),
            $row = $( '#' + for_row );

        if( $drawer.is( ':visible' ) && !$row.hasClass( 'current' ) ) {
            $drawer.slideUp( 'normal', function() {
                $( '.builder-row.current' ).removeClass( 'current' );
                $row.toggleClass( 'current' ).find( '.row-toolbar' ).after( $drawer );
                $drawer.slideToggle();
            });
        }
        else {
            $row.toggleClass( 'current' ).find( '.row-toolbar' ).after( $drawer );
            $drawer.slideToggle();
        }
    }

}; // columns_end

/**
 * Builder Modules
 */
builder.modules = {

    moduleSortables: null,
    sortables: {
        sender: null,
        receiver: null
    },
    
    init: function() {
        var b= builder,
            m = this;

        this.bind_triggers();
        this.init_sortables();

        // add module handler
        $( '#builder').on( 'click', '.builder-module-add', function( event ) {
            event.preventDefault();

            var $this = $(this),
                row_id = $this.parents( '.builder-row' ).attr( 'id' ),
                column_id = $this.parents( '.builder-row-column' ).attr( 'id' );

            m.editing = {
                'row_id': row_id,
                'col_id': column_id
            };

            $( b.dialogs.module ).modal( b.dialogs.modal );
        });

        // module selection handler
        $( '.builder-module-list' ).on( 'click', '.builder-module-insert', function( event ) {
            event.preventDefault();

            $.extend( m.editing, { 'module_type': $(this).data( 'module-type' ) } );

            b.helpers.show_popup_activity( b.dialogs.module );
            m.edit_module();

        });

        // Close Modules Popup
        /*$( '#builder' ).on( 'click', '#builder-modules-popup-close', function( event ) {
            event.preventDefault();

            m.editing = null;
            b.spinner.hide_reorder();
        });*/

        // Module Form Submit Button Selectors
        $( 'body' ).on( 'click', '#module-edit-form-submit', function( event ) {
            event.preventDefault();

            $(this).closest('form.builder-module-edit-form').submit();
        });

        // Handle Module Form Submission
        $( 'form.builder-module-edit-form' ).live( 'submit', function( event ) {
            event.preventDefault();
            m.submit_module( $(this), {}, 'submit-module-response' );
        });

        // Edit Module Selectors
        $( '#builder' ).on( 'click', '.builder-module-edit', function( event ) {
            event.preventDefault();

            var $this = $(this);
            m.editing = {
                'row_id': $this.parents('.builder-row').attr('id'),
                'col_id': $this.parents('.builder-row-column').attr('id'),
                'module_id': $this.attr('href').slice( $this.attr('href').indexOf('#') + 1 )
            };

            b.spinner.show_reorder();
            m.edit_module();
        });
        
        // Close Module Edit Popup
        /*$( 'body' ).on( 'click', '#builder-module-edit-close', function( event ) {
            event.preventDefault();
            
            // properly destroy the editor on cancel
            $( '.builder-rich-text', b.dialogs.popup_wrapper ).each(function() {
                var $this = $(this)
                    tiny_ed = $this.attr('id');

                r = tinyMCE.remove( tinyMCE.get( tiny_ed ) );
            });
            
            builder.spinner.hide_reorder();
            builder.spinner.hide_column();
            $.modal.close();
            
            m.editing = null;
        });*/

        // Delete Module Selectors
        $( 'body' ).on( 'click', '.builder-module-delete', function( event ) {
            event.preventDefault();

            var $this = $(this);
            m.deleting = {
                'row_id': $this.parents('.builder-row').attr('id'),
                'col_id': $this.parents('.builder-row-column').attr('id'),
                'module_id': $this.attr('href').slice( $this.attr('href').indexOf('#') + 1)
            };

            $( b.dialogs.delete_module ).modal( b.dialogs.small_modal );
        });

        // Delete Module Confirmation Button
        $( '#builder-delete-module-confirm' ).live( 'click', function( event ) {
            event.preventDefault();

            var data = m.deleting;
            b.helpers.show_popup_activity( b.dialogs.delete_module );
            b.helpers.do_ajax( 'delete_module', data, 'do-delete-module' );
        });

        // Delete Module Popup Cancel Button
        $( 'body' ).on( 'click', '#builder-delete-module-popup-close', function( event ) {
            event.preventDefault();

            m.deleting = null;
            $.modal.close();
        });
        
        // Clone Module Selectors
        $( '#builder' ).on( 'click', '.builder-module-clone', function( event ) {
            event.preventDefault();
            
            var $this = $(this),
                data = {
                    'row_id': $this.parents('.builder-row').attr('id'),
                    'col_id': $this.parents('.builder-row-column').attr('id'),
                    'module_id': $this.attr('href').slice( $this.attr('href').indexOf('#') + 1 )
                };
            
            b.spinner.show_reorder();
            b.helpers.do_ajax( 'clone_module', data, 'do-clone-module' );
        });
    },

    bind_triggers: function() {
        var b = builder,
            m = this;

        $( b ).bind( 'edit-module-response', m.edit_module_response );
        $( b ).bind( 'submit-module-response', m.submit_module_response );
        $( b ).bind( 'do-delete-module', m.module_deleted );
        $( b ).bind( 'do-reorder-modules', m.module_reordered );
        $( b ).bind( 'do-module-load-callback', m.load_rich_editor );
        $( b ).bind( 'do-module-save-callback', m.save_rich_editor );
        $( b ).bind( 'do-clone-module', m.module_cloned );
    },

    init_sortables: function() {
        
        var b = builder,
            m = builder.modules,
            defaults = {
                delay: 200,
                dropOnEmpty: true,
                forcePlaceholderSize: true,
                helper: 'clone',
                items: '.builder-module',
                opacity: 0.4,
                placeholder: 'builder-module-draggable-placeholder',
                revert: 300,
                tolerance: 'pointer'
            };
            
        m.moduleSortables = $( '.builder-row-column-data' ).each(function() {
            var $this = $(this);
            
            if ( $this.hasClass('ui-sortable') ) {
                $this.sortable( 'refresh' );
            }
            else {
                $this.sortable( $.extend( defaults, {
                    remove: function() {
                        m.sortables.sender = $(this);
                    },
                    receive: function() {
                        m.sortables.receiver = $(this);
                    },
                    stop: m.reorder_modules,
                    connectWith: '.builder-row-column-data'
                } ) );
            }
        });
        
        m.enable_sortables();
        
    },
    
    reorder_modules: function( event, ui ) {
        var b = builder,
            m = builder.modules,
            data = {};
        
        m.disable_sortables();
        // sorting within list
        if( !m.sortables.sender && !m.sortables.receiver ) {
            data = {
                sender: { },
                receiver: {
                    row_id: ui.item.parents( '.builder-row' ).attr( 'id' ),
                    col_id: ui.item.parents( '.builder-row-column' ).attr( 'id' ),
                    modules: ui.item.parents( '.builder-row-column-data' ).sortable('toArray')
                }
            };
        }
        // sorting with other list
        else {
            data = {
                sender: {
                    row_id: m.sortables.sender.parents( '.builder-row' ).attr( 'id' ),
                    col_id: m.sortables.sender.parents( '.builder-row-column' ).attr( 'id' ),
                    modules: m.sortables.sender.sortable('toArray')
                },
                receiver: {
                    row_id: m.sortables.receiver.parents( '.builder-row' ).attr( 'id' ),
                    col_id: m.sortables.receiver.parents( '.builder-row-column' ).attr( 'id' ),
                    modules: m.sortables.receiver.sortable('toArray')
                }
            };
        }
        
        b.helpers.do_ajax( 'reorder_modules', data, 'do-reorder-modules' );
    },
    
    module_reordered: function( event, result ) {
        var b = builder,
            m = builder.modules;
        
        m.enable_sortables();
        
        if ( !result.success ) {
            b.helpers.do_error( result, function() {
                $( m.sortables.sender ).sortable('cancel');
                $( m.sortables.receiver ).sortable('cancel');
            });
            
            m.sortables.sender = null;
            m.sortables.receiver = null;
            
            return false;
        }
        
        $( m.sortables.sender ).sortable( 'refresh' );
        $( m.sortables.receiver ).sortable( 'refresh' );
                
        m.sortables.sender = null;
        m.sortables.receiver = null;
        b.messenger.set_message( result.message, 'confirm' );
        return true;
    },

    edit_module: function( extra_data, callback ) {
        var b = builder,
            m = builder.modules,
            data = m.editing;

        $.extend( data, extra_data || {} );

        $( b ).trigger( 'edit-module', data );
        b.helpers.do_ajax( 'edit_module', data, callback || 'edit-module-response' );
    },

    edit_module_response: function( event, result ) {
        var b = builder,
            m = builder.modules;

        if ( !result.success ) {
            b.helpers.do_error( result );
            return false;
        }

        // hide popup and its activity
        b.helpers.hide_popup_activity( b.dialogs.module );
        $.modal.close();
        b.messenger.clear_message();

        // show module edit form
        $( b.dialogs.popup_wrapper ).html( $( result.html ) );
        $( b.dialogs.popup_wrapper ).modal( b.dialogs.modal );

        // normal select
        $( '.chosen', b.dialogs.popup_wrapper ).chosen({
            allow_single_deselect: true
        });

        // ajax select
        $( '.chosen-ajax', b.dialogs.popup_wrapper ).each( function( i, obj ) {

            var $this = $(obj);

            $this.ajaxChosen({
                type: 'GET',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    action: 'spyropress_search_taxonomy',
                    type: $this.data('type'),
                    wp_type: $this.data('wp_type')
                }
            }, function (data) {
                var results = [];

                $.each(data, function (i, val) {
                    results.push({ value: val.value, text: val.text });
                });
                return results;
            }, {
                allow_single_deselect: true
            });
        });
        
        // Enable Changer
		var select_changer = $('select', '.enable_changer'),
            widget_id = 'widget-' + $('[name="module_id_base"]', b.dialogs.popup_wrapper ).val() + '-1-';

		select_changer.each(function() {
		     
             var id = $(this).attr('id').replace( widget_id, '' );

            $(this).find('option').each(function() {

                var val = $(this).val();

				if (val) $('.' + id + '.' + val).hide();
			});

		});

		select_changer.change(function() {

            var $this = $(this),
                val = $this.val(),
                id = $this.attr('id').replace( widget_id, '' );

			// hide
			$('.' + id).hide();

			// show
			if (val) $('.' + id + '.' + val).show();

		}).trigger('change');

        panelUi.repeater.repeater_sort();

        $('.toggle_container', '.toggle_set').hide();

        // getFormForModuleLoadCallback
        var $form = $( b.dialogs.popup_wrapper + ' form' );
        $( b ).trigger( 'do-module-load-callback', [$form.attr('id')] );

        return true;
    },

    submit_module: function( $form, extra_data, callback ) {
        var b = builder,
            m = builder.modules;

        b.messenger.clear_message();
        b.helpers.show_popup_activity( $form );

        save_callback_data = {
            form_id: $form.attr('id'),
            is_valid: true
        };

        $( b ).trigger( 'do-module-save-callback', [save_callback_data] );

        if ( false === save_callback_data.is_valid ) {
            b.helpers.hide_popup_activity( b.dialogs.popup_wrapper );
            return false;
        }

        var data = {
            'form_data': $form.formParams(),
            'row_id': m.editing.row_id,
            'col_id': m.editing.col_id,
            'module_id': m.editing.module_id
        };

        $.extend( data, extra_data || {} );

        b.helpers.do_ajax( 'save_module', data, callback || 'submit-module-response' );
        return true;
    },

    submit_module_response: function( event, module ) {
        var b = builder,
            m = builder.modules;


        if ( !module.success ) {
            b.helpers.do_error( module );
            return false;
        }

        // insert module html into respective column
        m.add_module(module);
        
        b.messenger.set_message( module.message, 'confirm' );
        b.spinner.hide_reorder();
        m.editing = null;
        b.helpers.hide_popup_activity( b.dialogs.popup_wrapper );
        $.modal.close();
        
        return true;
    },

    add_module: function( module ) {
        var module_id = module.module_id,
            col_id = module.col_id;

        $target = $( '#' + col_id + ' .builder-row-column-data' );
        $module = $( '#' + module_id, $target );

        if ( module_id === null || $module.size() < 1) {
            $target.append( module.html );
        }
        else {
            $module.replaceWith( module.html );
        }

        $target.trigger( 'add-module', [module_id] );

        return true;
    },

    module_deleted: function( event, module ) {
        var b = builder;

        if ( !module.success ) {
            b.helpers.do_error( module );
            return false;
        }

        $( '#' + module.module_id ).slideUp(function() {
            var $this = $(this)
                $column = $this.closest('.builder-row-column');

            $this.remove();
            $column.trigger( 'do-module-removed', [module.module_id] );

            b.helpers.hide_popup_activity( b.dialogs.delete_module );
            $.modal.close();
        });

        b.modules.deleting = null;
        builder.messenger.set_message( module.message, 'confirm' );
        return true;
    },
    
    enable_sortables: function() {
        var b = builder,
            m = builder.modules;
        
        m.moduleSortables.sortable( 'enable' );
        b.spinner.hide_reorder();
    },
    
    disable_sortables: function() {
        var b = builder,
            m = builder.modules;
        
        m.moduleSortables.sortable( 'disable' );
        b.spinner.show_reorder();
    },
    
    module_cloned: function( event, module ) {
        var b = builder,
            m = builder.modules;
        
        if ( !module.success ) {
            b.helpers.do_error( module );
            return false;
        }
        
        // insert module html into respective column
        m.add_module( module );
        b.messenger.set_message( module.message, 'confirm' );
        b.spinner.hide_reorder();
        
        return true;
    },

    load_rich_editor: function( event, form_id ) {

        target_id = $( '.builder-rich-text', '#' + form_id ).attr('id');
        
        tiny_ed = tinyMCE.get( target_id );
        if( tiny_ed ) {
            tinyMCE.remove( tiny_ed );
        }
        
        window.tinyMCEPreInit.mceInit[target_id] = _.extend({}, tinyMCEPreInit.mceInit['content']);

        if(_.isUndefined(tinyMCEPreInit.qtInit[target_id])) {
            window.tinyMCEPreInit.qtInit[target_id] = _.extend({}, tinyMCEPreInit.qtInit['replycontent'], {id: target_id})
        }
        
        qt = quicktags( window.tinyMCEPreInit.qtInit[target_id] );
        //QTags._buttonsInit();
        window.switchEditors.go(target_id, 'tmce');
        
        if ( tinymce.majorVersion === "4" ) {
            tinymce.execCommand( 'mceAddEditor', true, target_id );
        };
    },

    save_rich_editor: function( event, data ) {
        
        var target_id = $( '.builder-rich-text', '#' + data.form_id ).attr('id');
        if( target_id ) {
            var tiny_ed = tinyMCE.get( target_id );
            tiny_ed.save();
            tinyMCE.remove( tiny_ed );
        }
    },
    
    destroy_rich_editor: function() {
        
        // properly destroy the editor on cancel
        $( '.builder-rich-text', builder.dialogs.popup_wrapper ).each(function() {
            var $this = $(this)
                tiny_ed = $this.attr('id');
            
            r = tinyMCE.remove( tinyMCE.get( tiny_ed ) );
        });

        builder.modules.editing = null;
    }

}; // modules_end

/**
 * Helpers
 */
builder.helpers = {

    show_popup_activity: function( popup ) {
        $( '.builder-popup-activity', popup ).show();
    },

    hide_popup_activity: function( popup ) {
        $( '.builder-popup-activity', popup ).hide();
    },

    hasRows: function() {
        return $( '.builder-row', '#builder-sortables-container' ).size() > 0;
    },

    hasColumns: function( row_id ) {
        return $( '.builder-row-column', '#' + row_id ).not( '.row-empty' ).size() > 0;
    },

    toggle_error_string: function() {
        $( '.builder-ajax-error-string' ).slideToggle();
    },

    do_ajax: function( func, data, successTrigger, beforeTrigger, successCallback ) {
        var b = builder,
            h = this;
        data.post_id = $( '#post_ID' ).val();

        opts = {
            url: ajaxurl,
            type: 'POST',
            async: true,
            cache: false,
            dataType: 'json',
            data: {
                action: 'builder_do_action',
                func: func,
                args: data
            },
            beforeSend: function( request ) {
                $( b ).trigger( beforeTrigger || 'ajaxDoBefore', request );
                return;
            },
            success: function( response ) {
                $( b ).trigger( successTrigger || 'ajaxSuccess', response );

                if ( typeof successCallback == 'function' ) {
                    successCallback.call( this, response );
                }
                return;
            },
            error: function( xhr, textStatus, e ) {
                switch( textStatus ) {
                    case 'parsererror':
                        var error = $( '<pre />' ).html( xhr.responseText ),
                            html = '<p><b>Parse Error in data returned from server</b>' +
                                    ' <a href="#" onclick="builder.helpers.toggle_error_string(); return false">toggle</a></p>' +
                                    '<pre class="builder-ajax-error-string" style="display: none;">' + error.html() + '</pre>';

                        h.do_error({
                            html: html,
                            message: 'parsererror'
                        });
                        break;
                    default:
                        h.do_error({
                            html:'<b>Invalid response from server during Ajax Request</b>',
                            message:'invalidajax'
                        });
                }
                return;
            }
        };

        $.ajax( opts );
    },

    do_error: function( result, callback ) {
        var b = builder;

        $.modal.close();

        $( '#builder-error-message', b.dialogs.error ).html( result.html );
        $( b.dialogs.error ).modal( b.dialogs.modal );

        $( '#builder-error-message', b.dialogs.error ).click( function( event ) {
            event.preventDefault();

            if (callback) {
                callback.apply();
            }
        });
        return true;
    },

    // init post handler - trigger autosave and continue when post_ID has been updated
    init_auto_save: function( callback, data ) {
        var h = this;

        $( '#title' ).val( $( '#builder-autosave-title' ).val() ).blur();
        setTimeout( function() {
            h.continue_auto_save( callback, data );
        }, 500 );
    },

    continue_auto_save: function( callback, data ) {
        var b = builder,
            h = this;

        if ( $('#post_ID').val() < 0 ) {
            setTimeout( function() {
                h.continue_auto_save( callback, data );
            }, 500);
        }
        else {
            b[callback](data);
        }
        return;
    }

}; // helpers_end

/**
 * Welcome Screen
 */
builder.welcome = {

    show: function() {
        var b = builder,
            $row_loader = $('#rows-loader');

        if ( ! b.helpers.hasRows() ) {

            var $welcome = $('#welcome-container'),
                $teaser = $('#welcome-teaser'),
                $teaser_rows = $('#teaser-rows');

            b.opts.welcome_removed = false;
            $row_loader.hide();
            $teaser.show();
            $teaser_rows.show();
            $welcome.show();

            // choose build
            $( '#start-building' ).unbind().click( function( event ) {
                event.preventDefault();

                $('body').trigger('click');
                $teaser.hide();
                $teaser_rows.slideUp( 'normal', function() {
                    b.rows.toggle_row_drawer();
                });
            });
        }
        else {
            if ( $('#builder-sortables-container .builder-row' ).size() == 1 )
                $('#builder-sortables-container .builder-row').addClass('active');
        }
        return true;
    },

    hide: function() {
        $( '#welcome-container' ).slideUp( 'fast' );
        builder.opts.welcome_removed = true;
    }
}; // welcome_end

builder.messenger = {

    opts: {
        wrapper: '#builder-messages',
        timeout: '3000',
        timeout_id: ''
    },

    set_message: function( message, type ) {
        var m = this;

        clearTimeout( m.timeout_id );

        $( m.opts.wrapper )
            .addClass('message-'+ (type || 'info') )
            .html('<span class="message-content">' + message + '</span>');
            m.set_expire( m.opts.timeout );
    },

    clear_message: function() {
        var m = this,
            $wrapper = $( m.opts.wrapper );

        $wrapper.children( 'span.message-content' ).fadeOut( 'fast', function() {
            $wrapper.attr( 'class', '' ).html('');
        });
    },

    set_expire: function( timeout ) {
        var m = this;
        m.opts.timeout_id = setTimeout(m.clear_message, timeout || m.opts.timeout);
    }

}; // messenger_end

builder.spinner = {

    show_column: function( row_id ) {
        $( '#'+row_id ).find('.row-toolbar').append('<div id="columns-loader"></div>').show();
    },

    hide_column: function() {
        $('#columns-loader').remove();
    },

    hide_reorder: function() {
        $('#builder-sortables-container .builder-reorder-status').remove();
    },

    show_reorder: function() {
        var s = this;

        $('#builder-sortables-container').append(
            $('<div class="builder-reorder-status">').append('<div class="builder-reorder-overlay" />', s.spinner() )
        );
    },

    spinner: function(message) {
        message = message || 'Loading&hellip;';
        return '<div id="builder-spinner-dialog" class="builder-popup"><div class="builder-popup-spinner">' + message + '</div></div>';
    }
}; // spinner_end

})(jQuery);