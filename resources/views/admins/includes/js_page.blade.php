


<script src=" {{ asset('jquery/jquery.min.js') }} "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>

<script src=" {{ asset('js/app.js') }} "></script>

<!-- js -->

<script>
    $(document).ready(function() {
        $('body').on('click', '.side-navigation .showList', function(event) {
            event.preventDefault();
            $node = $(this).children()[1];
            $($node).slideToggle();
        })
        $("body").on('click', '.side-navigation li .child-list li', function(event) {
            event.stopPropagation();
            $(".side-navigation .active .child-list").find('.active').removeClass("active");
            $(this).addClass('active');
        })
    })
</script>