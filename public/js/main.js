
$(document).ready(function() {
    $('.modal-dialog').css({'padding-top':($(window).height()*16/100)});
    $('.main-rate>i').on('click',function(e){
        var trip_id = $(this).attr('trip-id');
        var rate    = $(this).attr('rate-value');
        var token   = 'JU49PhzgnQaJME0znLlrlbm30iDsEkeLt5IZUXRB';
        var newHTML ='';
        if($(this).parent('.main-rate').hasClass('rate-it'))
        {
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1/saf_rest/public/tripDetails/rate",
                dataType: "json",
                data: {'trip_id': trip_id, 'rate': rate, '_token': token},
                success: function (data) {
                    if (data.success) {
                        data.newRate;
                        $('#rate-trip-id_' + trip_id).removeClass('rate-it');

                        $('#rate-trip-id_' + trip_id ).children('i').removeClass('fa').addClass('far');
                        $('#rate-trip-id_' + trip_id + ' i:nth-child(' + 3 + ')').attr('data-micron','').siblings().attr('data-micron','');


                        for (var i = 1; i <= (data.newRate + 1); i++) {
                            $('#rate-trip-id_' + trip_id + ' i:nth-child(' + i + ')').addClass('fa');
                        }


                    } else {

                    }
                }
            });
        }

    });

    //lod more posts
    var page = 1;
    $(function() {
        /* this is only for demonstration purpose */
        scroll_enabled = true;
        function loadMoreData(page){
            $('.ajax-load').show();

            $.ajax({
                type: "GET",
                url: "http://127.0.0.1/saf_rest/public/pagination"+"?page="+page,
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        if(data.posts.length >0){
                            $("#posts-container").append(data.posts);
                            console.log(data.pageNumber);
                            $('.ajax-load').hide();
                            scroll_enabled = true;

                            return;
                        }
                        //alert('no more');

                        $('.ajax-load').hide();

                    } else {
                        alert('server not responding...');
                    }
                }
            });
        }

        $(window).bind('scroll', function() {
            if (scroll_enabled) {

                /* if 90% scrolled */
                if($(window).scrollTop() >= ($('#posts-container').offset().top + $('#posts-container').outerHeight()-window.innerHeight)*0.9) {

                    /* load ajax content */
                    scroll_enabled = false;
                    page++;
                    loadMoreData(page);

                }
            }

        });

    });
});

