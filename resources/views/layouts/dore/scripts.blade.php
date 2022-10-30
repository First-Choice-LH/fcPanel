<script type="text/javascript">

    $(document).ready(function(){
        var sorter = '<span class="sorter"><i data-sort="asc" class="sort_arrow fa fa-caret-up"></i><i data-sort="desc" class="sort_arrow fa fa-caret-down"></i></span>';

        $(".sortable_table").each(function(){
            $(this).find('thead th').each(function(){
                var attr = $(this).attr('data-col');
                if (typeof attr !== typeof undefined && attr !== false) {
                   $(this).append(sorter);
                }
                
            });
        });
    });

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

    $('body').on('click','.sort_arrow', function(){

        var orderby = $(this).closest('th').attr('data-col');
        var sortby = $(this).attr('data-sort');
        var url = location.href;

        if(url.indexOf('?') > -1){
            if (url.indexOf('orderby') > -1) {
                var currentorderby = getUrlParameter('orderby');
                url = url.replace("orderby="+currentorderby, "orderby="+orderby);
            }else{
                url = url+'&orderby='+orderby;
            }
            if (url.indexOf('sortby') > -1) {
                var currentorderby = getUrlParameter('sortby');
                url = url.replace("sortby="+currentorderby, "sortby="+sortby);
            }else{
                url = url+'&sortby='+sortby;
            }
        }else{
            url = url+'?orderby='+orderby+'&sortby='+sortby;
        }
        window.location = url;
    });
</script>