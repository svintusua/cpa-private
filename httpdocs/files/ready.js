var Ready  = (function($, $n) {
    //Функции которые вызываются на каждой странице
    return $.extend($n, {
        init: function() {
            window.setTimeout(function() {
                Ready.updateTicketCount();
            },60*1000);

            window.setTimeout(function() {
                Ready.updateManagerHeader();
            },10*60*1000);

            this.menuStartup();
            this.initChosen();
            this.initTooltip();
            this.initTabs();
            this.initFixedBtn();
            this.initOpenHiddenBlock();
            this.initScrollbar();
            this.initShowBlock();
            this.initBiggestText();
            this.initFileUpload();
            this.initCopyHtml();
        },

        isInitChosenFlags: false,

        initChosen: function() {
            var obj = this;

            $('select:visible').each(function() {
                if (!$(this).next('.chosen-container').length) {
                    $(this).chosen({
                        disable_search_threshold: 10,
                        allow_single_deselect: true,
                        search_contains: true,
                        no_results_text: "Ничего не найдено!",
                        placeholder_text_multiple: "Выберите значения",
                        placeholder_text_single: "Выберите значение"
                    });

                    if ($(this).hasClass('select-flags')) {
                        obj.initChosenFlags($(this));
                    }
                }
            });

            if ($('#multiple_flags + .chosen-container:visible').length && !this.isInitChosenFlags) {
                obj.isInitChosenFlags = true;
                obj.initChosenMultipleFlags();
            }
        },

        initChosenFlags: function($current) {
            var obj = this,
                $container = $current.next('.chosen-container');

            $current
                .on('change', function (e, params) {
                    var $selector = $container.find('.chosen-single > span:contains(' + params.selected + ')');

                    if (!$selector.find('.icon-flag').length) {
                        $selector.prepend('<i class="icon-flag icon-flag-' + params.selected + '"></i>');
                    }
                })
                .on('chosen:showing_dropdown', function (e, chosen) {
                    obj.chosenFlagsAddIcons($container, 'drop');
                });

            $container.find('.chosen-search input').on('keyup', function () {
                obj.chosenFlagsAddIcons($container, 'search');
            });

            obj.chosenFlagsAddIcons($container, 'search');
        },

        initChosenMultipleFlags: function() {
            var current = this;

            if ($('#multiple_flags').val() != null  && $('.multiple-flags-all').length) {
                $('.multiple-flags-all').prop('checked', false);
            }

            $('#multiple_flags')
                .on('change', function (e, params) {
                    var selector = $('#multiple_flags_chosen .chosen-choices li span:contains(' + params.selected + ')');
                    if (!selector.find('.icon-flag').length) {
                        selector.before('<i class="icon-flag icon-flag-' + params.selected + '"></i>');
                    }

                    if ($(this).val() != null) {
                        $('.multiple-flags-all').prop('checked', false);
                    }
                })
                .on('chosen:showing_dropdown', function (e, chosen) {
                    current.chosenMultipleFlagsAddIcons('drop');
                });

            $('#multiple_flags_chosen .search-field input').on('keyup', function () {
                current.chosenMultipleFlagsAddIcons('search');
            });

            this.chosenMultipleFlagsAddIcons('search');
        },

        chosenMultipleFlagsAddIcons: function(p) {
            var selector = (p == 'drop') ? $('#multiple_flags_chosen .chosen-drop .chosen-results li') : $('#multiple_flags_chosen .chosen-choices li.search-choice');

            selector.each(function () {
                if (!$(this).find('.icon-flag').length) {
                    var text = $.trim($(this).text());
                    $(this).prepend('<i class="icon-flag icon-flag-' + text + '"></i>');
                }
            });
        },

        chosenFlagsAddIcons: function($container, p) {
            var $selector = (p == 'drop') ? $container.find('.chosen-drop .chosen-results li') : $container.find('.chosen-drop .chosen-results li.active-result');
            console.log($selector);
            $selector.each(function () {
                if (!$(this).find('.icon-flag').length) {
                    var text = $.trim($(this).text());
                    $(this).prepend('<i class="icon-flag icon-flag-' + text + '"></i>');
                }
            });
        },

        initTooltip: function() {
            $('.tooltipster-default[title]').tooltipster({
                animation: 'grow',
                delay: 200,
                theme: 'tooltipster-kma',
                touchDevices: false,
                trigger: 'hover',
                contentAsHTML: true,
                position: 'bottom',
                interactive: true,
                maxWidth: 500,
                minWidth: 100
            });
            $.each($('[data-tooltipster-bottom]'), function() {
                $(this).tooltipster({
                    animation: 'grow',
                    delay: 200,
                    theme: 'tooltipster-kma',
                    touchDevices: false,
                    trigger: 'hover',
                    contentAsHTML: true,
                    position: 'bottom',
                    interactive: true,
                    maxWidth: 500,
                    minWidth: 100,
                    multiple: true,
                    content: $(this).attr('data-tooltipster-bottom')
                });
            });
            $.each($('[data-tooltipster-top]'), function() {
                $(this).tooltipster({
                    animation: 'grow',
                    delay: 200,
                    theme: 'tooltipster-kma',
                    touchDevices: false,
                    trigger: 'hover',
                    contentAsHTML: true,
                    position: 'top',
                    interactive: true,
                    maxWidth: 500,
                    minWidth: 100,
                    multiple: true,
                    content: $(this).attr('data-tooltipster-top')
                });
            });
        },

        initTabs: function (event){
            var current = this;
            if ($('ul.tabs').length) {
                $('ul.tabs').on('click', 'li:not(.current)', function() {
                    $(this).addClass('current').siblings().removeClass('current').parents('.tabs-wrap').find('.tab-box').eq($(this).index()).fadeIn(150).siblings('div.box').hide();
                    current.initChosen();
                    current.checkBiggestText();
                });
                this.initTabsAnchor();;
            }
        },

        initTabsAnchor: function() {
            var anchor = window.location.hash;
            if (anchor != "" && anchor != "#") {
                $('.tabs a[href=' + anchor + ']').closest('li').trigger('click');
            }
        },

        initOpenHiddenBlock: function() {
            var $obj = this;
            $(document).on('click', '.open-hidden-block', function() {
                var selector = $(this).parent().find('.hidden-block'),
                    current = $(this),
                    $icon = (current.is('[data-icon]')) ? $('.' + current.attr('data-icon')) : current.find('.fa');

                if (selector.is(':visible')) {
                    if (current.attr('callback') && current.attr('callback') == 'hide') {
                        current.slideUp(function() {
                            selector.slideUp();
                        });
                    } else {
                        selector.slideUp();
                    }

                    $icon.removeClass('fa-angle-up').addClass('fa-angle-down');
                }
                else {
                    if (current.attr('callback') && current.attr('callback') == 'hide') {
                        current.slideUp(function() {
                            selector.slideDown();
                        });
                    } else {
                        selector.slideDown();
                    }
                    $obj.initChosen();
                    $icon.removeClass('fa-angle-down').addClass('fa-angle-up');
                }
                return false;
            });
        },

        menuStartup: function() {
            var $sub = $('li.sub');
            $sub.children('a').click(function(event){
                event.stopPropagation();
                var $this = $(this);
                var $ul = $this.next();
                var isVisible = $ul.is(':visible');
                // находим все подменю которые видны и скрываем их
                var $sub = $('li.sub');
                $sub.find('ul').hide();
                $sub.children('a').removeClass('active');
                if (!isVisible) {
                    $this.addClass('active');
                    $ul.show();
                }
            });

            $sub.find('ul').click(function(event){
                event.stopPropagation();
            });

            $('body').click(function(){
                // находим все подменю которые видны и скрываем их
                var $sub = $('li.sub');
                $sub.find('ul').hide();
                $sub.children('a').removeClass('active');
            });
        },

        updateManagerHeader: function() {
            $.get(
                '/manager',
                {},
                function(data) {
                    $('#managerHeader').html(data.html);
                },
                'json'
            )
                .always(function() {
                    window.setTimeout(Ready.updateManagerHeader, 10*60*1000);
                });
        },

        updateTicketCount: function() {
            $.get(
                '/ticket/count',
                {},
                function(data) {
                    var $count = $('#supportTicketCount');
                    var aTicketNew = data['aTicketNew'];
                    $count.attr('data-count', aTicketNew.length);

                    if (aTicketNew.length > 0) {
                        $count.html('(+' + aTicketNew.length + ')');
                    }
                    else {
                        $count.html('');
                    }
                    for (var i=0; i<aTicketNew.length; i++) {
                        $('.ticket-title[data-idTicket="' + aTicketNew[i] + '"]').css('font-weight', 'bold');
                    }
                },
                'json'
            ).fail(function() {
                    if (console) {
                        console.log('Fail on ajax to get count of tickets');
                    }
                }).always(function() {
                    window.setTimeout(function() {
                        Ready.updateTicketCount();
                    },60*1000);
                });
        },

        initFixedBtn: function() {
            if ($('.js_fixed_btn').length) {
                var current = $('.js_fixed_btn'),
                    obj = this;

                obj.cssFixedBtn.left = current.offset().left.toString() + 'px';
                obj.cssFixedBtn.width = current.outerWidth().toString() + 'px';
                obj.topFixedBtn = current.offset().top;

                this.checkFixedBtn(current);
                $(window).scroll(function() {
                    obj.checkFixedBtn(current);
                });
            }
        },

        cssFixedBtn: {
            'position': 'fixed',
            'bottom': '10px',
            'z-index': '2',
            'left': '',
            'width': ''
        },

        topFixedBtn: 0,

        checkFixedBtn: function(current) {
            var obj = this,
                t = obj.topFixedBtn;
            if (($(window).scrollTop() + $(window).height() > t) && (current.css('position') == 'fixed')) {
                current.attr('style', '').removeClass('notransition opacity50');
            }
            else if (($(window).scrollTop() + $(window).height() < t) && (current.css('position') != 'fixed')) {
                current
                    .addClass('notransition opacity50')
                    .css(obj.cssFixedBtn);
                setTimeout(function () {current.removeClass('notransition')}, 1);
            }
        },

        reInitFixedBtn: function() {
            var selector = $('.js_fixed_btn');
            if (selector.length) {
                selector.attr('style', '').removeClass('notransition opacity50');
                this.topFixedBtn = selector.offset().top;
                this.checkFixedBtn(selector);
            }
        },

        initFakeSelect: function() {
            var current = this;
            $('.js-fake-select[data-fake]').on('click', function() {
                var blockAttr = $(this).attr('data-fake'),
                    block = $('.js-fake-select-block[data-fake=' + blockAttr +']');
                if (block.length) {
                    if (!block.is(':visible')) {
                        current._hideFakeBlocks();

                        block.show();
                        $(this).addClass('active-block');
                        current.initChosen();
                    } else {
                        block.hide();
                        $(this).removeClass('active-block');
                    }
                    return false;
                }

            });

            this._updateCountValuesFakeBlock($('.js-fake-select-block'));

            $('.js-fake-select-block select').on('change', function() {
                var block = $(this).closest('.js-fake-select-block');
                current._updateCountValuesFakeBlock(block);
            });

            $(document).on('click', function(event) {
                current._hideFakeBlocks();
            });

            $('.js-fake-select-block').on('click', function(event) {
                event.stopPropagation();
                return true;
            })
        },

        _hideFakeBlocks: function() {
            var sfb = $('.js-fake-select-block:visible');
            if (sfb.length) {
                sfb.hide();
                $('.js-fake-select[data-fake=' + sfb.attr('data-fake') + ']').removeClass('active-block');
            }
        },

        _updateCountValuesFakeBlock: function(blocks) {
            blocks.each(function() {
                var block = $(this),
                    s = block.find('select'),
                    result_block = $('.fake-select[data-fake=' + block.attr('data-fake') + '] .count'),
                    c = 0;

                s.each(function() {
                    $(this).find('option:selected').each(function() {
                        if ($(this).val() != "") {
                            c += 1;
                        }
                    });
                });

                if (c != 0) {
                    result_block.text("(" + c + ")");
                } else {
                    result_block.text("");
                }
            });
        },

        initScrollbar: function() {
            $('.scrollbar-inner').scrollbar();
        },

        initShowBlock: function() {
            $('[data-show-block]').on('change', function() {
                var attr = $(this).attr('data-show-block');
                if (this.checked) {
                    $(attr).show();
                } else {
                    $(attr).hide();
                }
            });
        },

        initBiggestText: function() {
            $(document).on('click', '.js_open_biggest_text', function() {
                var current = $(this),
                    bt = current.siblings('.js_biggest_text');
                current.hide();
                bt.addClass('biggest-text-show');
                bt.children('.js_biggest_text_gradient').hide();
                current.siblings('.js_close_biggest_text').show();
                return false;
            })
            $(document).on('click', '.js_close_biggest_text', function() {
                var current = $(this),
                    bt = current.siblings('.js_biggest_text');
                current.hide();
                bt.removeClass('biggest-text-show');
                bt.children('.js_biggest_text_gradient').show();
                current.siblings('.js_open_biggest_text').show();
                return false;
            });

            this.checkBiggestText();
        },

        checkBiggestText: function() {
            $.each($('.js_biggest_text:visible'), function() {
                var current = $(this),
                    optionHeight = current.height(),
                    optionScrollHeight = current.prop('scrollHeight');

                if (current.parent('.offer-news').length) {
                    var previousCss  = $('.offer-news').attr("style");
                    $('.offer-news').css({
                        position:   'absolute',
                        visibility: 'hidden',
                        display:    'block'
                    });
                    optionHeight = current.height();
                    optionScrollHeight = current.prop('scrollHeight')

                    $('.offer-news').attr("style", previousCss ? previousCss : "");
                }

                if (optionScrollHeight <= (optionHeight+30)) {
                    current.children('.js_biggest_text_gradient').hide();
                    current.siblings('.js_open_biggest_text').hide();
                    current.addClass('biggest-text-show');
                }
            });
        },

        initFileUpload: function() {
            $('.inputfile').on('change', function(event) {
                var fileName = event.target.value.split( '\\' ).pop(),
                    reader = new FileReader(),
                    current = $(this);

                reader.onload = function(){
                    var block = current.siblings('.preview');
                    block.find('img').remove();
                    block.prepend('<img src="' + reader.result + '"/>');
                    block.find('.js-delete-preview').show();

                };
                reader.readAsDataURL(event.target.files[0]);

                if (fileName) {
                    $('label[for=' + $(this).attr('id') + '] span').text(fileName);


                }
            });
            $('.file_upload .js-delete-preview').on('click', function() {
                $(this).hide().siblings('img').remove();
                $(this).closest('.preview').siblings('.inputfile').val('');
                $(this).closest('.preview').siblings('label').find('span').text('Выбрать файл');
                return false;
            });
        },

        initCopyHtml: function() {
            var obj = this;
            $('[data-copy]').on('click', function(event) {
                event.stopPropagation();

                var $current = $(this);
                $selector = $('.' + $current.attr('data-copy')),
                    $selector_paste = $('.' + $current.attr('data-paste'));
                $selector.clone().prependTo($selector_paste);
                $selector_paste.find('.' + $current.attr('data-copy') + ':first').removeClass($current.attr('data-copy')).show();
                obj.initChosen();
                return false;
            });

            $(document).on('click', '.js-delete-row', function() {
                $(this).closest('.row').remove();
                return false;
            });
        }
    });

})(jQuery, Ready || {});

$(document).ready(function(){
    Ready.init();
});