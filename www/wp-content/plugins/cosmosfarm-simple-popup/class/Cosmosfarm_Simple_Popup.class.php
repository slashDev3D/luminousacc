<?php
/**
 * Cosmosfarm_Simple_Popup
 * @link https://www.cosmosfarm.com/
 * @copyright Copyright 2020 Cosmosfarm. All rights reserved.
 */
class Cosmosfarm_Simple_Popup {
	
	var $post_type = 'cosmosfarm_popup';
	var $post;
	var $post_id = 0;
	
	public function __construct($popup_id=''){
		if($popup_id){
			$this->init_with_id($popup_id);
		}
	}
	
	public function __get($name){
		if($this->post_id && isset($this->post->{$name})){
			return $this->post->{$name};
		}
		return '';
	}
	
	public function __set($name, $value){
		if($this->post_id){
			$this->post->{$name} = $value;
		}
	}
	
	public function post_type(){
		return $this->post_type;
	}
	
	public function init_with_id($post_id){
		$this->post_id = 0;
		$post_id = intval($post_id);
		if($post_id){
			$this->post = get_post($post_id);
			if($this->post && $this->post->ID){
				$this->post_id = $this->post->ID;
			}
		}
	}
	
	public function ID(){
		return intval($this->post_id);
	}
	
	public function title(){
		return $this->post_title;
	}
	
	public function content(){
		return $this->post_content;
	}

	public function create($user_id, $args){
		$user_id = intval($user_id);
		$title = isset($args['title']) ? $args['title'] : '';
		$content = isset($args['content']) ? $args['content'] : '';
		$name = isset($args['name']) ? $args['name'] : '';
		$meta_input = isset($args['meta_input']) ? $args['meta_input'] : array();
		
		$this->post_id = wp_insert_post(array(
			'post_title'     => wp_strip_all_tags($title),
			'post_content'   => $content,
			'post_name'      => $name,
			'post_status'    => 'publish',
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			'post_author'    => $user_id,
			'post_type'      => $this->post_type,
			'meta_input'     => $meta_input
		));
		
		return $this->post_id;
	}
	
	public function update($args){
		if($this->post_id){
			$args['ID'] = $this->post_id;
			
			if(isset($args['title'])){
				$args['post_title'] = $args['title'];
			}
			
			if(isset($args['content'])){
				$args['post_content'] = $args['content'];
			}
			
			if(isset($args['name'])){
				$args['post_name'] = $args['name'];
			}
			
			wp_update_post($args);
		}
	}
	
	public function delete(){
		if($this->post_id){
			wp_delete_post($this->post_id);
		}
	}
	
	public function set_top($width){
		if($this->post_id){
			update_post_meta($this->post_id, 'top', $width);
		}
	}
	
	public function top(){
		$top = 0;
		if($this->post_id){
			$top = get_post_meta($this->post_id, 'top', true);
		}
		return apply_filters('cosmosfarm_simple_popup_top', $top, $this);
	}
	
	public function set_left($left){
		if($this->post_id){
			update_post_meta($this->post_id, 'left', $left);
		}
	}
	
	public function left(){
		$left = 0;
		if($this->post_id){
			$left = get_post_meta($this->post_id, 'left', true);
		}
		return apply_filters('cosmosfarm_simple_popup_left', $left, $this);
	}
	
	public function set_width($width){
		if($this->post_id){
			update_post_meta($this->post_id, 'width', $width);
		}
	}
	
	public function width(){
		$width = '';
		if($this->post_id){
			$width = get_post_meta($this->post_id, 'width', true);
		}
		return apply_filters('cosmosfarm_simple_popup_width', $width, $this);
	}

	public function set_height($height){
		if($this->post_id){
			update_post_meta($this->post_id, 'height', $height);
		}
	}
	
	public function height(){
		$height = '';
		if($this->post_id){
			$height = get_post_meta($this->post_id, 'height', true);
		}
		return apply_filters('cosmosfarm_simple_popup_height', $height, $this);
	}
	
	public function set_background_color($background_color){
		if($this->post_id){
			update_post_meta($this->post_id, 'background_color', $background_color);
		}
	}
	
	public function background_color(){
		$background_color = 'black';
		if($this->post_id){
			$background_color = get_post_meta($this->post_id, 'background_color', true);
		}
		if(!$background_color){
			$background_color = 'black';
		}
		return apply_filters('cosmosfarm_simple_popup_background_color', $background_color, $this);
	}
	
	public function set_font_color($font_color){
		if($this->post_id){
			update_post_meta($this->post_id, 'font_color', $font_color);
		}
	}
	
	public function font_color(){
		$font_color = '';
		if($this->post_id){
			$font_color = get_post_meta($this->post_id, 'font_color', true);
		}
		if(!$font_color){
			$font_color = 'white';
		}
		return apply_filters('cosmosfarm_simple_popup_font_color', $font_color, $this);
	}

	public function set_active($active){
		if($this->post_id){
			update_post_meta($this->post_id, 'active', $active);
		}
	}
	
	public function active(){
		$active = '';
		if($this->post_id){
			$active = get_post_meta($this->post_id, 'active', true);
		}
		return apply_filters('cosmosfarm_simple_popup_active', $active, $this);
	}

	public function set_active_main($active_main){
		if($this->post_id){
			update_post_meta($this->post_id, 'active_main', $active_main);
		}
	}
	
	public function active_main(){
		$active_main = '';
		if($this->post_id){
			$active_main = get_post_meta($this->post_id, 'active_main', true);
		}
		return apply_filters('cosmosfarm_simple_popup_active_main', $active_main, $this);
	}
	
	public function set_roles($roles){
		if($this->post_id){
			update_post_meta($this->post_id, 'roles', $roles);
		}
	}
	
	public function roles(){
		$roles = '';
		if($this->post_id){
			$roles = get_post_meta($this->post_id, 'roles', true);
		}
		return apply_filters('cosmosfarm_simple_popup_roles', $roles, $this);
	}
	
	public function set_permission_roles($permission_roles){
		if($this->post_id){
			update_post_meta($this->post_id, 'permission_roles', $permission_roles);
		}
	}
	
	public function permission_roles(){
		$permission_roles = array();
		if($this->post_id){
			$permission_roles = get_post_meta($this->post_id, 'permission_roles', true);
		}
		return apply_filters('cosmosfarm_simple_popup_permission_roles', $permission_roles, $this);
	}
	
	public function has_permission($user_id){
		$is_reader = false;
		
		if($this->roles() == 'all'){
			$is_reader = true;
		}
		else if(is_user_logged_in()){
			if($this->roles() == 'author'){
				// 로그인 사용자 허용
				$is_reader = true;
			}
			else if($this->roles() == 'roles'){
				// 선택된 역할의 사용자 허용
				if(array_intersect($this->permission_roles(), cosmosfarm_simple_popup_current_user_roles())){
					$is_reader = true;
				}
			}
		}
		return apply_filters('cosmosfarm_simple_popup_has_permission', $is_reader, $user_id, $this);
	}
	
	public function not_showing_text(){
		$not_showing_text = '';
		if($this->post_id){
			$not_showing_text = '1일 동안 보지 않음';
		}
		return apply_filters('cosmosfarm_simple_popup_not_showing_text', $not_showing_text, $this);
	}

	public function close_text(){
		$close_text = '';
		if($this->post_id){
			$close_text = '닫기';
		}
		return apply_filters('cosmosfarm_simple_popup_close_text', $close_text, $this);
	}
	
	public function get_style(){
		$style = '';
		if($this->post_id){
			$args = array();
			$args[] = "top: {$this->top()}px;";
			$args[] = "left: {$this->left()}px;";
			if($this->width()){
				$args[] = "width: {$this->width()}px;";
			}
			if($args){
				$style = implode(' ' , $args);
			}
		}
		return apply_filters('cosmosfarm_simple_popup_style', $style, $this);
	}
}