<?php 
namespace SimplrWP\Fields;
/**
 * ## Overview
 * The Text field is a single line text input.
 *
 *
 * ## Examples
 *
 * Here's an example on how you create a text field:
 * ```php
 *```
 */
class Text extends Field {
	
	public function wp_admin_render_field() {
		$required = $this->is_required() ? '<span style="color:red"> *</span>' : '';
		echo '<div class="field">';
			echo '<label class="simplrwp--label">' . $this->get_label() . $required . '</label>';
			if($this->settings['read_only']){
				echo '<p>' . $this->render_value() . '</p>';
			}else{
				echo '<input class="large-text" name="' . $this->get_name() . '" type="text" value="' . $this->get_value() . '">';
			}
		echo '</div>';
	}
	
	public function get_value() {
		if(is_string($this->settings['value'])) {
			return stripslashes(htmlentities($this->settings['value']));
		}
		return $this->settings['value'];
	}
	
	public function set_value($value) {
		$this->settings['value'] = html_entity_decode($value);
	}
}