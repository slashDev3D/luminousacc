<?php
/*
Plugin Name: 코스모스팜 심플 팝업
Plugin URI: https://www.cosmosfarm.com/wpstore/product/cosmosfarm-simple-popup
Description: 워드프레스 홈페이지에 팝업창을 표시합니다.
Version: 1.0
Author: 코스모스팜 - Cosmosfarm
Author URI: https://www.cosmosfarm.com/
*/

if(!defined('ABSPATH')) exit;

define('COSMOSFARM_SIMPLE_POPUP_VERSION', '1.0');
define('COSMOSFARM_SIMPLE_POPUP_DIR', dirname(__FILE__));
define('COSMOSFARM_SIMPLE_POPUP_URL', plugins_url('', __FILE__));

include_once 'class/Cosmosfarm_Simple_Popup.class.php';
include_once 'class/Cosmosfarm_Simple_Popup_Controller.class.php';

add_action('admin_init', 'cosmosfarm_simple_popup_admin_init');
function cosmosfarm_simple_popup_admin_init(){
	new Cosmosfarm_Simple_Popup_Controller();
}

add_action('admin_menu', 'cosmosfarm_simple_popup_admin_menu');
function cosmosfarm_simple_popup_admin_menu(){
	global $_wp_last_utility_menu;
	
	$_wp_last_utility_menu++;
	
	add_submenu_page('options-general.php', '심플 팝업', '심플 팝업', 'manage_options', 'cosmosfarm_simple_popup_admin', 'cosmosfarm_simple_popup_admin');
}

add_action('admin_enqueue_scripts', 'cosmosfarm_simple_popup_admin_scripts');
function cosmosfarm_simple_popup_admin_scripts(){
	wp_enqueue_style('cosmosfarm-simple_popup-admin', COSMOSFARM_SIMPLE_POPUP_URL . '/admin/admin.css', array(), COSMOSFARM_SIMPLE_POPUP_VERSION);
}

function cosmosfarm_simple_popup_admin(){
	$simple_popup_id = isset($_GET['simple_popup_id']) ? intval($_GET['simple_popup_id']) : '';
	$simple_popup_action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';
	if($simple_popup_id || $simple_popup_action == 'popup_new'){
		cosmosfarm_simple_popup_setting($simple_popup_id);
	}
	else{
		include_once COSMOSFARM_SIMPLE_POPUP_DIR . '/class/Cosmosfarm_Simple_Popup_Table.class.php';
		
		$table = new Cosmosfarm_Simple_Popup_Table();
		$action = $table->current_action();
		if($action == 'delete'){
			foreach($_POST['simple_popup_id'] as $key=>$value){
				$simple_popup = new Cosmosfarm_Simple_Popup($value);
				$simple_popup->delete();
			}
		}
		$table->prepare_items();
		
		include COSMOSFARM_SIMPLE_POPUP_DIR . '/admin/simple-popup.php';
	}
}

function cosmosfarm_simple_popup_setting($simple_popup_id=''){
	$popup = new Cosmosfarm_Simple_Popup($simple_popup_id);
	
	include_once COSMOSFARM_SIMPLE_POPUP_DIR . '/class/Cosmosfarm_Simple_Popup_Table.class.php';
	$table = new Cosmosfarm_Simple_Popup_Table();
	$table->prepare_items();
	
	wp_enqueue_media();
	
	include COSMOSFARM_SIMPLE_POPUP_DIR . '/admin/simple-popup-setting.php';
}

add_action('wp_enqueue_scripts', 'cosmosfarm_simple_popup_scripts');
function cosmosfarm_simple_popup_scripts(){
	wp_enqueue_script('cosmosfarm-simple-popup-script', COSMOSFARM_SIMPLE_POPUP_URL . '/template/script.js', array('jquery'), COSMOSFARM_SIMPLE_POPUP_VERSION, true);
	wp_enqueue_style('cosmosfarm-simple-popup-style', COSMOSFARM_SIMPLE_POPUP_URL . '/template/style.css', array(), COSMOSFARM_SIMPLE_POPUP_VERSION);
	
	// 설정 등록
	$localize = array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'ajax_security' => wp_create_nonce('cosmosfarm_simple_popup_ajax_security'),
	);
	wp_localize_script('cosmosfarm-simple-popup-script', 'cosmosfarm_simple_popup_settings', $localize);
}

function get_cosmosfarm_simple_popup_news_list(){
	
	$news_list = get_transient('cosmosfarm_simple_popup_news_list');
	
	if($news_list){
		return $news_list;
	}
	
	$response = wp_remote_get('http://updates.wp-kboard.com/v1/AUTH_3529e134-c9d7-4172-8338-f64309faa5e5/kboard/news.json');
	
	if(!is_wp_error($response) && isset($response['body']) && $response['body']){
		$news_list = json_decode($response['body']);
	}
	else{
		$news_list = array();
	}
	
	set_transient('cosmosfarm_simple_popup_news_list', $news_list, 60*60);
	
	return $news_list;
}

function cosmosfarm_simple_popup_current_user_roles(){
	$roles = array();
	if(is_user_logged_in()){
		$user = wp_get_current_user();
		if($user->roles){
			$roles = (array) $user->roles;
		}
		else{
			$user = new WP_User(get_current_user_id(), '', get_current_blog_id());
			if($user->roles){
				$roles = (array) $user->roles;
			}
		}
	}
	return apply_filters('cosmosfarm_simple_popup_current_user_roles', $roles);
}

add_action('wp_footer', 'cosmosfarm_simple_popup_main_page');
function cosmosfarm_simple_popup_main_page(){
	if(is_home() || is_front_page()){
		$popup = new Cosmosfarm_Simple_Popup();
		$args = array(
			'post_type'      => $popup->post_type,
			'orderby'        => 'ID',
			'posts_per_page' => -1
		);
		$query = new WP_Query($args); // 메타 검색 옵션 넣기
		
		foreach($query->posts as $post){
			$popup = new Cosmosfarm_Simple_Popup($post->ID);
			if($popup->ID() && $popup->active() && $popup->active_main() && $popup->has_permission(get_current_user_id())){
				//echo do_shortcode('[cosmosfarm_simple_popup id="'.$popup->ID().'"]');
				echo cosmosfarm_simple_popup(array('id'=>$popup->ID()));
			}
		}
	}
}

add_shortcode('cosmosfarm_simple_popup', 'cosmosfarm_simple_popup');
function cosmosfarm_simple_popup($args=array()){
	$layout = '';
	$popup_id = 0;
	
	if(isset($args['id']) && $args['id']){
		$popup_id = intval($args['id']);
	}
	
	$popup = new Cosmosfarm_Simple_Popup($popup_id);
	if($popup->ID() && $popup->active() && $popup->has_permission(get_current_user_id())){
		$popup_cookie = isset($_COOKIE["cosmosfarm_simple_popup_{$popup_id}"]) ? $_COOKIE["cosmosfarm_simple_popup_{$popup_id}"] : '';
		if(!$popup_cookie){
			ob_start();
			include COSMOSFARM_SIMPLE_POPUP_DIR . '/template/simple-popup-layer.php';
			$layout = ob_get_clean();
		}
	}
	
	return apply_filters('cosmosfarm_simple_popup_layout', $layout, $popup);
}