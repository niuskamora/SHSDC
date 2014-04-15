$(window).load(function(){
$.asm = {};
$.asm.panels = 1;

function sidebar(panels) {
    $.asm.panels = panels;
    if (panels === 1) {
      $('#content').removeClass('span12');
      $('#content').addClass('span8');
      $('#sidebar').show();
      $('html, body').animate({scrollTop:129});
    } else if (panels === 2	) {
      $('#content').removeClass('span8 no-sidebar');
      $('#content').addClass('span12');
      $('#sidebar').hide();
      $('html, body').animate({scrollTop:129});
    $('#mapCanvas').width($('#mapCanvas').parent().width());
    $('#mapCanvas').height($(window).height() - 50);
    $('#sidebar').height($(window).height() - 50);
    return google.maps.event.trigger($.asm.theMap, 'resize');
    }
};

$('#toggleSidebar').click(function() {
  if ($.asm.panels === 1) {
    $('#toggleSidebar i').addClass('arrow-right');
    $('#toggleSidebar i').removeClass('arrow-left');
    return sidebar(2);
  } else {
    $('#toggleSidebar i').removeClass('arrow-right');
    $('#toggleSidebar i').addClass('arrow-left');
    return sidebar(1);
  }
});

$(function() {
  $.asm.theMap = new google.maps.Map(document.getElementById('mapCanvas'));
});
});//]]>  
