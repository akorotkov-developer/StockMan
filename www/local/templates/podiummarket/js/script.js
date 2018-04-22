$( document ).ready(function() {

    /*При клике на размер менять артикул и старую цену*/
    $('.product-item-scu-item-text-block').on('click', function() {
        $("#ID-article").text("ID "+ $(this).find('.product-item-scu-item-text').attr('data-article'));
    });

    $('.product-item-scu-item-text-block').on('click', function() {
        $("#old-price").html('<del class="text-dark-gray">' + $(this).find('.product-item-scu-item-text').attr('data-oldPrice') + '</del>');
        $("#current-price").html($(this).find('.product-item-scu-item-text').attr('current-price'));
    });
    /*----------------------------------*/
    $(this).find('.product-item-scu-item-text').attr('data-article');

    var flag = 0;
    $('.js-apply').click(clickCheckbox);


    function clickCheckbox(){
        var num = new Array();

        var j = 0;
        $('#sortbox :checkbox:checked').each(function() {
            num[j] = $(this).attr('value');
            j++;
        });

        if(num.length > 1){
            flag  = 1;
        }else{
            flag =  0;
        }
        setAttr('sort='+num[0],'method=asc');
    }

    /*Добавить GetПараметры в ссфлку*/
    function setAttr(prmName,val){
        var res = '';
        var d = location.href.split("#")[0].split("?");
        var base = d[0];
        var query = d[1];
        if(query) {
            var params = query.split("&");
            for(var i = 0; i < params.length; i++) {
                var keyval = params[i].split("=");
                if(keyval[0] != prmName) {
                    res += params[i] + '&';
                }
            }
        }
        res += prmName + '=' + val;
        window.location.href = base + '?' + res;
        return false;
    }

    $(document).on('change','.x-smart-filter-header', function() {
        var $el = $(this),
            nameEl = $el.prop('name'),
            nameElHeader = '#h_' + nameEl;

        if ($el.is(':checked')) {
            $(document).find(nameElHeader).prop('checked', true);
        } else {
            $(document).find(nameElHeader).prop('checked', false);
        }
    });
    $(document).on('change','.x-smart-filter', function() {
        var $el = $(this),
            nameEl = '#' + $el.prop('name');

        if ($el.is(':checked')) {
            $(document).find(nameEl).prop('checked', true);
        } else {
            $(document).find(nameEl).prop('checked', false);
        }
    });
    $(document).on('change','.x-smart-filter-header-input', function() {
        var $el = $(this),
            val = $el.val(),
            nameEl = '#h_' + $el.prop('name');
        $(document).find(nameEl).val(val);
        $(document).find(nameEl).trigger('input');
    });
    $(document).on('change','.x-smart-filter-input', function() {
        var $el = $(this),
            val = $el.val(),
            nameEl = '#' + $el.prop('name');
        $(document).find(nameEl).val(val);
        $(document).find(nameEl).trigger('input');
    });


    if ($(document).find('.x-box-discaunt').length > 0) {
        var $xBoxDiscaunt = $(document).find('.x-box-discaunt').html();

        $xBoxDiscaunt = $xBoxDiscaunt.replace('id="', 'id="h_');
        $xBoxDiscaunt = $xBoxDiscaunt.replace('for="', 'for="h_');
        $xBoxDiscaunt = $xBoxDiscaunt.replace('x-smart-filter-header', 'x-smart-filter');
        $(document).find('.x-box-discaunt-header').html($xBoxDiscaunt);
    }



    $('.check_men').on('click', function() {
        $(".check_men").each(function (index, el){
            if ($(el).attr("checked") == "checked") {
                $(el).removeAttr("checked")
            } else {
                $(el).attr("checked","checked");
            }
        });
    });

    $('.check_women').on('click', function() {
        $(".check_women").each(function (index, el){
            if ($(el).attr("checked") == "checked") {
                $(el).removeAttr("checked")
            } else {
                $(el).attr("checked","checked");
            }
        });
    });

    $('.check_kids').on('click', function() {
        $(".check_kids").each(function (index, el){
            if ($(el).attr("checked") == "checked") {
                $(el).removeAttr("checked")
            } else {
                $(el).attr("checked","checked");
            }
        });
    });

    var ua = window.navigator.userAgent.toLowerCase(),
        is_ie = (/trident/gi).test(ua) || (/msie/gi).test(ua);
    if (is_ie) {
        $(".close-button").on('click', function() {
            $(".directory").toggleClass("js-open");
        });
    }

    /*Расшарить в соц.сетях*/
    $('.btn-vk').on('click', function() {
        // действия, которые будут выполнены при наступлении события...
        $(document).find('.b-share-btn__vkontakte').find('.b-share-icon_vkontakte').trigger('click');
    });
    $('.btn-facebook').on('click', function() {
        // действия, которые будут выполнены при наступлении события...
        $(document).find('.b-share-btn__facebook').find('.b-share-icon_facebook').trigger('click');
});
    $('.btn-twitter').on('click', function() {
        // действия, которые будут выполнены при наступлении события...
        $(document).find('.b-share-btn__twitter').find('.b-share-icon_twitter').trigger('click');
    });
    /*---------------------*/

    /*Увеличить подложку меню*/
    $('.menu-base__item').on('click', function() {
        var element, selector;
        element = $(this).find(".menu-base__link.hide-for-small-only").attr('data-toggle');
        if (element) {
            selector = "#"+element;
            if ($(selector).find(".trousers").height() > 376) {
                $(".menu-base.text-left.medium-text-center").height($(selector).find(".trousers").height());
            }
        }
    });
    /*menu-base text-left medium-text-center*/
    $('.subheader__back').on('click', function() {
        var element;
        element = $(".menu-base.text-left.medium-text-center");
        if (element) {
            if (element.height() > 376) {
                $(".menu-base.text-left.medium-text-center").height(376);
            }
        }
    });
    /*----------------------------------------*/
    $('.subheader__back').on('click', function() {
        var element;
        element = $(".menu-base.text-left.medium-text-center");
        if (element) {
            if (element.height() > 376) {
                $(".menu-base.text-left.medium-text-center").height(376);
            }
        }
    });

    if ($("a.accordion-title[role='tab']").length > 0) {
        $("a.accordion-title[role='tab']").on('click', function () {
            //$('.slick-list.draggable').outerHeight($('.skirt__info').outerHeight() - 30);
            $('.slick-list.draggable').animate({ "height": $('.skirt__info').outerHeight() - 30 }, 500 );
        });
        setTimeout(function(){
            if ($(document).width() > 1270) {
                if ($(".skirt__info").outerHeight() > $('.slick-list.draggable').outerHeight()) {
                    $('.slick-list.draggable').outerHeight($('.skirt__info').outerHeight() + 50);
                }
            }
        }, 100);
    }

    $( window ).resize(function() {
        if ($(document).width() > 1270) {
            if ($(".skirt__info").outerHeight() > $('.slick-list.draggable').outerHeight()) {
                $('.slick-list.draggable').outerHeight($('.skirt__info').outerHeight() + 50);
            }
        }
    });

    /*Максимальная высота для блоков*/
    var mh = 0;
    $("div[data-entity='items-row']").each(function () {
        var h_block = parseInt($(this).height());
        if(h_block > mh) {
            mh = h_block;
        };
    });
    $("div[data-entity='items-row']").each(function() {
        $(this).height(mh);
    });
    /*------------------------------*/

    console.log($(document).width());
});
