String.prototype.format = function() {
    var formatted = this;
    for (var i = 0; i < arguments.length; i++) {
        var regexp = new RegExp('\\{'+i+'\\}', 'gi');
        formatted = formatted.replace(regexp, arguments[i]);
    }
    return formatted;
};

;(function($) {
    
    $.in_array = function(v, a) {
        r = $.inArray(v,a);
        if(r > -1)
            return true;
        if(r == -1)
            return false;
    };
    window.dialog_ui;
    dialog_ui = {
        needsPreview: false,
        
        // init routine
        init: function() {
            var d = this;
            
            d.setup_buttons();
            d.load_shortcode_details();
            d.setup_select();
        },
        
        // setup buttons and there actions
        setup_buttons: function () {
            var d = this;
            
            $("#spyropress-btn-cancel").click(function () { d.close_dialog(); });
            $("#spyropress-btn-insert").click(function () { d.insert_action(); });
            $("#spyropress-btn-preview").click(function () { d.preview_action(); });
        },
        close_dialog: function () {
            this.needsPreview = false;
            tb_remove();
            $("#spyropress-dialog").remove()
        },
        insert_action: function () {
            if (typeof spyropressShortcodeMeta != "undefined") {
                var a = this.makeShortcode('insert');
                tinyMCE.activeEditor.execCommand("mceInsertContent", false, a);
                this.close_dialog()
            }
        },
        preview_action: function (a) {
            $("#spyropress-preview h3:first").addClass("spyropress-loading");
            $("#spyropress-preview-iframe").attr("src", spyropress_admin_settings['shortcode_url']+"preview-shortcode-external.php?shortcode=" + encodeURIComponent(this.makeShortcode('preview')));
        },
        
        // setup chosen
        setup_select: function() {
            var d = this;
            
            var t = setTimeout(function(){
                $('.chosen', '#spyropress-shortcode-gen').delay(800).chosen({
                    allow_single_deselect: true
                }).change(function(){
                    d.preview_action();
                });
            }, 500); 
        },
        
        // load shortcode details
        load_shortcode_details: function () {
            if (spyropressSelectedShortcodeType) {
                var d = this;
                $.getScript(spyropress_admin_settings['shortcode_url']+"sc/" + spyropressSelectedShortcodeType + ".js", function () {
                    d.initializeDialog()
                });
            }
        },
        initializeDialog: function () {
            if (typeof spyropressShortcodeMeta == "undefined")
                $("#spyropress-shortcode-gen").append("<p>Error loading details for shortcode: " + spyropressSelectedShortcodeType + "</p>");
            else {
                
                if (spyropressShortcodeMeta.disablePreview) {
                    $("#spyropress-btn-preview").remove();
                    $("#spyropress-preview-iframe").remove();
                    $('.sc-head', "#spyropress-preview").remove();
                }
                
                preview = $('#spyropress-preview');
                
                $('#TB_ajaxContent').scroll(function(e){
                    var scrollAmount = $(this).scrollTop();
                    var newPosition = 90+scrollAmount;
                    
                    preview.stop().animate({top: newPosition}, 1000, 'linear');
                });
                
                var a = spyropressShortcodeMeta.attributes,
                    b = $("#spyropress-shortcode-gen");
                
                for (var c in a) {
                    
                    var type = a[c].type,
                        id = a[c].id;
                    
                    // create section
                    var section = $('<div />', {
                        class: 'section section-full section-'+a[c].type,
                        //id: 'section-'+a[c].id
                    });
                    
                    // add extra class
                    if (a[c].target != null && a[c].target == 'font-awesome')
                        section.addClass('section-fontawesome');
                    
                    // create title
                    title = $('<h3 />', { class: 'heading' }).text(a[c].name);
                    if ( a[c].isRequired )
                        title.append('<span class="required">*</span>');
                    section.append(title);
                    
                    // create control div
                    control = $( '<div />', { class: 'controls' } );
                    
                    // generate control
                    switch (type) {
                        case 'text':
                            this.create_text( a[c], control, id );
                            break;
                        case 'upload':
                            this.create_upload( a[c], control, id );
                            break;
                        case 'textarea':
                            this.create_textarea( a[c], control, id );
                            break;
                        case 'checkbox':
                            this.create_checkbox( a[c], control, id );
                            break;
                        case 'multi_checkbox':
                            this.create_multi_checkbox( a[c], control, id );
                            break;
                        case 'radio':
                            this.create_radio( a[c], control, id );
                            break;
                        case 'select':
                            this.create_select( a[c], control, id );
                            break;
                        case 'multi_select':
                            this.create_multi_select( a[c], control, id );
                            break;
                        case 'range_slider':
                            this.create_range_slider( a[c], control, id );
                            break;
                        case 'colorpicker':
                            this.create_color_picker( a[c], control, id );
                            break;
                    }
                    control.append('<div class="clear" />');
                    section.append(control);
                    
                    // create desc
                    if ( a[c].desc ) {
                        desc = $( '<div />', { class: 'description' } );
                        desc.html(a[c].desc);
                        section.append(desc)
                    }
                    section.append('<div class="clear" />').appendTo(b);
                }
            }
        },
        create_text: function ( attr, control, id ) {
            var d = this,
                elem = $('<input />', {
                            type: 'text',
                            name: id,
                            id: id,
                            class: 'field'
                        });
            
            if(attr.isRequired)
                elem.addClass('required');
            if(attr.placeholder)
                elem.attr('placeholder',attr.placeholder);
            if(attr.std)
                elem.attr('value',attr.std);
            
            control.append(elem);
            
            if (attr.bind != null)
                elem.bind("keydown focusout", attr.bind);
            else {
                control.find("#" + id).bind("keydown focusout", function (e) {
                    if (e.type == "keydown" && e.which != 13 && e.which != 9 && !e.shiftKey) d.needsPreview = true;
                    else if (d.needsPreview && (e.type == "focusout" || e.which == 13)) {
                        d.preview_action(e.target);
                        d.needsPreview = false
                    }
                });
            }
        },
        create_upload: function ( attr, control, id ) {
            var d = this,
                div = $('<div class="uploader"></div>'),
                elem = $('<input />', {
                            type: 'text',
                            name: id,
                            id: id,
                            class: 'field upload'
                        });
                btn = $('<input class="upload_button button-secondary" type="button" value="Upload" id="upload_'+id+'" />');
            if(attr.isRequired)
                elem.addClass('required');
            
            div.append(elem);
            div.append(btn);
            control.append(div);
            
            if (attr.bind != null)
                elem.bind("keydown focusout", attr.bind);
            else {
                control.find("#" + id).bind("keydown focusout", function (e) {
                    if (e.type == "keydown" && e.which != 13 && e.which != 9 && !e.shiftKey) d.needsPreview = true;
                    else if (d.needsPreview && (e.type == "focusout" || e.which == 13)) {
                        d.preview_action(e.target);
                        d.needsPreview = false
                    }
                });
            }
        },
        create_textarea: function ( attr, control, id ) {
            var d = this,
                elem = $('<textarea />', {
                            type: 'text',
                            name: id,
                            id: id,
                            rows: 6,
                            class: 'field'
                        });
            
            if(attr.isRequired)
                elem.addClass('required');
            if(attr.placeholder)
                elem.attr('placeholder',attr.placeholder);
            if(attr.std)
                elem.html(attr.std);
            
            control.append(elem);
    
            control.find("#" + id).live("keydown focusout", function (e) {
                if (e.type == "keydown" && e.which != 13 && e.which != 9 && !e.shiftKey) d.needsPreview = true;
                else if (d.needsPreview && (e.type == "focusout" || e.which == 13)) {
                    d.preview_action(e.target);
                    d.needsPreview = false
                }
            });
        },
        create_checkbox: function ( attr, control, id ) {
            var d = this,
                elem = $('<input />', {
                            type: 'checkbox',
                            name: id,
                            id: id,
                            value: 1
                        }),
                label = $('<label />', {
                            for: id,
                            class: 'checkbox'
                        });
            
            if(attr.isRequired)
                elem.addClass('required');
            if(attr.std && attr.std == 1)
                elem.attr('checked','checked');
            
            label.append(elem).append(attr.label);
            control.append(label);            
            
            control.find("#" + id).live("change focusout", function (e) {
                if (e.type == "change" || e.type == "focusout") {
                    d.preview_action(e.target);
                    d.needsPreview = false
                }
            });
        },
        create_multi_checkbox: function ( attr, control, id ) {
            var d = this;
            
            for (var c in attr.options) {
                m_id = id + '_' + attr.options[c].value;
                                    
                elem = $('<input />', {
                            type: 'checkbox',
                            name: id+'['+c+']',
                            id: m_id,
                            value: attr.options[c].value
                        });
                
                label = $('<label />', {
                            for: m_id,
                            class: 'checkbox'
                        });
                
                if(attr.std && attr.std[c] == 1)
                    elem.attr('checked','checked');
                
                label.append(elem).append(attr.options[c].label);
                control.append(label);            
                
                control.find("#" + m_id).live("change focusout", function (e) {
                    if (e.type == "change" || e.type == "focusout") {
                        d.preview_action(e.target);
                        d.needsPreview = false
                    }
                });
            }
        },
        create_radio: function ( attr, control, id ) {
            var d = this;
                
            // if any target merge options
            if (attr.target != null) {
                if (attr.options == null) attr.options = [];
                
                $.extend(attr.options, this.get_target_options(attr.target));
            }
            
            for (var c in attr.options) {
                m_id = id + '_' + attr.options[c].value;
                                    
                elem = $('<input />', {
                            type: 'radio',
                            name: id,
                            id: m_id,
                            value: attr.options[c].value
                        });
                
                label = $('<label />', {
                            for: m_id,
                            class: 'checkbox'
                        });
                
                if(attr.std && attr.std[c] == attr.options[c].value)
                    elem.attr('checked','checked');
                
                label.append(elem).append(attr.options[c].label);
                control.append(label);            
                
                label.click(function(){
                    d.preview_action();
                    d.needsPreview = false;
                });
                control.find("#" + m_id).live("change focusout", function (e) {
                        d.preview_action();
                        d.needsPreview = false;
                });
            }
        },
        create_select: function ( attr, control, id ) {
            var d = this,
                elem = $('<select />', {
                            class: 'chosen',
                            name: id,
                            id: id
                        });
            
            if( attr.isRequired)
                elem.addClass('required');
            
            // append empty option
            elem.append('<option value=""></option>');
            
            // if any target merge options
            if (attr.target != null) {
                
                if (attr.options == null) {
                    attr.options = [];
                    $.extend(attr.options, d.get_target_options(attr.target));
                }
                else {
                    $.merge(attr.options,d.get_target_options(attr.target));
                }
            }
            
            for (var c in attr.options) {
                d.render_option(elem, attr.options[c].value, attr.options[c].label, attr.options[c].name, attr.std);
            }
            
            if (attr.onchange != null)
                elem.change(attr.onchange);
            
            control.append(elem);
        },
        create_multi_select: function ( attr, control, id ) {
            var d = this,
                elem = $('<select />', {
                            class: 'chosen',
                            name: id+'[]',
                            id: id,
                            multiple: 'multiple'
                        });
            
            if( attr.isRequired)
                elem.addClass('required');
            
            // append empty option
            elem.append('<option value=""></option>');
            
            // if any target merge options
            if (attr.target != null) {
                if (attr.options == null) attr.options = [];
                
                $.extend(attr.options, this.get_target_options(attr.target));
            }
            
            for (var c in attr.options) {
                d.render_option(elem, attr.options[c].value, attr.options[c].label, attr.options[c].name, attr.std);
            }
            
            control.append(elem);
        },
        render_option: function(elem, k, v, name, selected) {
            var d = this;
            
            k = (k.length) ? k : v.toLowerCase();
            
            if( $.isArray(v)) {
                group = $('<optgroup />', { label: name });
                if( !$.isEmptyObject(v) ) {
                    for (var c in v)
                        d.render_option(group, v[c].value, v[c].label, name, selected);
                }
                elem.append(group);
            }
            else {
                elem.append('<option value="{0}"{1}>{2}</option>'.format( k, ($.in_array(k, selected)) ? ' selected="selected"' : '', v));
            }
        },
        create_range_slider: function ( attr, control, id ) {
            var d = this,
                rs = $('<div />', { class: 'range-slider'}),
                rs_div = $('<div />', { class: 'slider', id: id }),
                rs_inp = $('<input />', { type: 'text', name: id, id: id+'_field', class: 'field'});
            
            if(attr.value != null) rs_inp.val(attr.value);
            
            // settings
            settings = {
                animate: true,
                range: 'min',
                slide: function( event, ui ) {
                    $(this).next('input').val( ui.value );
                },
                change: function() {
                    d.preview_action(id);
                }
            };
            $.extend( settings, attr );
            
            rs_div.slider(settings);
            
            rs.append(rs_div);
            rs.append(rs_inp);
            rs.append('<div class="clear" />');
            
            control.append(rs);
        },
        create_color_picker: function ( attr, control, id ) {
            var d = this,
                cp = $('<div />', { class: 'color-picker'}),
                cp_div = $('<div class="color-box"><div></div></div>'),
                cp_inp = $('<input />', { type: 'text', name: id, id: id, class: 'field'});
            
            if(attr.std)
                cp_inp.attr('value',attr.std);
            if( attr.isRequired)
                elem.addClass('required');
            
            cp_inp.colorpicker({
                alpha: true,
                altField: $('#'+id).next().find('div'),
                altProperties: 'background-color,border-color',
                hsv: false,
                colorFormat: '#HEX',
                close: function (a, data) {
                    if( data.a < 1 ) {
                        var r = Math.round(data.rgb.r * 255),
                            g = Math.round(data.rgb.g * 255),
                            b = Math.round(data.rgb.b * 255),
                            _val = 'rgba('+r+','+g+','+b+','+data.a+')';
                        
                        $(this).val(_val);
                    }
                    d.preview_action(id);
                }
            });
                                    
            cp.append(cp_inp);
            cp.append(cp_div);
            cp.append('<div class="clear" />');
            
            control.append(cp);
            
        },
        get_target_options: function(target) {
            var options;
            
            switch(target) {
                case 'float':
                    options = [
                        { value: 'left', label: 'Left' },
                        { value: 'right', label: 'Right' }
                    ];
                    break;
                case 'window':
                    options = [                        
                        { value: '_blank', label: 'New window' },
                        { value: '_self', label: 'Same window' }
                    ]
                    break;
                case 'variation':
                    options = [
                        { value: 'primary', label: 'Primary' },
                        { value: 'info', label: 'Info' },
                        { value: 'success', label: 'Success' },
                        { value: 'warning', label: 'Warning' },
                        { value: 'danger', label: 'Danger' },
                        { value: 'inverse', label: 'Inverse' }
                    ]
                    break;
                case 'animation':
                    options = [                        
                        { value: 'flash', label: 'Flash' },
                        { value: 'shake', label: 'Shake' },
                        { value: 'bounce', label: 'Bounce' },
                        { value: 'tada', label: 'Tada' },
                        { value: 'swing', label: 'Swing' },
                        { value: 'wobble', label: 'Wobble' },
                        { value: 'wiggle', label: 'Wiggle' },
                        { value: 'pulse', label: 'Pulse' },
                        { value: 'fadeIn', label: 'FadeIn' },
                        { value: 'fadeInUp', label: 'FadeInUp' },
                        { value: 'fadeInDown', label: 'FadeInDown' },
                        { value: 'fadeInLeft', label: 'FadeInLeft' },
                        { value: 'fadeInRight', label: 'FadeInRight' },
                        { value: 'fadeInUpBig', label: 'FadeInUpBig' },
                        { value: 'fadeInDownBig', label: 'FadeInDownBig' },
                        { value: 'fadeInLeftBig', label: 'FadeInLeftBig' },
                        { value: 'fadeInRightBig', label: 'FadeInRightBig' },
                        { value: 'bounceIn', label: 'BounceIn' },
                        { value: 'bounceInUp', label: 'BounceInUp' },
                        { value: 'bounceInDown', label: 'BounceInDown' },
                        { value: 'bounceInLeft', label: 'BounceInLeft' },
                        { value: 'bounceInRight', label: 'BounceInRight' },
                        { value: 'rotateIn', label: 'RotateIn' },
                        { value: 'rotateInUpLeft', label: 'RotateInUpLeft' },
                        { value: 'rotateInDownLeft', label: 'RotateInDownLeft' },
                        { value: 'rotateInUpRight', label: 'RotateInUpRight' },
                        { value: 'rotateInDownRight', label: 'RotateInDownRight' }
                    ]
                    break;
            }
            
            return options;
        },        
        
        makeShortcode: function (action) {
            var a = {},
                d = this;
            $("#spyropress-shortcode-gen .section").each(function () {
                var h = $(this),
                    e = null;
                
                if(h.hasClass("section-textarea")) {
                    if(e = d.get_textarea(h)) a[e.key] = e.value;
                }
                else if(h.hasClass("section-checkbox")) {
                    if(e = d.get_checkbox(h)) a[e.key] = e.value;
                }
                else if(h.hasClass("section-multi_checkbox")) {
                    if(e = d.get_multi_checkbox(h)) a[e.key] = e.value;
                }
                else if(h.hasClass("section-radio")) {
                    if(e = d.get_radio(h)) a[e.key] = e.value;
                }
                else if(h.hasClass("section-select")) {
                    if(e = d.get_select(h)) a[e.key] = e.value;
                }
                else if(h.hasClass("section-multi_select")) {
                    if(e = d.get_select(h)) a[e.key] = e.value;
                }
                else if(h.hasClass("section-range_slider")) {
                    if(e = d.get_range_slider(h)) a[e.key] = e.value;
                }
                else if(h.hasClass("section-colorpicker")) {
                    if(e = d.get_colorpicker(h)) a[e.key] = e.value;
                }
                else {
                    if(e = d.get_text(h)) a[e.key] = e.value;
                }                
            });
            
            if (spyropressShortcodeMeta.customMakeShortcode) return spyropressShortcodeMeta.customMakeShortcode(a, action);
            var c = a.content ? a.content : spyropressShortcodeMeta.defaultContent,
                f = "";
            for (var d in a) {
                var g = a[d];
                if (g && d != "content") f += " " + d + '="' + g + '"'
            }
            return "[" + spyropressShortcodeMeta.shortcode + f + "]" + (c ? c + "[/" + spyropressShortcodeMeta.shortcode + "] " : " ")
        },
        
        // getters
        get_textarea: function (obj) {
            var b = obj.find("textarea");
            if (!b.length) return null;
            
            _k = b.attr("id");
            _v = b.val();
            return {
                key: _k,
                value: _v
            }
        },
        get_text: function (obj) {
            var b = obj.find("input");
            if (!b.length) return null;
            
            _k = b.attr("id");
            _v = b.val();
            
            return {
                key: _k,
                value: _v
            }
        },
        
        get_checkbox: function (obj) {
            var b = obj.find("input");
            if (!b.length) return null;
            
            _k = b.attr("id");
            if (b.is(':checked')) _v = 1;
            else _v = 0;
            
            return {
                key: _k,
                value: _v
            }
        },
        get_multi_checkbox: function (obj) {
            var b = obj.find("input");
            if (!b.length) return null;
            
            var _v = [];
            b.each(function(i,v){
                _this = $(v);
                if(_this.is(':checked'))
                    _v.push(_this.val());
            });
            
            _k = b.eq(0).attr("name").slice(0,-3);
                        
            return {
                key: _k,
                value: _v.join(',')
            }
        },
        get_radio: function (obj) {
            var b = obj.find("input:checked");
            if (!b.length) return null;
            
            _k = b.attr("name");
            _v = b.val();
            
            return {
                key: _k,
                value: _v
            }
        },
        
        get_select: function (obj) {
            var b = obj.find("select");
            if (!b.length) return null;
            
            _k = b.attr("id");
            _v = b.val();
            
            return {
                key: _k,
                value: _v
            }
        },
        get_multi_select: function (obj) {
            var b = obj.find("select");
            if (!b.length) return null;
            
            _k = b.attr("id");
            _v = b.val();
            
            return {
                key: _k,
                value: _v
            }
        },
        
        get_range_slider: function (obj) {
            var b = obj.find("input");
            if (!b.length) return null;
            
            _k = b.attr("name");
            _v = b.val();
            
            return {
                key: _k,
                value: _v
            }
        },
        
        get_colorpicker: function (obj) {
            var b = obj.find("input");
            if (!b.length) return null;
            
            _k = b.attr("id");
            _v = b.val();
            
            return {
                key: _k,
                value: _v
            }
        }
    };
    
    dialog_ui.init();

})(jQuery);