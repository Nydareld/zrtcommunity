$(document).ready(function() {
  var navpos = $('#nav2').offset();
  console.log(navpos.top);
    $(window).bind('scroll', function() {
      if ($(window).scrollTop() > navpos.top-40) {
        $('#nav2').addClass('navbar-fixed-top');
       }
       else {
         $('#nav2').removeClass('navbar-fixed-top');
       }
    });
});
