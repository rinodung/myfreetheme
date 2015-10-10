
// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {
    var shortcodeUI = {
    	loadVals: function()
    	{
    		var shortcode = $('#_spyropress_shortcode').text(),
                uShortcode = '',
                attr = {};
    		
    		// fill in the gaps eg {{param}}
    		$('.spyropress-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('spyropress_', '');		// gets rid of the spyropress_ prefix
   				
                if( input.attr( 'type' ) === 'checkbox' ) {
                    if( input.is( ':checked' ) )
                        attr[id] = '1';
                }
                else {
                    attr[id] = input.val();
                }
    		});
            
            var content = attr.content ? attr.content : $('#_spyropress_default_content').html(),
                f = "";
            for ( var d in attr ) {
                var g = attr[d];
                if ( g && d != "content" ) f += " " + d + '="' + g + '"'
            }
            uShortcode = "[" + shortcode + f + "]" + ( content ? content + "[/" + shortcode + "] " : " ");
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_spyropress_ushortcode').remove();
    		$('#spyropress-sc-form-table').prepend('<div id="_spyropress_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_spyropress_cshortcode').text(),
    			pShortcode = '';
    			shortcodes = '';
    		
    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode,
                    attr = {};
    			
    			$('.spyropress-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('spyropress_', '');		// gets rid of the spyropress_ prefix
    				
                    if( input.attr( 'type' ) === 'checkbox' ) {
                        if( input.is( ':checked' ) )
                            attr[id] = '1';
                    }
                    else {
                        attr[id] = input.val();
                    }
    			});
                
                var content = attr.content ? attr.content : '',
                    f = "";
                for ( var d in attr ) {
                    var g = attr[d];
                    if ( g && d != "content" ) f += " " + d + '="' + g + '"'
                }
                rShortcode = "[" + shortcode + f + "]" + ( content ? content + "[/" + shortcode + "] " : " ");
               	
    			shortcodes = shortcodes + rShortcode + "\n";
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_spyropress_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_spyropress_cshortcodes" class="hidden">' + shortcodes + '</div>');
    		
    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_spyropress_ushortcode').text().replace('{{child_shortcode}}', shortcodes);
    		
    		// add updated parent shortcode
    		$('#_spyropress_ushortcode').remove();
    		$('#spyropress-sc-form-table').prepend('<div id="_spyropress_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false
    		});
    		
    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();
    			
    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}
    			
    			return false;
    		});
    		
    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row'
				
			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				spyropressPopup = $('#spyropress-popup');

            tbWindow.css({
                height: spyropressPopup.outerHeight() + 50,
                width: spyropressPopup.outerWidth(),
                marginLeft: -(spyropressPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: (tbWindow.outerHeight()-47),
				overflow: 'auto', // IMPORTANT
				width: spyropressPopup.outerWidth()
			});
			
			$('#spyropress-popup').addClass('no_preview');
    	},
    	load: function()
    	{
    		var	shortcodeUI = this,
    			popup = $('#spyropress-popup'),
    			form = $('#spyropress-sc-form', popup),
    			shortcode = $('#_spyropress_shortcode', form).text(),
    			popupType = $('#_spyropress_popup', form).text(),
    			uShortcode = '';
    		
    		// resize TB
    		shortcodeUI.resizeTB();
    		$(window).resize(function() { shortcodeUI.resizeTB() });
    		
    		// initialise
    		shortcodeUI.loadVals();
    		shortcodeUI.children();
    		shortcodeUI.cLoadVals();
    		
    		// update on children value change
    		$('.spyropress-cinput', form).live('change', function() {
    			shortcodeUI.cLoadVals();
    		});
    		
    		// update on value change
    		$('.spyropress-input', form).change(function() {
    			shortcodeUI.loadVals();
    		});
    		
    		// when insert is clicked
    		$('.spyropress-insert', form).click(function() {    		 			
    			if(window.tinyMCE)
				{
					//window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, $('#_spyropress_ushortcode', form).html());
                    window.tinyMCE.activeEditor.execCommand( "mceInsertContent", false, $('#_spyropress_ushortcode', form).html() );
					tb_remove();
				}
    		});
    	}
	}
    
    // run
    $('#spyropress-popup').livequery( function() { shortcodeUI.load(); } );
});