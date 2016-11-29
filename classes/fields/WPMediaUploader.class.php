<?php 
namespace SimplrWP\Fields;
/**
 * ## Overview
 * The WPMediaUploader field uses WordPress' built in Media Upload functionality
 *
 *
 * ## Examples
 *
 * Here's an example on how you create a WPMediaUploader field:
 * ```php
 *```
 */
class WPMediaUploader extends Field {
	
	public function wp_admin_render_field() {
		$is_image = in_array(get_post_mime_type($this->get_value()), array('image/png', 'image/jpg', 'image/jpeg', 'image/gif'));
		$has_file = !empty($this->get_value());
		?>
		<div class="field simplrwp--media_uploader">
			<label class="simplrwp--label"><?php  echo $this->get_label(); ?></label>
			<?php if($this->settings['read_only']){ 
				echo $this->render_field();
			} else { ?>
				<div class="image-container">
					<?php if($is_image) { 
						$img_src = wp_get_attachment_image_src( $this->get_value(), 'medium' );
					?>
						<img src="<?php echo $img_src[0] ?>" alt="" style="max-width:100%;" />
					<?php } ?>
				</div>
				<div class="file-container">
					<?php if($has_file && !$is_image) { 
						$file_url = wp_get_attachment_url($this->get_value());
						$file_parts = explode('/', $file_url);
					?>
						<img class="file-image" src="<?php echo SIMPLRWP_URL . 'assets/images/document.png'; ?>" />
						<ul>
							<li><strong><span class="file-title"><?php echo get_the_title($this->get_value()); ?></span></strong></li>
							<li><strong>File Name:</strong> <span class="file-name"><?php echo sprintf('<a href="%s" target="_blank">%s</a>',$file_url, array_pop($file_parts)); ?></span></li>
							<li><strong>File Size:</strong> <span class="file-size"><?php echo $this->_get_file_size(filesize(get_attached_file($this->get_value()))); ?></span></li>
						</ul>
					<?php } ?>
				</div>
				<p class="hide-if-no-js">
					<div class="upload-media <?php echo $has_file ? 'hidden' : ''; ?>">
						No file selected.
					    <a class="button" href="<?php echo esc_url( get_upload_iframe_src( 'image' ) ) ?>" >
					        <?php _e('Add Media') ?>
					    </a>
					</div>
				    <a class="delete-media <?php echo !$has_file ? 'hidden' : ''; ?>" href="#" >
				        <?php _e('Remove this media') ?>
				    </a>
				</p>
				<input class="media-id" name="<?php echo $this->get_name(); ?>" type="hidden" value="<?php echo $this->get_value();?>" />
			<?php } ?>
		</div>
		<?php 
	}
	
	public function wp_admin_enqueue_scripts() {
		wp_enqueue_media();
		// load styles
		wp_enqueue_style( 'simplrwp_wp-media-uploader', SIMPLRWP_URL . 'assets/css/simplrwp-media_uploader.css' );
		
		wp_enqueue_script( 'simplrwp_wp-media-uploader', SIMPLRWP_URL . 'assets/js/fields/WPMediaUploader.js' );
		wp_localize_script( 'simplrwp_wp-media-uploader', 'simplrwp_media_uploader', array(
			'simplrwp_url' => SIMPLRWP_URL,
		) );
	}

	public function get_img_url(){
		return wp_get_attachment_image_src( $this->settings['value'], 'medium' )[0];
	}
	
	protected function _get_file_size($bytes, $precision = 0) { 
	    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
	
	    $bytes = max($bytes, 0); 
	    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
	    $pow = min($pow, count($units) - 1); 
	
	    $bytes /= pow(1024, $pow);
	    // $bytes /= (1 << (10 * $pow)); 
	
	    return round($bytes, $precision) . ' ' . $units[$pow]; 
	} 
}

?>
