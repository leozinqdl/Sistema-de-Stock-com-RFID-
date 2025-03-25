	</div>
</div>
<script>
  setTimeout(() => {
    $(".fancybox-thumbs-img").slick({
      dots: true,
      infinite: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      adaptiveHeight: true,
      variableWidth: true,
    });
  }, 50);
  $(document).on('ready', function () {
    $('body').on('click', '.fancybox-print-img', function () {
      var htmldiv = $("div.fancybox-image-wrap:visible").html();
      var mode = "iframe";
      var print = '<div class="print-img">' + htmldiv + '</div>';
      var options = {
        mode: mode
      }
      $(print).printArea(options);
    });
 

  });
  var rotation = 0;
    jQuery.fn.rotate = function (degrees) {
      $("div.fancybox-image-wrap:visible img").css({
        'transform': 'rotate(' + degrees + 'deg)',
        'height': '100%'
      });
    };
    $('body').on('click', '.fancybox-girar-img', function () {
      var imgurl = $("div.fancybox-image-wrap:visible img").attr('src');
      var matrix = $("div.fancybox-image-wrap:visible img").css('transform');
      if (matrix !== 'none') {
        var values = matrix.split('(')[1].split(')')[0].split(',');
        var a = values[0];
        var b = values[1];
        var rotation = Math.round(Math.atan2(b, a) * (180 / Math.PI));
      } else {
        var rotation = 0;
      };
      if (rotation == -90) {
        rotation += 90;
        $("div.fancybox-image-wrap:visible img").rotate(rotation);
        $.post("/refectory/index/saveimg", {imgurl_post:imgurl,rotated_post: rotation},function(data){
          $('.imglist__img').each(function(){
            imgSRC= $(this).attr('src');
            $(this).attr('src',imgSRC + '?' );
          });
        });
      } else {
        rotation += 90;

        $("div.fancybox-image-wrap:visible img").rotate(rotation);
        $.post("/refectory/index/saveimg", {imgurl_post:imgurl,rotated_post:rotation}, function(data){
          $('.imglist__img').each(function(){
            imgSRC= $(this).attr('src');
            $(this).attr('src',imgSRC + '?');
          });
        });
      }
    });
</script>