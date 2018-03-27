$( document ).ready(function() {
    /*При клике на размер менять артикул*/
    $('.product-item-scu-item-text-block').on('click', function() {
        $("#ID-article").text("ID "+ $(this).find('.product-item-scu-item-text').attr('data-article'));
    });
    /*----------------------------------*/
    $(this).find('.product-item-scu-item-text').attr('data-article')

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
});
