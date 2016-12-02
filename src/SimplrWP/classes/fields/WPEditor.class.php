<?php 
namespace SimplrWP\Fields;
/**
 * ## Overview
 * The WP Editor extends the Text field, but also leverages the wp_editor built-in functionality.
 *
 *
 * ## Examples
 *
 * Here's an example on how you create a WPEditor field:
 * ```php
 *```
 */
class WPEditor extends Field {
	
	protected $default_wpeditor_settings = array(
		'content' => '',
		'editor_id' => '',
		'wpeditor_settings' => array('media_buttons' => false)
	);
	
	public function __construct($settings){
		// load defaults
		$this->settings = array_replace_recursive($this->settings, $this->default_wpeditor_settings);
		// pass along all settings to parent
		parent::__construct($settings);
	}
	
	public function wp_admin_render_field() {
		echo '<div class="field">';
			echo '<label class="simplrwp--label">' . $this->get_label() . '</label>';
			$this->settings['content'] = stripslashes($this->get_value());
			$this->settings['editor_id'] = $this->get_name();
			wp_editor(   $this->settings['content'], $this->settings['editor_id'] , $this->settings['wpeditor_settings'] );
		echo '</div>';
	}
}

?>