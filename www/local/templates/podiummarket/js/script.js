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
});
