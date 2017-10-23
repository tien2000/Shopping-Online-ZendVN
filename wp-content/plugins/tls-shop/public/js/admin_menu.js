jQuery(document).ready(function($){
	console.log('admin-menu.js');
	var elemt = "#toplevel_page_tls-sp-manager";
	$(elemt).removeClass('wp-not-current-submenu')
			.addClass('wp-has-current-submenu wp-menu-open');
	$(elemt + ' > a').removeClass('wp-not-current-submenu')
			.addClass('wp-has-current-submenu wp-menu-open');
	
	var taxonomy = getURLParameter('taxonomy');
	var post_type = getURLParameter('post_type');
	if(post_type == 'tsproduct'){
		if(taxonomy == 'ts-category'){
			var url ='edit-tags.php?taxonomy=ts-category&post_type=tsproduct';
			$(elemt + " a[href='" + url + "']").addClass('current').parent().addClass('current');
		}
		
		if(taxonomy == undefined){
			var url ='edit.php?post_type=tsproduct';
			$(elemt + " a[href='" + url + "']").addClass('current').parent().addClass('current');
		}
	}
	console.log(taxonomy);
	
});

function getURLParameter(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++){
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam){
            return sParameterName[1];
        }
    }
}