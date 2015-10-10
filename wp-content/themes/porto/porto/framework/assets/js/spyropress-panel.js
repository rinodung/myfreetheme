/* New UI Class */
;(function($) {

	$.fn.outerHTML = function() {
		return $('<div>').append(this.eq(0).clone()).html();
	};

	panelUi = {

		id: '#spyropress-panel',
		messages: {
			agreeReset: 'Are you sure you want to reset back to the defaults?',
			agreeRemove: 'Are you sure you want to remove this?',
			agreeImport: 'Are you sure you want to restore the settings?',
            agreeDummy: 'Are you sure you want to install the dummy data?'
		},
		resources: {
			buttonRemoveMedia: 'Remove Media'
		},

		fontList: false,
		sliders: {},

		// Start the Engine!
		init: function() {

			// Panel Functions
			this.init_select_wrapper();
			this.init_tabs();
			this.init_datepicker();
			this.init_radio_image();
            this.init_toggle_checkboxes();
			this.init_upload();
			this.init_upload_remove();
			this.init_google_fonts();
			this.init_toggles();
			this.init_section_reset();

			// Ajax Events
			this.ajax_widget_fix();
			this.save_settings();
			this.reset_settings();
			this.import_settings();
            this.skin_generator();

			// Repeater
			this.repeater.init();

			// Gallery Uploader
			this.gallery.init();
		},

		// Select to Chosen
		init_select_wrapper: function() {

			// if widget page
			if ( typeof pagenow !== 'undefined' && 'widgets' == pagenow) {

				// normal select
				$('.chosen', '#widgets-right').chosen({
					allow_single_deselect: true
				});

				// ajax select
				$('.chosen-ajax', '#widgets-right').each(function(i, obj) {

                    var $this = $(obj),
						type = $this.data('type'),
						wp_type = $this.data('wp_type');

					$this.ajaxChosen({
						type: 'GET',
						url: ajaxurl,
						dataType: 'json',
						data: {
							action: 'spyropress_search_taxonomy',
							type: type,
							wp_type: wp_type
						}
					}, function(data) {

                        var results = [];

						$.each(data, function(i, val) {
							results.push({
								value: val.value,
								text: val.text
							});
						});

						return results;

					}, {
						allow_single_deselect: true
					});
				});
			}
			// if other than widget page
			else {

				// normal select
				$('.chosen').chosen({
					allow_single_deselect: true
				});

				// ajax select
				$('.chosen-ajax').each(function(i, obj) {

                    var $this = $(obj),
						type = $this.data('type'),
						wp_type = $this.data('wp_type');

					$this.ajaxChosen({
						type: 'GET',
						url: ajaxurl,
						dataType: 'json',
						data: {
							action: 'spyropress_search_taxonomy',
							type: type,
							wp_type: wp_type
						}
					}, function(data) {

                        var results = [];

						$.each(data, function(i, val) {
							results.push({
								value: val.value,
								text: val.text
							});
						});

						return results;

					}, {
						allow_single_deselect: true
					});
				});
			}

			// Enable Changer
			var select_changer = $( '.enable_changer select, .enable_changer input:radio, #page_template, #post-formats-select .post-format');

			select_changer.each(function() {
                
                var $this = $(this),
                    id = $this.is(':radio') ? $this.attr('name') : $this.attr('id');

                $( '.' + id ).hide();
			});

			select_changer.change(function() {

                var $this = $(this),
                    id = $this.is(':radio') ? $this.attr('name') : $this.attr('id'),
                    val = $this.val();

				if( $this.is(':radio') ) {
				    val = $('input[name=' + id + ']:radio:checked').val();
				}
                
                val = val.replace( '.', '-' );
                
                // hide
				$('.' + id).hide();

				// show
				if (val) $('.' + id + '.' + val).show();

			}).trigger('change');
		},

		init_tabs: function() {

			// Option Panel Main Tabs
			$('.panel-nav').idTabs(function(id, list, set) {

                var $this = $('a', set),
					span = $('span', $this);

                $this.removeClass('selected');
				span.removeClass('module-icon-white');
				$this.filter('a[href="' + id + '"]').addClass('selected').find('span').addClass('module-icon-white');
				for (i in list) $(list[i]).hide();
				$(id).fadeIn();

                return false;

			});

			// Meta Box Tabs
			$('.panel-tabs').idTabs(function(id, list, set) {

                $('li', set).removeClass('open');
				$('a', set).filter('a[href="' + id + '"]', set).parent().addClass('open');
				for (i in list) $(list[i]).hide();
				$(id).fadeIn();

                return false;

			});
		},

		init_datepicker: function() {

            $('.field', '.section-datepicker').datepicker();
		},

		init_radio_image: function() {

            $('.radio-img', '.section-radio-img').live('click', function() {

                var $this = $(this);

				$this.parents('.section-radio-img').find('.radio-img').removeClass('selected');
				$this.addClass('selected');
			});
		},
        
        init_toggle_checkboxes: function() {
            
            $('label.checkbox', '.section-radiolist').click(function(){
                var $this = $(this),
                    $parent = $this.parent();
                
                $parent.find('.checkbox').removeClass('selected');
                $this.addClass('selected');
            });
        },

		// http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
		// https://github.com/thomasgriffin/New-Media-Image-Uploader
        // http://stackoverflow.com/questions/13847714/wordpress-3-5-custom-media-upload-for-your-theme-options
		init_upload: function() {

			$('body').on( 'click', '.upload_button', function( e ) {
				e.preventDefault();

				var $this = $(this),
                    $field = $this.prev('input'),
                    field_id = $field.attr('id'),
                    clone = wp.media.editor.send.attachment;

				wp.media.editor.send.attachment = function(props, attachment) {


					if( 'video' != attachment.type ) {
                        var img = ( 'x-icon' == attachment.subtype) ? attachment.url : attachment.sizes[props.size].url;

    					btnContent = '';
    					btnContent += '<div class="image-wrap"><img src="' + img + '" alt="" /></div>';
    					btnContent += '<a href="javascript:(void);" class="remove-media">' + panelUi.resources.buttonRemoveMedia + '</span></a>';


                        $field.val(img);
    					$field.parent('div').append('<div style="display:none" class="screenshot" id="' + field_id + '_image" />');

                        $fieldImg = $('#' + field_id + '_image');
    					$fieldImg.append(btnContent).fadeIn('slow');

    					// restore original
    					wp.media.editor.send.attachment = clone;
                    }
                    else if( 'video' == attachment.type ) {
                        $field.val( attachment.url );
                    }
				};

				wp.media.editor.open($this);
			});
		},

		init_upload_remove: function() {

			$('.remove-media').live('click', function(event) {

				event.preventDefault();

				var agree = confirm(panelUi.messages.agreeRemove);
				if (agree) {

                    var $this = $(this);

					$this.parent().parent().find('.upload').attr('value', '');
					$this.parent('.screenshot').slideUp('', function() {
						$(this).remove();
					});

					return false;
				}

				return false;
			});
		},
        
        // Gallery
		gallery: {
			
            init: function() {
                // http://stackoverflow.com/questions/13847714/wordpress-3-5-custom-media-upload-for-your-theme-options
                var g = this;
                
                // action-add
                $(document.body).on( 'click', '.gallery_upload_button', function(event) {
                    event.preventDefault();
    
                    var $this = $(this),
                        $parent = $this.parent(),
                        $field = $parent.find('.gallery_shortcode'),
                        $gallery = $parent.find('.gallery_holder'),
                        ids = $field.val(),
                        shortcode = ( !ids ) ? '[gallery ids="0"]' : '[gallery ids="' + ids + '"]';
                    
                    g._frame_gallery = wp.media.gallery.edit( shortcode );
                    
                    // When the gallery-edit state is updated, copy the attachment ids across
                    g._frame_gallery.state( 'gallery-edit' ).on( 'update', function( selection ) {
    
                        //clear screenshot div so we can append new selected images
                        $gallery.html( '' );
                        
                        var attachment, preview_html = '', preview_img;
                        var new_ids = selection.models.map( function( e ) {
                            attachment = e.toJSON();
                            preview_img = _.isUndefined( attachment.sizes.thumbnail ) ? attachment.url : attachment.sizes.thumbnail.url;
                            preview_html = '<div data-id="' + attachment.id + '" class="gallery-item">' + '<img src="' + preview_img + '" /></div>';
                            $gallery.append( preview_html );
                            
                            return e.id;
                        });
                        
                        $field.val( new_ids.join( ',' ) );
                            
                    });
                    
                });
                
                // Clear Gallery
                $('body').on( 'click', '.gallery_reset_button', function( e ) {
    				e.preventDefault();
    
    				var $this = $(this),
                        $section = $this.parent(),
                        $gallery = $section.find('.gallery_holder'),
                        $shortcode = $section.find('.gallery_shortcode');
                    
                    $gallery.html('');
                    $shortcode.val('');
                });
			}
		},

		init_google_fonts: function() {

            $.getJSON(
                ajaxurl,
                {
                    'action' : 'get_google_webfonts'
                },
                function(response) {
                    if ( response != -1 )
                        panelUi.fontList = response;
				}
            );
		},

		init_toggles: function() {

			$('.toggle_container', '.toggle_set').not('.active').addClass('inactive');
			$('.toggle_trigger', '.toggle_set').live('click', function() {

                var $this = $(this),
                    $span = $this.find('span.toggle_icon'),
                    $next = $this.next();

				if ($next.hasClass('active')) {
					$next.removeClass('active');
					$next.fadeOut();
					$span.html('[+]');
				} else {
					$next.addClass('active');
					$next.fadeIn();
					$span.html('[-]');
				}
			});
		},

		init_section_reset: function() {

			$('.section-reset').live('click', function() {

                var $this = $(this).parents('.section');

				$this.find('input:text, input:password, input:file, textarea').val('');
				$this.find('select').val('').trigger('chosen:updated');
				$this.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
				$this.find('.radio-img.selected').removeClass('selected');

				return false;
			});
		},

		// Ajax Events
		ajax_widget_fix: function() {

            var b = this;

            // if its widget page
			if ( typeof pagenow !== 'undefined' && 'widgets' == pagenow) {
                $('div.widgets-sortables').on( 'sortupdate', function(event, ui) {
                    setTimeout( function() {
                        b.select_widget_fix( ui.item );
                        b.range_slider_widget_fix( ui.item );
                    }, 300 );
				});

				$(document).ajaxComplete(function( event, xhr, settings ) {
                    var str = decodeURI( settings.data );

                    if( str.contains( 'action=save-widget' ) )
					   b.select_widget_fix();
				});
			}
		},

		save_settings: function() {

            $('.save-options', panelUi.id).live('click', function(event) {

                var d = {
					action: 'spyropress_update_options'
				};

				if (typeof tinyMCE !== 'undefined' && tinyMCE) {
					tinyMCE.triggerSave();
				}
				b = $(':input', panelUi.id).serialize();
				d = b + '&' + $.param(d);
				$.post(ajaxurl, d, function(r) {
					if (r != -1) {
						$('.ajax-message').ajaxMessage('<div class="message"><span>&nbsp;</span>Options Saved Successfully.</div>');
					} else {
						$('.ajax-message').ajaxMessage('<div class="message warning"><span>&nbsp;</span>Options could not saved.</div>');
					}
				});
				event.preventDefault();
			});

		},

		reset_settings: function() {
			$('.reset-options', panelUi.id).live('click', function(event) {
				var agree = confirm(panelUi.messages.agreeReset);
				if (agree) {
					// ajax reset request goes from here
					var d = {
						action: 'spyropress_reset_options',
						security: $('#security', panelUi.id).val(),
						setting_panel_name: $('#setting_panel_name', panelUi.id).val()
					};
					$.post(ajaxurl, d, function(r) {
						if (r != -1) {
							$('.screenshot').hide();
							$(':input', panelUi.id).not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
							$('.ajax-message').ajaxMessage('<div class="message"><span>&nbsp;</span>Options Reset Successfully.</div>').delay(3000, function() {
								eval(r);
							});
						} else {
							$('.ajax-message').ajaxMessage('<div class="message warning"><span>&nbsp;</span>Options could not reset.</div>');
						}
					});
					return false;
				} else {
					return false;
				}
				event.preventDefault();
			});
		},

		import_settings: function() {
			$('.import-options', panelUi.id).live('click', function(event) {

                var agree = confirm(panelUi.messages.agreeImport);
                if (agree) {
					// ajax reset request goes from here
					var d = {
						action: 'spyropress_import_options',
						security: $('#security', panelUi.id).val(),
						setting_panel_name: $('#setting_panel_name', panelUi.id).val(),
						settings: $('#import_options', panelUi.id).val(),
					};
					$.post(ajaxurl, d, function(r) {
						if (r != -1) {
							$('.screenshot').hide();
							$(':input', panelUi.id).not(':button, :submit, :reset, :hidden, #active_theme_layout').val('').removeAttr('checked').removeAttr('selected');
							$('.ajax-message').ajaxMessage('<div class="message"><span>&nbsp;</span>Options Restored Successfully.</div>').delay(3000, function() {
								eval(r);
							});
						}
                        else {
							$('.ajax-message').ajaxMessage('<div class="message warning"><span>&nbsp;</span>Options could not restored.</div>');
						}
					});

					return false;

				}
                else {

					return false;
				}
				event.preventDefault();
			});
		},

        skin_generator: function() {
            $( '.button-skin-generator', panelUi.id ).on('click', function(event) {

                event.preventDefault();

				// ajax reset request goes from here
				var d = {
					action: 'spyropress_skin_generator',
					skin_generator_nonce: $( '#skin_generator_nonce', panelUi.id ).val(),
					skin_name: $('#skin_name', panelUi.id ).val(),
					skin_color: $('#skin_color', panelUi.id ).val(),
                    skin_gradient: $('#skin_gradient-0', panelUi.id ).is(':checked')
				};
				$.post(ajaxurl, d, function(r) {
					if (r != -1) {

						$('.ajax-message').ajaxMessage('<div class="message"><span>&nbsp;</span>Skin Generated Successfully.</div>').delay(3000, function() {
							eval(r);
						});
					}
                    else {
						$('.ajax-message').ajaxMessage('<div class="message warning"><span>&nbsp;</span>Skin could not generated.</div>');
					}
				});

				return false;
			});
            
            $( '.skin-remove-item', panelUi.id ).on('click', function(event) {

                event.preventDefault();

				// ajax reset request goes from here
				var d = {
					action: 'spyropress_skin_remove',
					skin_generator_nonce: $( '#skin_generator_nonce', panelUi.id ).val(),
					skin_name: $(this).data('name')
				};
				$.post(ajaxurl, d, function(r) {
					if (r != -1) {

						$('.ajax-message').ajaxMessage('<div class="message"><span>&nbsp;</span>Skin Deleted Successfully.</div>').delay(3000, function() {
							eval(r);
						});
					}
                    else {
						$('.ajax-message').ajaxMessage('<div class="message warning"><span>&nbsp;</span>Skin could not deleted.</div>');
					}
				});

				return false;
			});
        },

		// Repeater
        repeater: {

            // Start Engine
            init: function() {

                this.repeater_add();
                this.repeater_group_actions();
                this.repeater_sort();
            },

            repeater_sort: function() {

                var r = this;

                // Add Inactive Class
                $( '.repeater-group', '.section-repeater').not('.tocopy').addClass('inactive');

                // Sorting
                $('.section-repeater > .controls').sortable({
                    cancel: '.repeater-group.tocopy',
                    delay: 200,
                    distance: 5,
                    dropOnEmpty:true,
                    forceHelperSizeType: true,
                    forcePlaceholderSize:true,
                    handle: '.repeater-group-header',
                    helper: 'clone',
                    items:'.repeater-group:not(.tocopy)',
                    opacity:0.4,
                    placeholder:'sortable-placeholder',
                    revert: 300,
                    tolerance: 'pointer',
                    update: r.update_ids
				});
            },

            // Update IDS
            update_ids: function( event, ui ) {
                var $groups = ui.item.parent().find( ' > .repeater-group' ),
                    newCounter = 0;

                $groups.each(function( index, value ){
                    var $this = $(this),
                        $parent = $this.closest('.section-repeater'),
                        parent_name = $parent.find(' > .control_id').val();

                    $this.find('.section').each(function( index, value ) {
                        var $section = $(this);

                        // change control_id too
                        $section.find(' > .control_id').each(function( index, value ) {
                            var $elem = $(this),
                                old_name = $elem.val(),
                                new_name = old_name.replace(parent_name, '');

                            // val
                            new_name = new_name.substring( new_name.indexOf(']')+1 );
                            new_name = parent_name + '[' + newCounter + ']' + new_name;
                            $elem.val(new_name);
                        });

                        // field and select
                        $section.find('.field, select').each(function( index, value ) {

                            var $elem = $(this),
                                old_name = $elem.attr('name'),
                                new_name = old_name.replace(parent_name, ''),
                                old_id = $elem.attr('id'),
                                new_id = '';

                            // name
                            new_name = new_name.substring( new_name.indexOf(']')+1 );
                            new_name = parent_name + '[' + newCounter + ']' + new_name;
                            $elem.attr('name', new_name);

                            // id
                            new_id = old_id.substr(0, old_id.lastIndexOf('-')+1 ) + newCounter;
                            $elem.attr('id', new_id);

                        }); // End Each Element

                        // for checkbox
                        if( $section.hasClass( 'section-checkbox' ) ) {

                            $section.find( 'label.checkbox' ).each(function(){
                                var $label = $(this),
                                    $elem = $label.children(':first'),
                                    old_name = $elem.attr('name'),
                                    new_name = old_name.replace(parent_name, ''),
                                    old_id = $elem.attr('id'),
                                    new_id = '';

                                // name
                                new_name = new_name.substring( new_name.indexOf(']')+1 );
                                new_name = parent_name + '[' + newCounter + ']' + new_name;
                                $elem.attr('name', new_name);

                                // id
                                new_id = old_id.substr(0, old_id.indexOf( '-', parent_name.length+1)+1 ) + newCounter;
                                new_id = new_id + old_id.substr( new_id.length );
                                $elem.attr('id', new_id);

                                $label.attr( 'for', new_id );
                            });
                        }

                    }); // End Each Section

                    newCounter++;
                });
            },

            // Add Repeating Element
            repeater_add: function() {

                // Binding
                $('body').on( 'click', '.repeater-add', function( e ) {
                    e.preventDefault();

                    var $this = $(this),
                        $parent = $this.closest('.section-repeater'),
                        $current = $this.prev('.tocopy'),
                        $copy = $current.clone(),
                        parent_name = $parent.find(' > .control_id').val(),
                        newCounter = $parent.find(' > .controls > .repeater-group').length;

                    // Remove copy class
                    $current.slideDown().removeClass('tocopy').addClass('active');

                    // adjusting ids @ clone
                    $this.before($copy);
                    $copy.find('.section').each(function( index, value ) {
                        var $section = $(this);

                        $section.find('.field, select').each(function( index, value ) {
                            var $elem = $(this),
                                old_name = $elem.attr('name'),
                                new_name = old_name.replace(parent_name, ''),
                                old_id = $elem.attr('id'),
                                new_id = '';

                            // name
                            new_name = new_name.substring( new_name.indexOf(']')+1 );
                            new_name = parent_name + '[' + newCounter + ']' + new_name;
                            $elem.attr('name', new_name);

                            // id
                            new_id = old_id.substr(0, old_id.lastIndexOf('-')+1 ) + newCounter;
                            $elem.attr('id', new_id);

                            // recreate chosen
                            if( $elem.hasClass('chosen') ) {
                                // destory chosen
                                $elem.next('.chosen-container').remove();

                                //recreate
                                $elem.chosen({
                                    allow_single_deselect: true
                                });
                            }

                            // recreate ajax chosen
                            if( $elem.hasClass('chosen-ajax') ) {
                                // destory chosen
                                $elem.next('.chosen-container').remove();

                                //recreate
                                $elem.ajaxChosen({
                                    type: 'GET',
                                    url: ajaxurl,
                                    dataType: 'json',
                                    data: {
                                        action: 'spyropress_search_taxonomy',
                                        type: $elem.data('type'),
                                        wp_type: $elem.data('wp_type')
                                    }
                                }, function(data) {
                                    var results = [];
                                    $.each(data, function(i, val) {
                                        results.push({
                                            value: val.value,
                                            text: val.text
                                        });
                                    });

                                    return results;
                                }, {
                                    allow_single_deselect: true
                                });
                            }

                        }); // End Each Element

                        // for checkbox
                        if( $section.hasClass( 'section-checkbox' ) ) {

                            $section.find( 'label.checkbox' ).each(function(){
                                var $label = $(this),
                                    $elem = $label.children(':first'),
                                    old_name = $elem.attr('name'),
                                    new_name = old_name.replace(parent_name, ''),
                                    old_id = $elem.attr('id'),
                                    new_id = '';

                                // name
                                new_name = new_name.substring( new_name.indexOf(']')+1 );
                                new_name = parent_name + '[' + newCounter + ']' + new_name;
                                $elem.attr('name', new_name);

                                // id
                                new_id = old_id.substr(0, old_id.indexOf( '-', parent_name.length+1)+1 ) + newCounter;
                                new_id = new_id + old_id.substr( new_id.length );
                                $elem.attr('id', new_id);

                                $label.attr( 'for', new_id );
                            });
                        }

                        // for color picker
						if ( $section.hasClass( 'section-color' ) ) {
							colorpicker_id = $section.find('.field').attr('id');
							panelUi.bind_colorpicker( colorpicker_id, '', '' );
						}
						if ( $section.hasClass( 'section-background' ) ) {
							colorpicker_id = $section.find('.color-picker .field').attr('id');
							panelUi.bind_colorpicker( colorpicker_id, '', '' );
						}

                        // for repeater
                        if ( $section.hasClass( 'section-repeater' ) ) {
                            var $control = $section.find( '> .control_id' ),
                                old_name = $control.val(),
                                new_name = old_name.replace(parent_name, ''),
                                new_name = new_name.substring( new_name.indexOf(']')+1 );
                                new_name = parent_name + '[' + newCounter + ']' + new_name;

                            $control.val(new_name);
                        }

                    }); // End Each Section

                    // Sliding Animation
                    if ( $copy.parents('.builder-popup-content').length )
                        $('.builder-popup-content').animate({
                            scrollTop: $current.offset().top - 220
                        }, 1000);
                    else
                        $('html, body').stop(true).animate({
                            scrollTop: $current.offset().top - 50
                        }, 1000);

                }); // End Repeater Click
            },

            repeater_group_actions: function() {

                // Binding
                $('body').on( 'click', '.repeater-group-header', function( e ) {
                    e.preventDefault();

                    $(this).next('.repeater-sections').slideToggle();

                }); // End Group Header Click

                $('body').on( 'click', '.repeater-close', function( e ) {
                    e.preventDefault();

                    $(this).closest('.repeater-sections').slideToggle();

                }); // End Close Click

                $('body').on( 'click', '.repeater-delete', function( e ) {
                    e.preventDefault();

                    var $this = $(this).closest('.repeater-group');
                    $this.fadeOut(function(){
                        $this.remove();
                    });

                }); // End Delete Click
            }
        },

		// Helpers
		select_widget_fix: function( item ) {

            context = (typeof item !== 'undefined' && item ) ? item : '#widgets-right';

            // recreate chosen
            $('.chosen', context ).each(function() {
                $elem = $(this);
                // destory chosen
                $elem.chosen('destroy');

                //recreate
                $elem.chosen({
                    allow_single_deselect: true
                });
            });

            // recreate ajax chosen
            $('.chosen-ajax', context ).each(function(index, value) {
                // destory chosen
                //$elem.next('.chosen-container').remove();
                $elem.chosen('destroy');

                //recreate
                $elem.ajaxChosen({
                    type: 'GET',
                    url: ajaxurl,
                    dataType: 'json',
                    data: {
                        action: 'spyropress_search_taxonomy',
                        type: $elem.data('type'),
                        wp_type: $elem.data('wp_type')
                    }
                }, function(data) {
                    var results = [];
                    $.each(data, function(i, val) {
                        results.push({
                            value: val.value,
                            text: val.text
                        });
                    });

                    return results;
                }, {
                    allow_single_deselect: true
                });
            });
		},

		range_slider_widget_fix: function( item ) {

            var b = this,
                context = (typeof item !== 'undefined' && item ) ? item : '#widgets-right';

            $( '.slider', context ).each( function( index, value ) {
                var $this = $(this),
                    $field = $(this).next(),
                    id = $this.attr('id').replace( /\d+/g, '__i__');
                $this.slider();
                $this.slider( 'option', b.sliders[id] );

                $field.keyup(function(event){
                    if ( event.which == 13 ) {
                        event.preventDefault();
                    }
                    else{
                        $(this).prev().slider( 'value', parseInt( $field.val() ) );
                    }
                });
            });
		},

		// Binders
        bind_range_slider: function( field_id, options ) {
			var b = this,
                $this = $('#' + field_id),
                $field = $this.next(),
				settings = {
					animate: true,
					slide: function(event, ui) {
						$(this).next('input').val(ui.value);
					}
				};
			$.extend(settings, options);

			// if its widget page
			if ( typeof pagenow !== 'undefined' && pagenow == 'widgets') {

				// if on right side
				if ($this.parents('#widgets-right').length) {
					//$this.slider(settings);
					//return;
				}
                // if on left side
				else {
                    b.sliders[field_id] = settings;
					return;
				}
			}

			$this.slider(settings);
            $field.keyup(function(event){
                if ( event.which == 13 ) {
                    event.preventDefault();
                }
                else{
                    $(this).prev().slider( 'value', parseInt( $field.val() ) );
                }
            });
		},

		bind_colorpicker: function(field_id) {

			$('#' + field_id).colorpicker({
				alpha: true,
				altField: $('#' + field_id).next().find('div'),
				altProperties: 'background-color,border-color',
				hsv: false,
				colorFormat: '#HEX',
				close: function(a, data) {
					if (data.a < 1) {
						var r = Math.round(data.rgb.r * 255),
							g = Math.round(data.rgb.g * 255),
							b = Math.round(data.rgb.b * 255),
							_val = 'rgba(' + r + ',' + g + ',' + b + ',' + data.a + ')';

						$(this).val(_val);
					}
				}
			});
		},

		bind_padder: function(field_id, options) {
			var p = this;
			field_id = '#' + field_id;

			// slider
			$.each(options.slider, function(k, v) {
				settings = {
					animate: true,
					range: 'min',
					min: 0,
					max: 100,
					slide: function(event, ui) {
						$(this).next('input').val(ui.value + 'px');
						$(this).prev('strong').find('span').text(ui.value + 'px');
					}
				};

				$(k).slider($.extend(settings, v));
			});
		},

		bind_border: function(field_id, options) {
			var p = this;
			field_id = '#' + field_id;

			// color
			$.each(options.colorpicker, function(k, v) {
				p.bind_colorpicker(v);
			});

			// slider
			$.each(options.slider, function(k, v) {
				settings = {
					animate: true,
					range: 'min',
					min: 0,
					max: 30,
					slide: function(event, ui) {
						$(this).next('input').val(ui.value + 'px');
						$(this).prev('strong').find('span').text(ui.value + 'px');
					}
				};

				$(k).slider($.extend(settings, v));
			});
		},

		bind_typography: function(field_id, options) {
			field_id = '#' + field_id;

			// bind checkbox
			$(field_id + '-use').click(function() {
				if ($(this).is(':checked')) {
					$(field_id).find('.web-font').hide();
					$(field_id).find('.google-font').show();
				} else {
					$(field_id).find('.google-font').hide();
					$(field_id).find('.web-font').show();
				}
			});

			// init chosen on typo
			$('.chosen-typo', field_id).chosen({
				allow_single_deselect: true
			}).change(function() {
				$(field_id + '-preview').css($(this).attr('data-css'), $(this).val());
			});

			$('.chosen-google-variant', field_id).chosen({
				allow_single_deselect: true
			}).change(function() {
				index = $(field_id + '-google-variant').attr('rel');
				item = panelUi.fontList[index];
				panelUi.apply_google_font(field_id, item.family, $(this).val());
			});

			setTimeout(function() {

				$('.chosen-google-typo', field_id).each(function() {
					selected = $(this).attr('data-selected');
					opts = '';
					$.each(panelUi.fontList, function(k, v) {
						if (v.family == selected) opts += '<option selected="selected">' + v.family + '</option>';
						else
						opts += '<option>' + v.family + '</option>';
					});
					$(this).append(opts);
				});

				$('.chosen-google-typo', field_id).chosen({
					allow_single_deselect: true
				}).change(function() {
					var index = $(this).prop('selectedIndex'),
						item = panelUi.fontList[index],
						v = $(field_id + '-google-variant'),
						selected = v.attr('data-selected');

					v.attr('rel', index);
					v.html('');
					if (item.variants !== undefined && item.variants.length > 1) {
						// display variant selection
						variants = '';
						$.each(item.variants, function(k, v) {
							if (v == selected) variants += '<option selected="selected">' + v + '<option>';
							else
							variants += '<option>' + v + '<option>';
						});
						v.append(variants).trigger('chosen:updated');
						v.parent().show();
					} else {
						v.parent().hide();
					}
					panelUi.apply_google_font(field_id, item.family, selected);
				}).trigger('change');

				if (!$('.checkbox input', field_id).is(':checked')) $(field_id).find('.google-font').hide();

			}, 3000);

			// bind click event on advance setting
			$('.advance-settings', field_id).click(function() {
				$(this).next().fadeToggle();
				return false;
			});

			// color
			$.each(options.colorpicker, function(k, v) {
				$('#' + v).colorpicker({
					alpha: true,
					altField: $('#' + v).next().find('div'),
					altProperties: 'background-color,border-color',
					hsv: false,
					colorFormat: '#HEX',
					select: function(a, data) {
						if ($('#' + v).hasClass('shadow')) {
							panelUi.apply_text_shadow(field_id, data);
						} else {
							$(field_id + '-preview').css('color', data.formatted);
						}
					}
				});
			});

			// slider
			$.each(options.slider, function(k, v) {
				settings = {
					animate: true,
					slide: function(event, ui) {
						$(this).next('input').val(ui.value + 'px');
						$(this).prev('strong').find('span').text(ui.value + 'px');
						if ($(this).attr('data-css') == 'text-shadow') {
							panelUi.apply_text_shadow(field_id);
						} else {
							$(field_id + '-preview').css($(this).attr('data-css'), ui.value + 'px');
						}
					}
				};

				$(k).slider($.extend(settings, v));
			});

			// check for checkbox
			if ($(field_id + '-use').is(':checked')) {
				$(field_id).find('.google-font').show();
				$(field_id).find('.web-font').hide();
			} else
			$(field_id).find('.web-font').show();
		},

		apply_google_font: function(field_id, family, variant) {
			//if (typeof tinyMCE !== 'undefined' && tinyMCE) {
            var fontFamilyNames = new Array();
			fontFamilyNames.push(family + ':' + variant);
			WebFont.load({
				google: {
					families: fontFamilyNames
				}
			});

			$(field_id + '-preview').css('font-family', family);
			$(field_id + '-preview').css('font-style', '');
			$(field_id + '-preview').css('font-weight', '');

			if (variant == 'italic') {
				$(field_id + '-preview').css('font-style', variant);
			} else if (variant != 'regular') {
				weight = variant.substring(0, 3);
				style = variant.substring(3);
				$(field_id + '-preview').css('font-weight', weight);
				if (style != '') $(field_id + '-preview').css('font-style', style);
			}
		},

		apply_text_shadow: function(field_id, data) {

			if ($(field_id + '-shadowcolor').val() == '') return false;

			if (typeof data != 'undefined') {
				if (data.a < 1) {
					var r = Math.round(data.rgb.r * 255),
						g = Math.round(data.rgb.g * 255),
						b = Math.round(data.rgb.b * 255),
						_val = 'rgba(' + r + ',' + g + ',' + b + ',' + data.a + ')';

					$(field_id + '-shadowcolor').val(_val);
				}
			}
			ts = $(field_id + '-hshadow-value').val() + ' ' + $(field_id + '-vshadow-value').val() + ' ' + $(field_id + '-blur-value').val() + ' ' + $(field_id + '-shadowcolor').val();
			$(field_id + '-preview').css('text-shadow', ts);
			$(field_id + '-preview').css('-moz-text-shadow', ts);
			$(field_id + '-preview').css('-webkit-text-shadow', ts);
		},
	}; // panelUI

	$(document).ready(function($) {
		panelUi.init();
	});

})(jQuery);