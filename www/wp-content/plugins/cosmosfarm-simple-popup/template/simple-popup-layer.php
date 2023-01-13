<?php if(!defined('ABSPATH')) exit;?>
<div class="cosmosfarm-simple-popup-layout popup-id-<?php echo intval($popup_id)?>" style="<?php echo esc_attr($popup->get_style())?>">
	<div class="cosmosfarm-simple-popup">
		<div class="popup-content"<?php if($popup->height()):?> style="height: <?php echo intval($popup->height())?>px;"<?php endif?>>
			<?php echo wpautop($popup->content())?>
		</div>
		<div class="popup-footer"<?php if($popup->background_color()):?> style="background-color: <?php echo esc_attr($popup->background_color())?>;"<?php endif?>>
			<div class="popup-not-showing" onclick="cosmosfarm_simple_popup_not_showing(this, '<?php echo $popup->ID()?>')" style="color: <?php echo esc_attr($popup->font_color())?>;"><?php echo esc_html($popup->not_showing_text())?></div>
			<div class="popup-close" onclick="cosmosfarm_simple_popup_close(this)" style="color: <?php echo esc_attr($popup->font_color())?>;"><?php echo esc_html($popup->close_text())?></div>
		</div>
	</div>
</div>