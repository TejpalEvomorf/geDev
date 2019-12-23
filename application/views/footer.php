</div><!--.site-wrapper container-->

<script>

$(document).ready(function(){

	
	$('#iframe-header').load(function(){
			var iframe = $('#iframe-header').contents();
			
			   iframe.find("#responsive-menu-btn").click(function(){
               var iframeElement = document.getElementById("iframe-header");
			   if(iframe.find("#navbarResponsive") .hasClass('show'))
				   var newHeight = parseInt($('#iframe-header').height()) - parseInt(495);
			   else
				   var newHeight = parseInt($('#iframe-header').height()) + parseInt(495);
			   iframeElement.style.height =  newHeight+ 'px';
		});
		
	});
	
});
</script>

<iframe class="iframe-footer" src="<?=site_url().'/form/footer_iframe'?>"></iframe> 
</body>
</html>


<style>
iframe.iframe-footer {
    width: 100%;
    border: 0;
    height: 310px;
    margin-bottom: -5px;
}

@media (max-width:1199px) {
iframe.iframe-footer {
    height: 320px;
}

 }
 
 @media (max-width:991px) {
iframe.iframe-footer {
    height: 256px;
}

 }
 
  @media (max-width:767px) {
iframe.iframe-footer {
    height: 691px;
}

 }

</style>