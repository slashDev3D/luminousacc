/**
 * @author https://www.cosmosfarm.com/
 */

function cosmosfarm_simple_popup_close(obj){
	var parent = jQuery(obj).parents('.cosmosfarm-simple-popup-layout');
	jQuery(parent).hide();
}

function cosmosfarm_simple_popup_not_showing(obj, popup_id){
	cosmosfarm_simple_popup_close(obj);
	
	jQuery.post(cosmosfarm_simple_popup_settings.ajax_url, {action:'cosmosfarm_simple_popup_not_showing', popup_id:popup_id, security:cosmosfarm_simple_popup_settings.ajax_security}, function(res){
		
	});
}