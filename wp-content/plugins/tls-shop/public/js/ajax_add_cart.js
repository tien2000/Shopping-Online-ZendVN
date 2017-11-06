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
	
	//=================================
	// UPDATE CART
	//=================================
	$(".update-product").on('click', function(){
		var productID 	= $(this).attr('product-id');
		var price 		= $(this).attr('product-price');
		var quality		= $('#price-' + productID).val();
		
		var linkUpdate  = this
		
		var dataObj = {
				"action"	: "update_cart",
				"value"		: productID,
				"security"	: security_code,
				"price"		: price,
				"quality"	: quality
			};		
		console.log(dataObj);		
		$.ajax({
			url			: ajaxurl,
			type		: "POST",
			data		: dataObj,
			dataType	: "text",
			success		: function(data, status, jsXHR){
								console.log();
								$(linkUpdate).parent().prev().html(data);
								
								$("#tls_sp_cart_table .show-alert").removeClass()
																   .addClass("show-alert cart-update")
																   .html("Items updated");
								total();
								
							}
		});
	});	
	
	//=================================
	// TOTAL PRICE
	//=================================
	total();
	function total(){
		var total_pay = 0;
		
		console.log($("td.money-pay"));
		$("td.money-pay").each(function(index, obj){
			total_pay = total_pay + parseInt($(obj).text());
		});
		total_pay = accounting.formatMoney(total_pay, "$ ", 2, ".", ",");
		$("#total .pay").text(total_pay);
	}
});











