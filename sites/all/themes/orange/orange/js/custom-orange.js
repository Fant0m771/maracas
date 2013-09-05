(function ($) {
  //1. left block last advice   
  $(document).ready(function() {
      $(".view_block_last_advice").hover(function() {      
          $('.last_advice_block_pop_up', this).css({
            'display': 'block'
          });             
      },
      function() {
        $('.last_advice_block_pop_up', this).css({
          'display': 'none'
        });
      } 
      );
      
      /*if ( $.browser.msie && $.browser.version <= 7 ) { } else { 
          $(".menu-601, #block-views-materials-category-block-1").hover(
            function() {
                var menu601 = $("#block-views-materials-category-block-1");
                menu601.css({"z-index": "1000", "display": "block"});
            },
            function() {
              $("#block-views-materials-category-block-1").css({"z-index": "0", "display": "none"});
            }
          );
      } */
  // End last advice
  
  //2. if height sidebar < main content add height to sidebar    
      if ($("#sidebar").height() < $("#main").height()) {
        $("#sidebar").height($("#main").height());
      }
  // End add height
   
  
  //3. Add move to primary items front page 
   if ($("body").hasClass("front")) {
     $("#block-views-priority-items-block .views-row").mouseover(function() {
       $(this).animate({
         marginTop: "0"
       },200);
     });
     $("#block-views-priority-items-block .views-row").mouseleave(function() {
       $(this).animate({
         marginTop: "140px"
       },200);
     });
   // End move to primary items front page 
     
  //4. Add move to bottn on banner fron page     
     $("#block-views-image-rotator-block").mouseover(function() { 
       $(".views-slideshow-cycle-main-frame-row-item .title").animate({
         marginTop: "220px"        
       }, 300);
     });
     $("#block-views-image-rotator-block").mouseleave(function() {
       $(".views-slideshow-cycle-main-frame-row-item .title").animate({
         marginTop: "263px"        
       }, 300);
     });
   } 
  // End move to bottn on banner fron page 
    
  });
    
})(jQuery);


var topYloc = null;
/*TopLink.css("display", "none");
if (topYloc+scrollTop < 420) {
    jQuery("#toplink").animate({opacity: "0"}, 300);
  }
  else if(topYloc+scrollTop > 500)  {
    jQuery("#toplink").animate({opacity: "1"}, 300);
  }
*/

jQuery(window).scroll(function () {
  var scrollTop = jQuery(document).scrollTop();
  scrollTop = parseInt(scrollTop);
  var offset = topYloc+scrollTop+"px";  
  jQuery("#toplink").animate({top:offset},{duration:700,queue:false});  
});

jQuery(document).ready(function(){
    jQuery("#container").prepend("<dev id='toplink' style='top:375px;'><a href='#header'></a></div>");
    
    jQuery('a[href*=#header]').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var $target = jQuery(this.hash);
        $target = $target.length && $target || jQuery('[name=' + this.hash.slice(1) +']');
        if ($target.length) {
        var targetOffset = $target.offset().top;
        targetOffset = targetOffset - 35;
        jQuery('html,body').animate({scrollTop: targetOffset}, 700);
        return false;
    }
  }
 });
 
 var TopLink = jQuery("#toplink");
 window.onresize = function() {
   if (jQuery('html,body').width() < 1215) {
     TopLink.css("display", "none"); 
   }
   else {
     TopLink.css("display", "block");
   }
 }
 
  topYloc = parseInt(jQuery("#toplink").css("top").substring(0,jQuery("#toplink").css("top").indexOf("px")));
});
