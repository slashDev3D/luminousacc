<?php if(!defined('ABSPATH')) exit;?>
<div class="wrap">
	<div style="float:left;margin:7px 8px 0 0;width:36px;height:34px;background:url(<?php echo COSMOSFARM_SIMPLE_POPUP_URL . '/images/icon-big.png'?>) left top no-repeat;"></div>
	<h1 class="wp-heading-inline">코스모스팜 심플 팝업</h1>
	<a href="https://www.cosmosfarm.com/" class="page-title-action" onclick="window.open(this.href);return false;">홈페이지</a>
	<a href="https://www.cosmosfarm.com/threads" class="page-title-action" onclick="window.open(this.href);return false;">커뮤니티</a>
	<a href="https://www.cosmosfarm.com/support" class="page-title-action" onclick="window.open(this.href);return false;">고객지원</a>
	<a href="https://blog.cosmosfarm.com/" class="page-title-action" onclick="window.open(this.href);return false;">블로그</a>
	
	<hr class="wp-header-end">
	
	<form method="post" action="<?php echo admin_url('admin-post.php')?>">
		<?php wp_nonce_field('cosmosfarm-simple-popup-save', 'cosmosfarm-simple-popup-save-nonce')?>
		<input type="hidden" name="action" value="cosmosfarm_simple_popup_save">
		<input type="hidden" name="simple_popup_id" value="<?php echo $popup->ID()?>">
		
		<?php if($popup->ID()):?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="">숏코드</label></th>
					<td>
						<code>[cosmosfarm_simple_popup id="<?php echo $popup->ID()?>"]</code>
						<p class="description">숏코드를 페이지 혹은 글에 삽입해주세요.</p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<hr>
		<?php endif?>
		
		<h2 class="nav-tab-wrapper">
			<a href="#cosmosfarm-simple-popup-setting-0" class="cosmosfarm-simple-popup-setting-tab nav-tab nav-tab-active">팝업 정보</a>
		</h2>
		
		<div class="cosmosfarm-simple-popup-setting cosmosfarm-simple-popup-setting-active">
			<!-- simple-popup 내용 -->
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-title">팝업 이름</label> <span style="font-size:12px;color:red;">(필수)</span></th>
						<td>
							<input type="text" id="simple-popup-title" name="simple_popup_title" class="regular-text" value="<?php echo $popup->title()?>" required>
							<p class="description">팝업의 이름을 입력해주세요.</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-top">상단 여백</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<input type="number" id="simple-popup-top" name="simple_popup_top" value="<?php echo $popup->top()?>"> px
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-left">왼쪽 여백</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<input type="number" id="simple-popup-left" name="simple_popup_left" value="<?php echo $popup->left()?>"> px
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-width">너비</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<input type="number" id="simple-popup-width" name="simple_popup_width" value="<?php echo $popup->width()?>"> px
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-height">높이</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<input type="number" id="simple-popup-height" name="simple_popup_height" value="<?php echo $popup->height()?>"> px
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-background-color">푸터 배경색상</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<input type="text" id="simple-popup-background-color" name="simple_popup_background_color" value="<?php echo $popup->background_color()?>">
							<p class="description">예제1) black</p>
							<p class="description">예제2) #000000</p>
							<p class="description">예제3) #000</p>
							<p class="description">예제4) rgb(0, 0, 0)</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-font-color">푸터 글자색상</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<input type="text" id="simple-popup-font-color" name="simple_popup_font_color" value="<?php echo $popup->font_color()?>">
							<p class="description">예제1) white</p>
							<p class="description">예제2) #FFFFFF</p>
							<p class="description">예제3) #FFF</p>
							<p class="description">예제4) rgb(255, 255, 255)</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-active">활성화/비활성화</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<select id="simple-popup-active" name="simple_popup_active">
								<option value="">비활성화</option>
								<option value="1"<?php if($popup->active()):?> selected<?php endif?>>활성화</option>
							</select>
							<p class="description">팝업을 사용하지 않을 경우 페이지 혹은 글에 삽입된 숏코드가 있다면 직접 제거해주세요.</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-active-main">메인 화면에 표시</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<select id="simple-popup-active-main" name="simple_popup_active_main">
								<option value="">비활성화</option>
								<option value="1"<?php if($popup->active_main()):?> selected<?php endif?>>활성화</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-roles">표시할 권한</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<select id="simple-popup-roles" name="simple_popup_roles" onchange="cosmosfarm_simple_popup_permission_roles(this)">
								<option value="all"<?php if($popup->roles() == 'all'):?> selected<?php endif?>>제한없음</option>
								<option value="author"<?php if($popup->roles() == 'author'):?> selected<?php endif?>>로그인 사용자</option>
								<option value="roles"<?php if($popup->roles() == 'roles'):?> selected<?php endif?>>직접선택</option>
							</select>
							<div class="cosmosfarm-simple-popup-roles-view<?php if($popup->roles() != 'roles'):?> cosmosfarm-simple-popup-hide<?php endif?>">
								<?php foreach(get_editable_roles() as $roles_key=>$roles_value):?>
									<label><input type="checkbox" name="simple_popup_permission_roles[]" value="<?php echo $roles_key?>"<?php if($roles_key=='administrator'):?> onclick="return false"<?php endif?><?php if($roles_key=='administrator' || in_array($roles_key, $popup->permission_roles())):?> checked<?php endif?>> <?php echo _x($roles_value['name'], 'User role')?></label>
								<?php endforeach?>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="simple-popup-content">내용</label> <span style="font-size:12px;color:gray;">(선택)</span></th>
						<td>
							<?php echo wp_editor($popup->content(), 'simple_popup_content', array('editor_height'=>300))?>
							<p class="description">팝업 내용을 입력해주세요.</p>
						</td>
					</tr>
				</tbody>
			</table>
			
			<p class="submit">
				<input type="submit" class="button-primary" value="변경 사항 저장">
			</p>
		</div>
	</form>
	
	<ul class="cosmosfarm-simple-popup-news-list">
		<?php
		foreach(get_cosmosfarm_simple_popup_news_list() as $news_item):?>
		<li>
			<a href="<?php echo esc_url($news_item->url)?>" target="<?php echo esc_attr($news_item->target)?>" style="text-decoration:none"><?php echo esc_html($news_item->title)?></a>
		</li>
		<?php endforeach?>
	</ul>
</div>
<div class="clear"></div>

<script>
function cosmosfarm_simple_popup_permission_roles(obj){
	if(jQuery(obj).val() == 'roles'){
		jQuery(obj).siblings('.cosmosfarm-simple-popup-roles-view').removeClass('cosmosfarm-simple-popup-hide');
	}
	else{
		jQuery(obj).siblings('.cosmosfarm-simple-popup-roles-view').addClass('cosmosfarm-simple-popup-hide');
	}
}
</script>