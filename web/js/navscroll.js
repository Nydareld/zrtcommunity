jQuery(document).ready(function() {
  var navpos = jQuery('#nav2').offset();
  console.log(navpos.top);
  jQuery(window).bind('scroll', function() {
      if (jQuery(window).scrollTop() > navpos.top-40) {
          jQuery('#nav2').addClass('navbar-fixed-top');
       }
       else {
           jQuery('#nav2').removeClass('navbar-fixed-top');
       }
    });
});
