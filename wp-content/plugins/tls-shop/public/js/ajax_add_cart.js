jQuery(document).ready(function($){
	//console.log('ajax_add_cart');
	$('#add_to_cart').click(function(e){
		
		var dataObj = {
					"action"	: "add_to_cart",
					"value"		: $(this).attr('product-id'),
					"security"	: security_code,
				};
		console.log(dataObj.value);
		$.ajax({
			url			: ajaxurl,
			type		: "POST",
			data		: dataObj,
			dataType	: "text",
			success		: function(data, status, jsXHR){
							console.log(data);
							$(".detail-cart span.number_product").text(data);
							
							$(".detail-cart .alert-cart").show('slow');
						}
		});
	});
});