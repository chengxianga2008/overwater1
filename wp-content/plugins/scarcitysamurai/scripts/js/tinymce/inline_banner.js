// Generated by CoffeeScript 1.4.0

/*

LEGAL COPYRIGHT NOTICE

Copyright (c) Noble Samurai Pty Ltd, 2008-2013. All Rights Reserved.

This software is proprietary to and embodies the confidential technology of Noble Samurai Pty Ltd.
Possession, use, dissemination or copying of this software and media is authorised only pursuant
to a valid written license from Noble Samurai Pty Ltd. Questions or requests regarding permission may
be sent by email to legal@noblesamurai.com or by post to PO Box 477, Blackburn Victoria 3130, Australia.
*/


(function() {

  (function($) {
    tinymce.PluginManager.requireLangPack('ss_inline_banner');
    tinymce.create('tinymce.plugins.SSInlineBannerPlugin', {
      /*
             Initializes the plugin, this will be executed after the plugin has been
             created. This call is done before the editor instance has finished it's
             initialization so use the onInit event of the editor instance to
             intercept that event.
      
             @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
             @param {string} url Absolute URL to where the plugin is located.
      */

      init: function(ed, url) {
        var bannerHTML,
          _this = this;
        this.url = url;
        this.editor = ed;
        bannerHTML = function(args) {
          var attributes;
          args.banner_align = args.banner_align || 'none';
          attributes = ScarcitySamuraiHelper.buildAttributesHTML({
            'class': 'data-wp-imgselect ss-inline-banner-placeholder mceItemNoResize align' + args.banner_align,
            'data-ss-banner-id': args.banner_id,
            'data-ss-banner-show-type': args.banner_show_type,
            'data-ss-banner-show-value': args.banner_show_value,
            'data-ss-banner-redirect-page-id': args.banner_redirect_page_id,
            'data-ss-banner-redirect-url': args.banner_redirect_url,
            'src': "" + url + "/../../../images/tinymce/inline-banner-placeholder.png"
          });
          return "<img " + attributes + " />";
        };
        ed.addCommand('ssInsertInlineBanner', function(ui, args) {
          return ed.execCommand('mceInsertContent', ui, bannerHTML(args));
        });
        this._createButtons();
        ed.onMouseDown.add(function(ed, e) {
          return _this._showButtons(e);
        });
        ed.onBeforeExecCommand.add(function() {
          return _this._hideButtons();
        });
        ed.onSaveContent.add(function() {
          return _this._hideButtons();
        });
        ed.onKeyDown.add(function(ed, e) {
          if (e.which === tinymce.VK.DELETE || e.which === tinymce.VK.BACKSPACE) {
            return _this._hideButtons();
          }
        });
        ed.onPostRender.add(function() {
          if (!ed.theme.onResolveName) {
            return;
          }
          return ed.theme.onResolveName.add(function(th, o) {
            if ($(o.node).is('img.ss-inline-banner-placeholder')) {
              return o.name = 'ss-banner';
            }
          });
        });
        ed.onPostProcess.add(function(ed, o) {
          var $wrapper;
          if (o.get) {
            $wrapper = $('<div />').html(o.content);
            $('.ss-inline-banner-placeholder', $wrapper).each(function() {
              var _ref;
              return $(this).replaceWith(ScarcitySamuraiHelper.inlineBannerHTMLComment({
                banner_id: $(this).data('ss-banner-id'),
                banner_align: (_ref = $(this).attr('class').match(/\balign(left|right|center)\b/)) != null ? _ref[1] : void 0,
                banner_show_type: $(this).data('ss-banner-show-type'),
                banner_show_value: $(this).data('ss-banner-show-value'),
                banner_redirect_page_id: $(this).data('ss-banner-redirect-page-id'),
                banner_redirect_url: $(this).data('ss-banner-redirect-url')
              }));
            });
            return o.content = $wrapper.html();
          }
        });
        return ed.onBeforeSetContent.add(function(ed, o) {
          var regex;
          if (!o.content) {
            return;
          }
          regex = /<!--\s*ss-banner\s+(.*?)\s*-->/g;
          return o.content = o.content.replace(regex, function(match, attributes) {
            var $element;
            $element = $("<element " + attributes + " />");
            return bannerHTML({
              banner_id: $element.attr('id'),
              banner_align: $element.attr('align') || 'none',
              banner_show_type: $element.attr('show-type'),
              banner_show_value: $element.attr('show-value'),
              banner_redirect_page_id: $element.attr('redirect-page-id'),
              banner_redirect_url: $element.attr('redirect-url')
            });
          });
        });
      },
      _createButtons: function() {
        var $buttons, $deleteButton, $editButton, isRetina, x2,
          _this = this;
        if ($('#ss-inline-banner-edit-buttons').length) {
          return;
        }
        isRetina = (window.devicePixelRatio && window.devicePixelRatio > 1) || (window.matchMedia && window.matchMedia('(min-resolution:130dpi)').matches);
        x2 = isRetina ? '-x2' : '';
        $buttons = $('<div />').attr({
          id: 'ss-inline-banner-edit-buttons'
        }).addClass('ss-placeholder').hide();
        $editButton = $('<img />').attr({
          src: "" + this.url + "/img/edit" + x2 + ".png",
          width: 24,
          height: 24
        });
        $deleteButton = $('<img />').attr({
          src: "" + this.url + "/img/delete" + x2 + ".png",
          width: 24,
          height: 24
        });
        $editButton.click(function() {
          return _this._editBanner();
        });
        $deleteButton.click(function() {
          return _this._deleteBanner();
        });
        $buttons.append($editButton).append($deleteButton);
        return $(document.body).append($buttons);
      },
      _showButtons: function(e) {
        this._hideButtons();
        if (!$(e.target).is('img.ss-inline-banner-placeholder')) {
          return;
        }
        return this.editor.plugins.wordpress._showButtons(e.target, 'ss-inline-banner-edit-buttons');
      },
      _hideButtons: function() {
        return $('#ss-inline-banner-edit-buttons').hide();
      },
      _editBanner: function() {
        var ed, el, _ref;
        ed = tinymce.activeEditor;
        el = ed.selection.getNode();
        if (!$(el).is('img.ss-inline-banner-placeholder')) {
          return;
        }
        this._hideButtons();
        return window.ssam.edit_banner({
          banner_id: $(el).data('ss-banner-id'),
          banner_show_type: $(el).data('ss-banner-show-type'),
          banner_show_value: $(el).data('ss-banner-show-value'),
          banner_align: (_ref = $(el).attr('class').match(/\balign(left|right|center)\b/)) != null ? _ref[1] : void 0,
          banner_redirect_page_id: $(el).data('ss-banner-redirect-page-id'),
          banner_redirect_url: $(el).data('ss-banner-redirect-url')
        });
      },
      _deleteBanner: function() {
        var ed, el;
        ed = tinymce.activeEditor;
        el = ed.selection.getNode();
        if (!$(el).is('img.ss-inline-banner-placeholder')) {
          return;
        }
        this._hideButtons();
        return $(el).remove();
      },
      /*
             Returns information about the plugin as a name/value array.
             The current keys are longname, author, authorurl, infourl and version.
      
             @return {Object} Name/value array containing information about the plugin.
      */

      getInfo: function() {
        return {
          longname: 'Scarcity Samurai Inline Banner Plugin',
          author: 'Noble Samurai',
          authorurl: 'http://scarcitysamurai.com',
          infourl: 'http://scarcitysamurai.com',
          version: '1.0'
        };
      }
    });
    return tinymce.PluginManager.add('ss_inline_banner', tinymce.plugins.SSInlineBannerPlugin);
  })(jQuery);

}).call(this);
