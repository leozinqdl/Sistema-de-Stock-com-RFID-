<audio id="audioSuccess" >
   <source src="<?=URL_BASE?>/public/mp3/success.mp3" type="audio/mp3" />
</audio>
<audio id="audioError" >
   <source src="<?=URL_BASE?>/public/mp3/error.mp3" type="audio/mp3" />
</audio>
</body>
</html>
<!-- START PRINT ÁREA -->
<script src="<?=URL_BASE?>/public/printarea/jquery.PrintArea.js"></script>
<link href="<?=URL_BASE?>/public/printarea/print.css" rel="stylesheet" type="text/css">
<!-- END PRINT ÁREA -->

<script src="<?=URL_BASE?>/public/js/slick/slick.js"></script> <!-- visualizador de fotos -->
<script>
    $('body').on("click", ".select-wrapper", function(){
        $("ul .input-field .dropDownsearch").focus();
    })

    var name_shortcut = $(".title_page").text();
    name_shortcut = name_shortcut+" "+$(".title_text").text();
	$(".nameShortcut").val(name_shortcut);

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

		let  pathname  =window.location.pathname ;
		 if(pathname  == "/stock/"){
		$(".back-header").hide();
		}else{
			$(".back-header").show();
		}
		// clone link messagens
		 $('.plus-itens').on('click', function(){
			 let n = $(".input-text-messages").length;
			 if(n < 5){
			$('.links_messages').append('<div class="input-field input-text-messages"><input id="link-'+(n + 1)+'" type="text"><label for="link-'+(n + 1)+'">Link</label><img class="minus-itens" alt="Inserir Item" title="Inserir Item" src="/refectory/public/img/layout/title-minus-img.png"/></div>');	 
			 }
			return;
			 
		 })
		 $('body').on('click', '.minus-itens', function(){
			 let n = $(".input-text-messages").length;
			$(this).parent().remove();
			 
		 })
		 
	  $('body').on('click', '.fancybox-print-img', function () {
		var htmldiv = $("div.fancybox-image-wrap:visible").html();
		var mode = "iframe";
		var print = '<div class="print-img">' + htmldiv + '</div>';
		var options = {
		  mode: mode
		}
		$(print).printArea(options);
		
			  });
   
   //WebChat
    	$(".heading-compose").click(function() {
    		$(".side-two").css({
    			"left": "0"
    		});
    	});
    	$(".newMessage-back").click(function() {
    		$(".side-two").css({
    			"left": "-100%"
    		});
    	});
			
   // focus select
		     $('.select-dropdown').on('click', function(){
				 console.log("TRRREEE");
		 
			 })
			 
		
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
<script>
// função q faz os itens do meu sairem ao passar mouse fora.
	function getTargetElement(elem){
		let parent = elem.nextSibling;
		var targetId = parent.querySelector("ul");
		let idTarget =  parent.id
		document.getElementById(idTarget).onmouseleave = function(){
			document.getElementById(idTarget).setAttribute("style","");
		}
	}

	// AUDIO

$(document).ready(function () {
audioSuccess = document.getElementById('audioSuccess');
audioError = document.getElementById('audioError');
ctrlAudio = {
	playSuccess: ()=> audioSuccess.play(),
	playError:() =>  audioError.play()
}
});
</script>
