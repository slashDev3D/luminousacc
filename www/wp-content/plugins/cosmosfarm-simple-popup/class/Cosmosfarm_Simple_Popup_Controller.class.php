<?php
/**
 * Cosmosfarm_Simple_Popup_Controller
 * @link https://www.cosmosfarm.com/
 * @copyright Copyright 2020 Cosmosfarm. All rights reserved.
 */
final class Cosmosfarm_Simple_Popup_Controller {
	
	public function __construct(){
		add_action('admin_post_cosmosfarm_simple_popup_save', array($this, 'popup_save'));
		add_action('wp_ajax_cosmosfarm_simple_popup_not_showing', array($this, 'popup_not_showing'));
		add_action('wp_ajax_nopriv_cosmosfarm_simple_popup_not_showing', array($this, 'popup_not_showing'));
	}
	
	/**
	 * 팝업 정보를 저장한다.
	 */
	public function popup_save(){
		if(current_user_can('manage_options') && isset($_POST['cosmosfarm-simple-popup-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-simple-popup-save-nonce'], 'cosmosfarm-simple-popup-save')){
			$_POST = stripslashes_deep($_POST);
			
			$popup_id = isset($_POST['simple_popup_id']) ? intval($_POST['simple_popup_id']) : '';
			$popup_title = isset($_POST['simple_popup_title']) ? sanitize_text_field($_POST['simple_popup_title']) : '';
			$popup_content = isset($_POST['simple_popup_content']) ? $_POST['simple_popup_content'] : '';
			
			$popup_top = isset($_POST['simple_popup_top'])&&$_POST['simple_popup_top'] ? sanitize_text_field($_POST['simple_popup_top']) : 0;
			$popup_left = isset($_POST['simple_popup_left'])&&$_POST['simple_popup_top'] ? sanitize_text_field($_POST['simple_popup_left']) : 0;
			$popup_width = isset($_POST['simple_popup_width']) ? sanitize_text_field($_POST['simple_popup_width']) : '';
			$popup_height = isset($_POST['simple_popup_height']) ? sanitize_text_field($_POST['simple_popup_height']) : '';
			$popup_background_color = isset($_POST['simple_popup_background_color']) ? sanitize_text_field($_POST['simple_popup_background_color']) : '';
			$popup_font_color = isset($_POST['simple_popup_font_color']) ? sanitize_text_field($_POST['simple_popup_font_color']) : '';
			$popup_active = isset($_POST['simple_popup_active']) ? sanitize_text_field($_POST['simple_popup_active']) : '';
			$popup_active_main = isset($_POST['simple_popup_active_main']) ? sanitize_text_field($_POST['simple_popup_active_main']) : '';
			
			$popup_roles = isset($_POST['simple_popup_roles']) ? sanitize_text_field($_POST['simple_popup_roles']) : '';
			$popup_permission_roles = isset($_POST['simple_popup_permission_roles']) ? $_POST['simple_popup_permission_roles'] : array();
			$popup_permission_roles = array_map('sanitize_text_field', $popup_permission_roles);
			
			$popup = new Cosmosfarm_Simple_Popup($popup_id);
			if(!$popup->ID()){
				$popup->create(get_current_user_id(), array('title'=>$popup_title, 'content'=>$popup_content));
			}
			else{
				$popup->update(array('title'=>$popup_title, 'content'=>$popup_content));
			}
			
			$popup->set_top($popup_top);
			$popup->set_left($popup_left);
			$popup->set_width($popup_width);
			$popup->set_height($popup_height);
			$popup->set_background_color($popup_background_color);
			$popup->set_font_color($popup_font_color);
			$popup->set_active($popup_active);
			$popup->set_active_main($popup_active_main);
			$popup->set_roles($popup_roles);
			$popup->set_permission_roles($popup_permission_roles);
			
			wp_redirect(admin_url("options-general.php?page=cosmosfarm_simple_popup_admin&simple_popup_id={$popup->ID()}"));
			exit;
		}
		else{
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-simple-popup'));
		}
	}
	
	/**
	 * 팝업 쿠키를 저장한다.
	 */
	public function popup_not_showing(){
		check_ajax_referer('cosmosfarm_simple_popup_ajax_security', 'security');
		
		$popup_id = isset($_POST['popup_id']) ? intval($_POST['popup_id']) : '';
		$popup = new Cosmosfarm_Simple_Popup($popup_id);
		$expiry_date = apply_filters('cosmosfarm_simple_popup_expiry_date', '1', $popup);
		
		if($popup->ID()){
			$_COOKIE["cosmosfarm_simple_popup_{$popup_id}"] = $popup_id;
			setcookie("cosmosfarm_simple_popup_{$popup_id}", $popup_id, strtotime("+{$expiry_date} day"), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
		}
	}
}