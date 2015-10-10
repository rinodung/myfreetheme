(function() {

    tinymce.create( 'tinymce.plugins.spyropressShortcodes', {

        init: function ( ed, url )
		{
			ed.addCommand( 'spyropressPopup', function ( a, params ) {

				// load thickbox
                tb_show( params.title + ' Shortcode Generator', spyropress_admin_settings['shortcode_url'] + "popup.php?popup=" + params.identifier + "&width=" + 800 );
			});
		},

        addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, sc )
				}
			})
		},

        addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( 'spyropressPopup', false, {
						title: title,
						identifier: id
					})
				}
			})
		},

        createControl: function ( btn, e ) {
			if ( btn == 'spyropress_shortcodes' )
			{
				var a = this;

				var btn = e.createSplitButton('spyropress_shortcodes', {
                    title: "Insert Shortcode",
					image: spyropress_admin_settings['media_url'] + 'shortcode_icon.png',
					icons: false
                });

                btn.onRenderMenu.add(function (c, b) {

					c = b.addMenu({
                        title: 'Buttons'
                    });
                        a.addWithPopup(c, "Button", "button");
                        a.addWithPopup(c, "Link Button", "button_link");
                    c = b.addMenu({
                        title: "Typography"
                    });
                        a.addWithPopup( c, "Alternative Font", "typo_alt_font" );
                        a.addWithPopup( c, "Blockquote", "typo_blockquote" );
                        a.addImmediate( c, "Dropcap 1", "[dropcap]Pellentesque pellentesque eget tempor tellus. Fusce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus.[/dropcap]" );
                        a.addImmediate( c, "Dropcap 2", "[dropcap style=s2]Pellentesque pellentesque eget tempor tellus. Fusce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus.[/dropcap]" );
                        a.addWithPopup( c, "Inverted Text", "typo_inverted" );
                        a.addWithPopup( c, "Labels","typo_labels" );
                        a.addImmediate( c, "Lead Text", "[lead]content goes here[/lead]" );
                        a.addImmediate( c, "Rotate Words", "[rotate_words]text1;text2;text3[/rotate_words]" );
                    c = b.addMenu({
                        title: "Image"
                    });
                        a.addWithPopup( c, "Promo Image", "promo_image" );
                        a.addWithPopup( c, "Image", "img");

                    c = b.addMenu({
                        title: "List"
                    });
                        a.addWithPopup( c, "Icon List", "icon_list");
                        a.addImmediate( c, "Inline List", "[inline_list]<ul><li>content goes here.</li><li>content goes here.</li><li>content goes here.</li></ul>[/inline_list]");
                        a.addImmediate( c, "Unstyled List", "[unstyled_list]<ul><li>content goes here.</li><li>content goes here.</li><li>content goes here.</li></ul>[/unstyled_list]");

                    b.addSeparator();
                    a.addWithPopup( b, "Alerts", "alerts" );
                    a.addWithPopup( b, "Icon", "icon");
                    a.addWithPopup( b, "Lightbox", "lightbox" );
                    a.addWithPopup( b, "Progress Bar", "progress_bar");
                    a.addWithPopup( b, "Tables", "tables");
                    a.addWithPopup( b, "Tooltip", "tooltip");
				});

                return btn;
			}

			return null;
		},

        getInfo: function () {
			return {
				longname: 'Spyropress Shortcodes',
				author: 'Spyropress',
				authorurl: 'http://themeforest.net/user/spyropress/',
				infourl: 'http://wiki.moxiecode.com/',
				version: '1.0'
			}
		}
    });

    tinymce.PluginManager.add( 'spyropressShortcodes', tinymce.plugins.spyropressShortcodes );

})();