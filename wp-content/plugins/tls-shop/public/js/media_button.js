jQuery(function($){
	$(document).ready(function(){		
		$('#tls-sp-tsproduct-button').click(open_media_window);		
		tls_sp_remove_image('#tls-sp-tsproduct-show-images');
	});
	
	function open_media_window() {
		console.log('media_button');		
		if(this.window === undefined){
			this.window = wp.media({
					title: 'Insert pictures for product',
					library: {type: 'image'},
					multiple: true,
					button: {text: 'Insert pictures'}				
				});
			var self = this;
			this.window.on('select', function(){
				var imgs = self.window.state().get('selection').toJSON();
				tls_sp_insert_image('#tls-sp-tsproduct-show-images', imgs);		
				tls_sp_remove_image('#tls-sp-tsproduct-show-images');			
			});
		}
		this.window.open();
		return false;
	}	
	
	function tls_sp_remove_image(img_content){
		console.log('tls_sp_remove_image');		
		$(img_content + ' a.remove-img').on("click", function(){			
			var elemt;
			elemt = $(this).parents("div.content-img");
			$(elemt).fadeOut('slow',function(){
				$(this).remove();
			});
		});
	}
	
	//tls-sp-tsproduct-show-images
	function tls_sp_insert_image(img_content, imgs){
		if($(imgs).length > 0){
			$.each(imgs, function(key, obj){
				var imgUrl = obj.url;
				var newImg = '';
				console.log(imgUrl);
				
				newImg += '<div class="content-img">';
				newImg += '<img src="' + imgUrl + '" height="100" width="100">';
				newImg += '<div> <a class="remove-img">Remove</a> </div>';
				newImg += '<div class="div-ordering">';
				newImg += '<input type="text" value="1" class="ordering"';
				newImg += 'name="tls-sp-tsproduct-img-ordering[]">';
				newImg += '<input type="hidden" name="tls-sp-tsproduct-img-url[]"';
				newImg += 'value="' + imgUrl + '">';
				newImg += '</div>';
				newImg += '</div>';
				
				$(newImg).insertBefore(img_content + " .clr");
			});
		}
	}
});