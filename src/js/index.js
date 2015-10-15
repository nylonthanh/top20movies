var onPostHover = function () {
    $('div.top-movie>div.wrapper').on('mouseover', function (obj) {
        $(this).parent().find('.info').css('opacity', 0);
    });

    $('div.top-movie>div.wrapper').on('mouseout', function (obj) {
        $(this).parent().find('.info').css('opacity', 1);
    });

};

var onPosterClick = function () {
    $('div.top-movie>div.wrapper').on('click', function() {
        $('.overlay').toggleClass('hidden');
        $('#movie-details').toggleClass('hidden');

        var movieId = $(this).parent().closest('div').data('id');
        $.get( 'ajax/get_movie_details.php',
            {
                'movieId' : movieId
            },
            function( data ) {
                $( '#movie-details' ).html( data );
            }
        );
    });

    $('.overlay').on('click', function() {
        $('.overlay').toggleClass('hidden');
    });
};


$(document).ready(function(){
    onPostHover();
    onPosterClick();
});


