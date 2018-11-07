$(document).ready(function() {
  
  $("#sidebar_menu").find("a").click(function() {

    var $li = $(this).parent();

    if ($li.is('.active')) {
      $li.removeClass('active active-sm');
      $('ul:first', $li).slideUp(function() {

      });
    } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
              $SIDEBAR_MENU.find('li').removeClass('active active-sm');
              $SIDEBAR_MENU.find('li ul').slideUp();
            }
            
            $li.addClass('active');

            $('ul:first', $li).slideDown(function() {

            });
          }
        }); 

});