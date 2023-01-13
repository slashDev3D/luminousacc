<?php
/**
 * Cosmosfarm_Simple_Popup_Table
 * @link https://www.cosmosfarm.com/
 * @copyright Copyright 2020 Cosmosfarm. All rights reserved.
 */
class Cosmosfarm_Simple_Popup_Table extends WP_List_Table {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function prepare_items(){
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();
		$this->_column_headers = array($columns, $hidden, $sortable);
		
		$keyword = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
		
		$per_page = 20;
		$popup = new Cosmosfarm_Simple_Popup();
		$args = array(
			'post_type'      => $popup->post_type,
			'orderby'        => 'ID',
			'posts_per_page' => $per_page,
			'paged'          => $this->get_pagenum()
		);
		if($keyword){
			$args['s'] = $keyword;
		}
		
		$query = new WP_Query($args);
		$this->items = $query->posts;
		
		$this->set_pagination_args(array('total_items'=>$query->found_posts, 'per_page'=>$per_page));
	}
	
	public function get_table_classes(){
		$classes = parent::get_table_classes();
		$classes[] = 'cosmosfarm-simple-popup';
		$classes[] = 'simple-popup';
		return $classes;
	}
	
	public function no_items(){
		echo __('No Simple Popup found.', 'cosmosfarm-simple-popup');
	}
	
	public function get_columns(){
		return array(
			'cb' => '<input type="checkbox">',
			'title' => '팝업 이름',
			'shortcode' => '숏코드'
		);
	}
	
	function get_bulk_actions(){
		return array(
			'delete' => '영구적으로 삭제하기'
		);
	}
	
	public function display_rows(){
		foreach($this->items as $post){
			$popup = new Cosmosfarm_Simple_Popup($post->ID);
			$this->single_row($popup);
		}
	}
	
	public function single_row($popup){
		$edit_url = admin_url("options-general.php?page=cosmosfarm_simple_popup_admin&simple_popup_id={$popup->ID()}");
		
		echo '<tr data-popup-id="'.$popup->ID().'">';
		
		echo '<th scope="row" class="check-column">';
		echo '<input type="checkbox" name="simple_popup_id[]" value="'.$popup->ID().'">';
		echo '</th>';
		
		echo '<td>';
		echo '<a href="'.$edit_url.'">'.$popup->title().'</a>';
		echo '</td>';
		
		echo '<td>';
		echo '<code>[cosmosfarm_simple_popup id="'.$popup->ID().'"]</code>';
		echo '</td>';
		
		echo '</tr>';
	}
	
	public function search_box($text, $input_id){
		?>
		<p class="search-box">
			<input type="search" id="<?php echo $input_id?>" name="s" value="<?php _admin_search_query()?>">
			<?php submit_button($text, 'button', false, false, array('id'=>'search-submit'))?>
		</p>
		<?php }
}