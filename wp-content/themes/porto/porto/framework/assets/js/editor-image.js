(function() {

    tinymce.create( 'tinymce.plugins.spyropressImage', {

        init : function(ed, url){
            
            ed.addButton('spyropress_image', {
                title : 'Insert Image',
                onclick : function() {
                    if( typeof wp !== "undefined" && wp.media &&wp.media.editor){
                        wp.media.editor.open(ed.editorId)
                    }
                },
                icon: 'image'
                //image: spyropress_admin_settings['media_url'] + 'media-button.png'
            });
        }
    });

    tinymce.PluginManager.add( 'spyropressImage', tinymce.plugins.spyropressImage );
    
})();