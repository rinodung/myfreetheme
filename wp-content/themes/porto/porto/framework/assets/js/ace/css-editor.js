( function( global, $ ) {
    var editor,
        $textarea = $( '#custom_css_textarea' ),
        syncCSS = function() {
            $textarea.val( editor.getSession().getValue() );
        },
        loadAce = function() {
            editor = ace.edit( 'custom_css' );
            global.safecss_editor = editor;
            editor.getSession().setUseWrapMode( true );
            editor.setShowPrintMargin( false );
            editor.getSession().setValue( $textarea.val() );
            editor.getSession().setMode( "ace/mode/css" );
            
            editor.getSession().on( 'change', syncCSS );
            jQuery.fn.spin&&$( '#custom_css_container' ).spin( false );
        };
    
    $textarea.hide();
    $textarea.before( '<div id="custom_css_container"><div name="custom_css" id="custom_css" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 100%; height: 400px; position: relative;"></div></div>' );
    if ( $.browser.msie&&parseInt( $.browser.version, 10 ) <= 7 ) {
        $( '#custom_css_container' ).hide();
        $textarea.show();
        return false;
    } else {
        $( global ).load( loadAce );
    }
    global.aceSyncCSS = syncCSS;
} )( this, jQuery );