/* ========================================================================
 * Bootstrap: bootstrap-iconpicker.js v1.0.0 by @recktoner
 * https://victor-valencia.github.com/bootstrap-iconpicker
 * ========================================================================
 * Copyright 2013 Victor Valencia Rico.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ======================================================================== */


+function ($) { "use strict";


    // ICONPICKER PUBLIC CLASS DEFINITION
    // ==============================
    var Iconpicker = function (element, options) {
      this.$element = $(element);
      this.options  = $.extend({}, Iconpicker.DEFAULTS, this.$element.data());
      this.options  = $.extend({}, this.options, options);
    };

    Iconpicker.ICONSET = {
        glyphicon : [],
        fa : [
            'book',
            'shopping-cart',
            'gift',
            'keyboard-o',
            'institution',
            'graduation-cap',
            'car',
            'space-shuttle',
            'globe',
            'heart',
            'money',
            'credit-card',
            'calendar',
            'pencil-square-o',
            'tasks',
            'music',
            'headphones',
            'cutlery',
            'video-camera',
            'puzzle-piece',
            'leaf',
            'star',
            'archive',
            'bug',
            'recycle'
        ]
    };

    Iconpicker.DEFAULTS = {
        iconset: 'fa',
        icon: '',
        rows: 4,
        cols: 4,
        placement: 'right',
    };

    Iconpicker.prototype.createButtonBar = function(){
        var op = this.options;
        var tr = $('<tr></tr>');
        for(var i = 0; i < op.cols; i++){
            var btn = $('<button class="btn btn-primary"><span class="glyphicon"></span></button>');
            var td = $('<td class="text-center"></td>');
            if(i == 0 || i == op.cols - 1){
                btn.val((i==0) ? -1: 1);
                btn.addClass((i==0) ? 'btn-previous': 'btn-next');
                btn.find('span').addClass( (i == 0) ? 'glyphicon-arrow-left': 'glyphicon-arrow-right');
                td.append(btn);
                tr.append(td);
            }
            else if(tr.find('.page-count').length == 0){
                td.attr('colspan', op.cols - 2).append('<span class="page-count"></span>');
                tr.append(td);
            }
        }
        op.table.find('thead').append(tr);
    };

    Iconpicker.prototype.updateButtonBar = function(page){
        var op = this.options;
        var total_pages = Math.ceil( op.icons.length / (op.cols * op.rows) );
        op.table.find('.page-count').html(page + ' / ' + total_pages);
        var btn_prev = op.table.find('.btn-previous');
        var btn_next = op.table.find('.btn-next');
        (page == 1) ? btn_prev.addClass('disabled'): btn_prev.removeClass('disabled');
        (page == total_pages) ? btn_next.addClass('disabled'): btn_next.removeClass('disabled');
    };

    Iconpicker.prototype.bindEvents = function(){
        var op = this.options;
        var el = this;
        op.table.find('.btn-previous, .btn-next').off('click').on('click', function(){
            var inc = parseInt($(this).val());
            el.changeList(op.page + inc);
        });
        op.table.find('.btn-icon').off('click').on('click', function(){
            el.select($(this).val());
            el.$element.popover('destroy');
        });
    };

    Iconpicker.prototype.select = function(icon){
        var op = this.options;
        var el = this.$element;
        op.selected = $.inArray(icon.replace(op.iconClassFix, ''), op.icons);
        if(op.selected == -1){
            op.selected = 0;
            icon = op.iconClassFix + op.icons[op.selected];
        }
        if(icon != '' && op.selected >= 0){
            op.icon = icon;
            el.find('input').val(icon);
            el.find('i').attr('class', '').addClass(op.iconClass).addClass(icon);
            el.trigger({ type: "change", icon: icon });
            op.table.find('button.btn-warning').removeClass('btn-warning');
        }
    };

    Iconpicker.prototype.switchPage = function(icon){
        var op = this.options;
        op.selected = $.inArray(icon.replace(op.iconClassFix, ''), op.icons);
        if(icon != '' && op.selected >= 0){
            var page = Math.ceil( (op.selected + 1) / (op.cols * op.rows) );
            this.changeList(page);
        }
        op.table.find('.'+icon).parent().addClass('btn-warning');
    };

    Iconpicker.prototype.changeList = function(page){
        var op = this.options;
        this.updateButtonBar(page);
        var tbody = op.table.find('tbody').empty();
        var offset = (page - 1) * op.rows * op.cols;
        for(var i = 0; i < op.rows; i++){
            var tr = $('<tr></tr>');
            for(var j = 0; j < op.cols; j++){
                var pos = offset + (i * op.cols) + j;
                var btn = $('<button class="btn btn-default btn-icon"></button>').hide();
                if(pos < op.icons.length){
                    var v = op.iconClassFix + op.icons[pos];
                    btn = $('<button class="btn btn-default btn-icon" value="' + v + '" title="' + v + '"><i class="' + op.iconClass + ' ' + v + '"></i></button>');
                }
                var td = $('<td></td>').append(btn);
                tr.append(td);
            }
            tbody.append(tr);
        }
        op.page = page;
        this.bindEvents();
    }

    Iconpicker.prototype.setIcon = function (icon) {
        this.select(icon);
    }

    // ICONPICKER PLUGIN DEFINITION
    // ========================
    var old = $.fn.iconpicker;
    $.fn.iconpicker = function (option, params) {
        return this.each(function () {
            var $this   = $(this);
            var data    = $this.data('bs.iconpicker');
            var options = typeof option == 'object' && option;
            if (!data) $this.data('bs.iconpicker', (data = new Iconpicker(this, options)));
            if (typeof option == 'string') data[option](params)
            else{
                var op = data.options;
                var ic = (op.iconset == 'fontawesome') ? 'fa' : 'glyphicon';
                op = $.extend(op, {
                    icons: Iconpicker.ICONSET[ic],
                    iconClass: ic,
                    iconClassFix: ic + '-',
                    page: 1,
                    selected: -1,
                    table: $('<table class="table-icons"><thead></thead><tbody></tbody></table>')
                });
                var name = ( typeof $this.attr('name') != 'undefined' ) ? 'name="' + $this.attr('name') + '"' : '';
                $this.empty()
                    .append('<i></i>')
                    .append('<input type="hidden" ' + name + '></input>')
                    .append('<span class="caret"></span>');
                $this.addClass('iconpicker');
                data.createButtonBar();
                data.changeList(1);
                $this.on('click', function(e){
                    e.preventDefault();
                    $this.popover({
                        animation: false,
                        trigger: 'manual',
                        html: true,
                        content: data.options.table,
                        container: 'body',
                        placement: data.options.placement
                    }).on('shown.bs.popover', function () {
                        data.switchPage(op.icon);
                        data.bindEvents();
                    });

                    $this.data('bs.popover').tip().addClass('iconpicker-popover')
                    $this.popover('show');
                });
                data.select(op.icon);
            }
        });
    };

    $.fn.iconpicker.Constructor = Iconpicker;


    // ICONPICKER NO CONFLICT
    // ==================
    $.fn.iconpicker.noConflict = function () {
        $.fn.iconpicker = old;
        return this;
    };


    // ICONPICKER DATA-API
    // ===============
    $('body').on('click', function (e) {
        $('.iconpicker').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if ( ! $(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('destroy');
            }
        });
    });

    $('button[role="iconpicker"]').iconpicker();


}(window.jQuery);
