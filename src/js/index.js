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

        var movieId = $(this).parent().closest('div').data('id');
        var allMovieDetailArray = $('#movie-details .container .row');
        var numMovies = allMovieDetailArray.length;
        for (i = 0; i < numMovies; i++) {
            if ($(allMovieDetailArray[i]).data('id') == movieId) {
                scrollTo(0,0);
                $(allMovieDetailArray[i]).toggleClass('hidden');
                $(allMovieDetailArray[i]).toggleClass('currentMovieDetails');
                return true;
            }
        }
    });

    $('.overlay').on('click', function() {
        hideMovieDetails();
    });

    $('#movie-details .container .row').on('click', function() {
        hideMovieDetails();
    });

};

var hideMovieDetails = function() {
    $('.overlay').toggleClass('hidden');
    var findCurrentMovie = $('#movie-details .container').find('.currentMovieDetails')
    $(findCurrentMovie).toggleClass('currentMovieDetails');
    $(findCurrentMovie).toggleClass('hidden');
};

//docuemnt ready
$(document).ready(function(){
    onPostHover();
    onPosterClick();
});
