( function() {
	// TinyMCE plugin start.
    tinymce.PluginManager.add( 'spyropressShortcodes', function( editor, url ) {

        // Register a command to open the dialog.
		editor.addCommand( 'spyropress_open_dialog', function( ui, params ) {

			tb_show( params.title + ' Shortcode Generator', spyropress_admin_settings['shortcode_url'] + "popup.php?popup=" + params.id + "&width=" + 800 );
            jQuery( "#TB_window").css( { zIndex: 999999 });
		});

        // Register a command to insert the shortcode immediately.
		editor.addCommand( 'spyropress_insert_immediate', function( ui, params ) {
			var selected = editor.selection.getContent({format: 'text'}),
                attrs = '';

			// If we have selected text, close the shortcode.
			if ( '' === selected ) {
				if( typeof params.content === 'undefined' ) {
				    selected = 'Your content goes here';
				}
                else {
                    selected = params.content;
                }
			}

            if( '' !== params.attrs ) {
                for (var key in params.attrs) {
                    attrs += ' ' + key + '="' + params.attrs[key] + '"';
                }
            }

			editor.insertContent( '[' + params.id + attrs + ']' + selected + '[/' + params.id + ']' );
		});

        // Add a button that opens a window
        editor.addButton( 'spyropress_shortcodes', {
			type: 'menubutton',
			text: false,
			icon: 'spyropress-shortcode-icon',
			tooltip: 'Insert a Spyropress Shortcode',
			menu: [
                //{ text: '', onclick: function() { editor.execCommand( '', false, { id: '', title: '', } ); } },
                {
                    text: 'Buttons',
                    menu:[
                        { text: 'Button', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'button', title: 'Button' } ); } },
                        { text: 'Link Button', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'button_link', title: 'Link Button', } ); } },
                    ]

                },
                {
                    text: 'Typography',
                    menu:[
                        { text: 'Alternative Font', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'typo_alt_font', title: 'Alternative Font', } ); } },
                        { text: 'Blockquote', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'typo_blockquote', title: 'Blockquote', } ); } },
                        { text: 'Dropcap 1', onclick: function() { editor.execCommand( 'spyropress_insert_immediate', false, { id: 'dropcap', title: 'Dropcap 1', } ); } },
                        { text: 'Dropcap 2', onclick: function() { editor.execCommand( 'spyropress_insert_immediate', false, { id: 'dropcap', title: 'Dropcap 2', attrs: { style: 's2' } } ); } },
                        { text: 'Inverted Text', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'typo_inverted', title: 'Inverted Text', } ); } },
                        { text: 'Labels', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'typo_labels', title: 'Labels', } ); } },
                        { text: 'Lead Text', onclick: function() { editor.execCommand( 'spyropress_insert_immediate', false, { id: 'lead', title: 'Lead Text', } ); } },
                        { text: 'Rotate Words', onclick: function() { editor.execCommand( 'spyropress_insert_immediate', false, { id: 'rotate_words', title: 'Rotate Words', content: 'text1;text2;text3' } ); } },

                    ]
                },
                {
                    text: 'Image',
                    menu: [
                        { text: 'Promo Image', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'promo_image', title: 'Promo Image', } ); } },
                        { text: 'Image', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'img', title: 'Image', } ); } }
                    ]
                },
                {
                    text: 'List',
                    menu: [
                        { text: 'Icon List', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'icon_list', title: 'Icon List', } ); } },
                        { text: 'Inline List', onclick: function() { editor.execCommand( 'spyropress_insert_immediate', false, { id: 'inline_list', title: 'Inline List', content: '<ul><li>content goes here.</li><li>content goes here.</li><li>content goes here.</li></ul>' } ); } },
                        { text: 'Unstyled List', onclick: function() { editor.execCommand( 'spyropress_insert_immediate', false, { id: 'unstyled_list', title: 'Unstyled List', content: '<ul><li>content goes here.</li><li>content goes here.</li><li>content goes here.</li></ul>' } ); } },
                    ]
                },
                { text: 'Alerts', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'alerts', title: 'Alerts', } ); } },
                { text: 'Icon', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'icon', title: 'Icon', } ); } },
                { text: 'Lightbox', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'lightbox', title: 'Lightbox', } ); } },
                { text: 'Progress Bar', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'progress_bar', title: 'Progress Bar', } ); } },
                { text: 'Tables', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'tables', title: 'Tables', } ); } },
                { text: 'Tooltip', onclick: function() { editor.execCommand( 'spyropress_open_dialog', false, { id: 'tooltip', title: 'Tooltip', } ); } }
            ]
        });
    });
})();