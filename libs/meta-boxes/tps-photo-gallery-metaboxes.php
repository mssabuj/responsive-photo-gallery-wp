<?php

	if( !defined( 'ABSPATH' ) ){
	    exit;
	}

	function tps_photo_gallery_reg_meta_boxes() {

		$tpsgallery 	= array( 'generategallery');
		$tpgallerytypes = array( 'tp_photo_gallery');
		add_meta_box(
			'custom_gallery_meta_box_id1',                      # Metabox
			__( 'Gallery Settings', 'tpcgallery' ),   	        # Title
			'tps_photo_gallery_type_func',                      # Call Back func
			$tpsgallery,                                        # post type
			'normal'                                            # Text Content
		);
		add_meta_box(
			'custom_gallery_meta_box_id2',                      # Metabox
			__( 'Gallery Settings', 'tpcgallery' ),   	        # Title
			'tps_photo_gallery_type_func2',                      # Call Back func
			$tpgallerytypes,                                        # post type
			'normal'                                            # Text Content
		);

	}
	add_action( 'add_meta_boxes', 'tps_photo_gallery_reg_meta_boxes' );

	# Call Back Function...
	function tps_photo_gallery_type_func( $post, $args){

		#Call get post meta.
		$tps_gallery_cat_name 			  	= get_post_meta($post->ID, 'tps_gallery_cat_name', true);
		$tpsgallery_theme_id 			  	= get_post_meta($post->ID, 'tpsgallery_theme_id', true);
		$selected_size            			= get_post_meta($post->ID, 'tpsgallery_img_size', true);	
		$tpsgallery_img_captions			= get_post_meta($post->ID, 'tpsgallery_img_captions', true);
		$tpsgallery_captions_style			= get_post_meta($post->ID, 'tpsgallery_captions_style', true);
		$tpsgallery_captions_positions		= get_post_meta($post->ID, 'tpsgallery_captions_positions', true);
		$tpsgallery_caption_color			= get_post_meta($post->ID, 'tpsgallery_caption_color', true);
		$tpsgallery_caption_color_text		= get_post_meta($post->ID, 'tpsgallery_caption_color_text', true);
		$tpsgallery_caption_font_size		= get_post_meta($post->ID, 'tpsgallery_caption_font_size', true);
		$tpsgallery_caption_text_align		= get_post_meta($post->ID, 'tpsgallery_caption_text_align', true);
		$tpsgallery_columns					= get_post_meta($post->ID, 'tpsgallery_columns', true);
		$tpsgallery_nav_value              	= get_post_meta($post->ID, 'tpsgallery_nav_value', true);
		$tpsgallery_back_color              = get_post_meta($post->ID, 'tpsgallery_back_color', true);
		$show_hide_links					= get_post_meta($post->ID, 'show_hide_links', true);
		$show_hide_lightboxes				= get_post_meta($post->ID, 'show_hide_lightboxes', true);
		$overlay_color_alpha 				= get_post_meta($post->ID, 'overlay_color_alpha', true);
		$overlay_color_icons 				= get_post_meta($post->ID, 'overlay_color_icons', true);
		$overlay_icons_bg 					= get_post_meta($post->ID, 'overlay_icons_bg', true);
		$caption_color_bg          			= get_post_meta($post->ID, 'caption_color_bg', true);
		$caption_color_text         		= get_post_meta($post->ID, 'caption_color_text', true);
		$caption_font_size          		= get_post_meta($post->ID, 'caption_font_size', true);
		$caption_text_align         		= get_post_meta($post->ID, 'caption_text_align', true);

		// Available image sizes
		$sizes = array( 'thumbnail', 'medium', 'large', 'full' );

	?>
<div class="tpsgallery_settings post-grid-metabox">
	<!-- <div class="wrap"> -->
	<ul class="tab-nav">
		<li nav="1" class="nav1 <?php if($tpsgallery_nav_value == 1){echo "active";}?>"><i class="fa fa-file-code-o" aria-hidden="true" ></i> <?php _e('Shortcodes','tpcgallery'); ?></li>
		<li nav="2" class="nav2 <?php if($tpsgallery_nav_value == 2){echo "active";}?>"><i class="fa fa-clipboard" aria-hidden="true"></i><?php _e('Query Gallery ','tpcgallery'); ?></li>
		<li nav="3" class="nav3 <?php if($tpsgallery_nav_value == 3){echo "active";}?>"><i class="fa fa-clipboard" aria-hidden="true"></i><?php _e('Gallery Settings','tpcgallery'); ?></li>
	</ul> <!-- tab-nav end -->
	<?php
		$getNavValue = "";
		if(!empty($tpsgallery_nav_value)){ $getNavValue = $tpsgallery_nav_value; } else { $getNavValue = 1; }
	?>
	<input type="hidden" name="tpsgallery_nav_value" id="tpsgallery_nav_value" value="<?php echo esc_attr( $getNavValue ); ?>"> 

	<ul class="box">
		<!-- Tab 1  -->
		<li style="<?php if($tpsgallery_nav_value == 1){echo "display: block;";} else{ echo "display: none;"; }?>" class="box1 tab-box <?php if( $tpsgallery_nav_value == 1 ){echo "active";}?>">
			<div class="option-box">
				<p class="option-title"><?php _e('Shortcode','tpcgallery'); ?></p>
				<p class="option-info"><?php _e('Copy this shortcode and paste on page or post where you want to display Photo Gallery.','tpcgallery'); ?></p>
				<textarea cols="50" rows="1" onClick="this.select();" >[tps_gallery <?php echo 'id="'.$post->ID.'"';?>]</textarea>
				<br /><br />
				<p class="option-info"><?php _e('PHP Code:','tpcgallery'); ?></p>
				<p class="option-info"><?php _e('Use PHP code to your themes file to display Photo Gallery.','tpcgallery'); ?></p>
				<textarea cols="50" rows="2" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[tps_gallery id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea>  
			</div>
		</li>

		<!-- Tab 2  -->
		<li style="<?php if($tpsgallery_nav_value == 2){echo "display: block;";} else{ echo "display: none;"; }?>" class="box2 tab-box <?php if($tpsgallery_nav_value == 2){echo "active";}?>">
			<div class="option-box">
				<p class="option-title"><?php _e('Query Gallery','tpcgallery'); ?></p>
			</div>
			<div class="wrap">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<label for="tps_gallery_cat_name"><?php _e( 'Select Categories', 'tpcgallery' ); ?></label>
							<span class="tpsgallery_manager_hint toss"><?php echo __('The category names will only be visible when gallery item are published within specific categories.', 'tpcgallery' ); ?></span>
						</th>
						<td style="vertical-align: middle;">
							<ul>			
								<?php
									$args = array( 
										'taxonomy'     => 'tpgallerycat',
										'orderby'      => 'name',
										'show_count'   => 1,
										'pad_counts'   => 1, 
										'hierarchical' => 1,
										'echo'         => 0
									);
									$allthecats = get_categories( $args );

									foreach( $allthecats as $category ):
									    $cat_id = $category->cat_ID;
									    $checked = ( in_array( $cat_id,( array )$tps_gallery_cat_name ) ? ' checked="checked"' : "" );
									        echo'<li id="cat-'.$cat_id.'"><input type="checkbox" name="tps_gallery_cat_name[]" id="'.$cat_id.'" value="'.$cat_id.'"'.$checked.'> <label for="'.$cat_id.'">'.__( $category->cat_name, 'tpcgallery' ).'</label></li>';
									endforeach;
								?>
							</ul>
							<span class="tpstestimonial_manager_hint"><?php echo __('Choose multiple categories for each gallery.', 'tpcgallery' ); ?></span>
						</td>
					</tr><!-- End Gallery Categories -->

					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_theme_id"><?php _e('Gallery Styles', 'tpcgallery'); ?></label>
							<span class="tpsgallery_manager_hint toss"><?php echo __('Select a Style which you want to display.', 'tpcgallery' ); ?></span>
						</th>
						<td style="vertical-align: middle;">
							<select name="tpsgallery_theme_id" id="tpsgallery_theme_id" class="timezone_string">
								<option value="1" <?php if ( isset ( $tpsgallery_theme_id ) ) selected( $tpsgallery_theme_id, '1' ); ?>><?php _e('Default', 'tpcgallery'); ?></option>
								<option disabled value="2" <?php if ( isset ( $tpsgallery_theme_id ) ) selected( $tpsgallery_theme_id, '2' ); ?>><?php _e('Style 2 (Only Pro)', 'tpcgallery'); ?></option>
								<option disabled value="3" <?php if ( isset ( $tpsgallery_theme_id ) ) selected( $tpsgallery_theme_id, '3' ); ?>><?php _e('Style 3 (Only Pro)', 'tpcgallery'); ?></option>
								<option disabled value="4" <?php if ( isset ( $tpsgallery_theme_id ) ) selected( $tpsgallery_theme_id, '4' ); ?>><?php _e('Style 4 (Only Pro)', 'tpcgallery'); ?></option>
								<option disabled value="5" <?php if ( isset ( $tpsgallery_theme_id ) ) selected( $tpsgallery_theme_id, '5' ); ?>><?php _e('Style 5 (Only Pro)', 'tpcgallery'); ?></option>
								<option disabled value="6" <?php if ( isset ( $tpsgallery_theme_id ) ) selected( $tpsgallery_theme_id, '6' ); ?>><?php _e('Style 6 (Only Pro)', 'tpcgallery'); ?></option>
								<option disabled value="7" <?php if ( isset ( $tpsgallery_theme_id ) ) selected( $tpsgallery_theme_id, '7' ); ?>><?php _e('Style 7 (Only Pro)', 'tpcgallery'); ?></option>
								<option disabled value="8" <?php if ( isset ( $tpsgallery_theme_id ) ) selected( $tpsgallery_theme_id, '8' ); ?>><?php _e('Style 8 (Only Pro)', 'tpcgallery'); ?></option>
							</select>
						</td>
					</tr>
					<!-- End Styles -->

					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_columns"><?php _e('Gallery Column', 'tpcgallery'); ?></label>
							<span class="tpsgallery_manager_hint toss"><?php echo __('Choose an option for gallery column.', 'tpcgallery' ); ?></span>
						</th>
						<td style="vertical-align: middle;">
							<select name="tpsgallery_columns" id="tpsgallery_columns" class="timezone_string">
								<option value="3" <?php if ( isset ( $tpsgallery_columns ) ) selected( $tpsgallery_columns, '3' ); ?>><?php _e('Column 3', 'tpcgallery'); ?></option>
								<option value="4" <?php if ( isset ( $tpsgallery_columns ) ) selected( $tpsgallery_columns, '4' ); ?>><?php _e('Column 4', 'tpcgallery'); ?></option>
								<option value="2" <?php if ( isset ( $tpsgallery_columns ) ) selected( $tpsgallery_columns, '2' ); ?>><?php _e('Column 2', 'tpcgallery'); ?></option>
								<option value="1" <?php if ( isset ( $tpsgallery_columns ) ) selected( $tpsgallery_columns, '1' ); ?>><?php _e('Column 1', 'tpcgallery'); ?></option>
								<option value="5" <?php if ( isset ( $tpsgallery_columns ) ) selected( $tpsgallery_columns, '5' ); ?>><?php _e('Column 5', 'tpcgallery'); ?></option>
								<option value="6" <?php if ( isset ( $tpsgallery_columns ) ) selected( $tpsgallery_columns, '6' ); ?>><?php _e('Column 6', 'tpcgallery'); ?></option>
							</select>
						</td>
					</tr>
					<!-- End Styles -->

					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_img_size"><?php _e('Image Size', 'tpcgallery'); ?></label>
							<span class="tpsgallery_manager_hint toss"><?php echo __('Choose an image size to display perfectly.', 'tpcgallery' ); ?></span>
						</th>
						<td style="vertical-align: middle;">
							<?php
								// Generate the select dropdown
								echo '<select name="tpsgallery_img_size" id="tpsgallery_img_size">';
								foreach ( $sizes as $size ) {
								    echo '<option value="' . esc_attr( $size ) . '"' . selected( $selected_size, $size, false ) . '>' . ucfirst( esc_html( $size ) ) . '</option>';
								}
								echo '</select>';
						    ?>

						</td>
					</tr>
					<!-- End Image Size -->
					
				</table>
			</div>
		</li>
		<!-- Tab 2  -->
		<li style="<?php if($tpsgallery_nav_value == 3){echo "display: block;";} else{ echo "display: none;"; }?>" class="box3 tab-box <?php if($tpsgallery_nav_value == 3){echo "active";}?>">
			<div class="option-box">
				<p class="option-title"><?php _e('Gallery Settings','tpcgallery'); ?></p>
			</div>
				<div class="wrap">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_img_captions"><?php _e('Image Caption', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<select name="tpsgallery_img_captions" id="tpsgallery_img_captions" class="timezone_string">
								<option value="1" <?php if ( isset ( $tpsgallery_img_captions ) ) selected( $tpsgallery_img_captions, '1' ); ?>><?php _e('Show', 'tpcgallery'); ?></option>
								<option value="2" <?php if ( isset ( $tpsgallery_img_captions ) ) selected( $tpsgallery_img_captions, '2' ); ?>><?php _e('Hide', 'tpcgallery'); ?></option>
							</select>
						</td>
					</tr>
					<!-- End Caption -->

					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_captions_style"><?php _e('Caption Style', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<select name="tpsgallery_captions_style" id="tpsgallery_captions_style" class="timezone_string">
								<option value="1" <?php if ( isset ( $tpsgallery_captions_style ) ) selected( $tpsgallery_captions_style, '1' ); ?>><?php _e('Default', 'tpcgallery'); ?></option>
								<option value="2" <?php if ( isset ( $tpsgallery_captions_style ) ) selected( $tpsgallery_captions_style, '2' ); ?>><?php _e('Show On Hover', 'tpcgallery'); ?></option>
							</select>
						</td>
					</tr>
					<!-- End Caption Positions -->

					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_captions_positions"><?php _e('Caption Position', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<select name="tpsgallery_captions_positions" id="tpsgallery_captions_positions" class="timezone_string">
								<option value="1" <?php if ( isset ( $tpsgallery_captions_positions ) ) selected( $tpsgallery_captions_positions, '1' ); ?>><?php _e('Default', 'tpcgallery'); ?></option>
								<option value="2" <?php if ( isset ( $tpsgallery_captions_positions ) ) selected( $tpsgallery_captions_positions, '2' ); ?>><?php _e('Top', 'tpcgallery'); ?></option>
								<option value="3" <?php if ( isset ( $tpsgallery_captions_positions ) ) selected( $tpsgallery_captions_positions, '3' ); ?>><?php _e('Bottom', 'tpcgallery'); ?></option>
								<option value="4" <?php if ( isset ( $tpsgallery_captions_positions ) ) selected( $tpsgallery_captions_positions, '4' ); ?>><?php _e('Center', 'tpcgallery'); ?></option>
							</select>
						</td>
					</tr>
					<!-- End Caption Positions -->

					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_caption_color"><?php _e('Caption Background', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<input type="text" name="tpsgallery_caption_color" id="tpsgallery_caption_color" class="timezone_string" value="<?php  if($tpsgallery_caption_color !=''){echo $tpsgallery_caption_color; }else{ echo '#000000';} ?>">
						</td>
					</tr>				
					<!-- End Caption Background Color -->

					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_caption_color_text"><?php _e('Caption Text Color', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<input type="text" name="tpsgallery_caption_color_text" id="tpsgallery_caption_color_text" class="timezone_string" value="<?php  if($tpsgallery_caption_color_text !=''){echo $tpsgallery_caption_color_text; }else{ echo '#ffffff';} ?>">
						</td>
					</tr>				
					<!-- End Caption Background Color -->
					
					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_caption_font_size"><?php _e('Caption Font Size', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<select name="tpsgallery_caption_font_size" id="tpsgallery_caption_font_size">
								<?php for($i=15; $i<=72; $i++){?>
								<option value="<?php echo $i; ?>" <?php if ( isset ( $tpsgallery_caption_font_size ) ) selected( $tpsgallery_caption_font_size, $i ); ?>><?php echo $i."px";?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<!-- End Caption Font Size-->
					
					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_caption_text_align"><?php _e('Text Alignment', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<select name="tpsgallery_caption_text_align" id="tpsgallery_caption_text_align" class="timezone_string">
								<option value="left" <?php if ( isset ( $tpsgallery_caption_text_align ) ) selected( $tpsgallery_caption_text_align, 'left' ); ?>><?php _e('Left', 'tpcgallery'); ?></option>
								<option value="center" <?php if ( isset ( $tpsgallery_caption_text_align ) ) selected( $tpsgallery_caption_text_align, 'center' ); ?>><?php _e('Center', 'tpcgallery'); ?></option>
								<option value="right" <?php if ( isset ( $tpsgallery_caption_text_align ) ) selected( $tpsgallery_caption_text_align, 'right' ); ?>><?php _e('Right', 'tpcgallery'); ?></option>
							</select>
						</td>
					</tr>
					<!-- End Caption Text Alignment-->
					
					<tr valign="top">
						<th scope="row">
							<label for="show_hide_links"><?php _e('Permalink', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<select name="show_hide_links" id="show_hide_links" class="timezone_string">
								<option value="1" <?php if ( isset ( $show_hide_links ) ) selected( $show_hide_links, '1' ); ?>><?php _e('Show', 'tpcgallery'); ?></option>
								<option value="2" <?php if ( isset ( $show_hide_links ) ) selected( $show_hide_links, '2' ); ?>><?php _e('Hide', 'tpcgallery'); ?></option>
							</select>
						</td>
					</tr>
					<!-- End Show/Hide Permalink -->
					
					<tr valign="top">
						<th scope="row">
							<label for="show_hide_lightboxes"><?php _e('Lightbox', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<select name="show_hide_lightboxes" id="show_hide_lightboxes" class="timezone_string">
								<option value="1" <?php if ( isset ( $show_hide_lightboxes ) ) selected( $show_hide_lightboxes, '1' ); ?>><?php _e('Show', 'tpcgallery'); ?></option>
								<option value="2" <?php if ( isset ( $show_hide_lightboxes ) ) selected( $show_hide_lightboxes, '2' ); ?>><?php _e('Hide', 'tpcgallery'); ?></option>
							</select>
						</td>
					</tr>
					<!-- End Show/Hide Lightbox -->

					<tr valign="top">
						<th scope="row">
							<label for="overlay_color_alpha"><?php _e('Overlay Color', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<input type="text" name="overlay_color_alpha" id="overlay_color_alpha" class="timezone_string" value="<?php  if($overlay_color_alpha !=''){echo $overlay_color_alpha; }else{ echo '#000000';} ?>">
						</td>
					</tr>				
					<!-- End Overlay Color -->

					<tr valign="top">
						<th scope="row">
							<label for="overlay_icons_bg"><?php _e('Icon Background Color', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<input type="text" name="overlay_icons_bg" id="overlay_icons_bg" class="timezone_string" value="<?php  if($overlay_icons_bg !=''){echo $overlay_icons_bg; }else{ echo '#ffffff';} ?>">
						</td>
					</tr>				
					<!-- End Overlay Icons Background Color -->

					<tr valign="top">
						<th scope="row">
							<label for="overlay_color_icons"><?php _e('Icons Color', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<input type="text" name="overlay_color_icons" id="overlay_color_icons" class="timezone_string" value="<?php  if($overlay_color_icons !=''){echo $overlay_color_icons; }else{ echo '#000000';} ?>">
						</td>
					</tr>				
					<!-- End Overlay Icons Color -->
					
					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_back_color"><?php _e('Background Color', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<input type="text" name="tpsgallery_back_color" id="tpsgallery_back_color" class="timezone_string" value="<?php  if($tpsgallery_back_color !=''){echo $tpsgallery_back_color; }else{ echo '#ffffff';} ?>">
						</td>
					</tr>				
					<!-- End Caption Background Color -->
				</table>
			</div>
		</li>

		<script>
			jQuery(document).ready(function(){
				jQuery("#tpsgallery_caption_color, #tpsgallery_caption_color_text, #overlay_color_alpha, #overlay_color_icons, #overlay_icons_bg, #tpsgallery_back_color").wpColorPicker();
			});
		</script>
		
	</ul>
</div>
	
	<?php }   //

	# Call Back Function...
	function tps_photo_gallery_type_func2( $post, $args){

		$tpsgallery_types_id 	= get_post_meta($post->ID, 'tpsgallery_types_id', true);
		$tpsgallery_types_inc 	= get_post_meta($post->ID, 'tpsgallery_types_inc', true);

		?>
		
			<div class="wrap">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<label for="tpsgallery_types_id"><?php _e('Gallery Type', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<select name="tpsgallery_types_id" id="tpsgallery_types_id" class="timezone_string">
								<option value="1" <?php if ( isset ( $tpsgallery_types_id ) ) selected( $tpsgallery_types_id, '1' ); ?>><?php _e('Default', 'tpcgallery'); ?></option>
								<option value="2" <?php if ( isset ( $tpsgallery_types_id ) ) selected( $tpsgallery_types_id, '2' ); ?>><?php _e('Image', 'tpcgallery'); ?></option>
								<option value="3" <?php if ( isset ( $tpsgallery_types_id ) ) selected( $tpsgallery_types_id, '3' ); ?>><?php _e('Video', 'tpcgallery'); ?></option>
							</select>
						</td>
					</tr>
					<!-- End Gallery Type -->
					
					<tr valign="top" id="ctlhide">
						<th scope="row">
							<label for="tpsgallery_types_inc"><?php _e('Image or Video Link', 'tpcgallery'); ?></label>
						</th>
						<td style="vertical-align: middle;">
							<input type="text" name="tpsgallery_types_inc" id="tpsgallery_types_inc" class="timezone_string" value="<?php  if($tpsgallery_types_inc !=''){echo $tpsgallery_types_inc; } ?>">
						</td>
					</tr>
					<!-- End Link -->
					
				</table>
			</div>
	<?php }
		
	# Data save in custom metabox field
	function tpsgallery_meta_box_save_func($post_id){

	    // Check if the current user has permission to edit the post
	    if ( ! current_user_can( 'edit_post', $post_id ) ) {
	        return;
	    }

		# Doing autosave then return.
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return;


	    // Sanitize and Save 'tps_gallery_cat_name' (multiple checkbox values)
	    if ( isset( $_POST['tps_gallery_cat_name'] ) ) {
	        $tps_gallery_cat_name = array_map( 'sanitize_text_field', $_POST['tps_gallery_cat_name'] );
	        update_post_meta( $post_id, 'tps_gallery_cat_name', $tps_gallery_cat_name );
	    } else {
	        delete_post_meta( $post_id, 'tps_gallery_cat_name' );
	    }

	    // Sanitize and save the 'tpsgallery_theme_id' field
	    if ( isset( $_POST['tpsgallery_theme_id'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_theme_id', sanitize_text_field( $_POST['tpsgallery_theme_id'] ) );
	    }

	    // Save the selected image size if available
	    if ( isset( $_POST['tpsgallery_img_size'] ) ) {
	        $size = sanitize_text_field( $_POST['tpsgallery_img_size'] );
	        update_post_meta( $post_id, 'tpsgallery_img_size', $size );
	    }

	    // Sanitize and save the 'tpsgallery_img_captions' field
	    if ( isset( $_POST['tpsgallery_img_captions'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_img_captions', sanitize_text_field( $_POST['tpsgallery_img_captions'] ) );
	    }

	    // Sanitize and save the 'tpsgallery_captions_style' field
	    if ( isset( $_POST['tpsgallery_captions_style'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_captions_style', sanitize_text_field( $_POST['tpsgallery_captions_style'] ) );
	    }

	    // Sanitize and save the 'tpsgallery_captions_positions' field
	    if ( isset( $_POST['tpsgallery_captions_positions'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_captions_positions', sanitize_text_field( $_POST['tpsgallery_captions_positions'] ) );
	    }


	    // Sanitize and save 'tpsgallery_caption_color' field
	    if ( isset( $_POST['tpsgallery_caption_color'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_caption_color', sanitize_hex_color( $_POST['tpsgallery_caption_color'] ) );
	    }

	    // Sanitize and save 'tpsgallery_caption_color_text' field
	    if ( isset( $_POST['tpsgallery_caption_color_text'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_caption_color_text', sanitize_hex_color( $_POST['tpsgallery_caption_color_text'] ) );
	    }

	    // Sanitize and save 'tpsgallery_caption_font_size' field
	    if ( isset( $_POST['tpsgallery_caption_font_size'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_caption_font_size', intval( $_POST['tpsgallery_caption_font_size'] ) );
	    }

	    // Sanitize and save 'tpsgallery_caption_text_align' field
	    if ( isset( $_POST['tpsgallery_caption_text_align'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_caption_text_align', sanitize_text_field( $_POST['tpsgallery_caption_text_align'] ) );
	    }

	    // Sanitize and save 'tpsgallery_columns' field
	    if ( isset( $_POST['tpsgallery_columns'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_columns', sanitize_text_field( $_POST['tpsgallery_columns'] ) );
	    }

	    // Sanitize and save 'tpsgallery_nav_value' field with a default fallback
	    if ( isset( $_POST['tpsgallery_nav_value'] ) ) {
	        update_post_meta( $post_id, 'tpsgallery_nav_value', intval( $_POST['tpsgallery_nav_value'] ) );
	    } else {
	        update_post_meta( $post_id, 'tpsgallery_nav_value', 1 );
	    }


		#Checks for input and saves if needed
		if( isset( $_POST[ 'tp_website_input' ] ) ) {
			update_post_meta( $post_id, 'tp_website_input', sanitize_text_field( $_POST[ 'tp_website_input' ] ) );
		}

		#Checks for input and saves if needed
		if( isset( $_POST[ 'tp_website_target_id' ] ) ) {
			update_post_meta( $post_id, 'tp_website_target_id', sanitize_text_field( $_POST[ 'tp_website_target_id' ] ) );
		}
		
		#Checks for input and saves if needed
		if( isset( $_POST[ 'caption_color_bg' ] ) ) {
			update_post_meta( $post_id, 'caption_color_bg', sanitize_text_field( $_POST[ 'caption_color_bg' ] ) );
		}
		
		#Checks for input and saves if needed
		if( isset( $_POST[ 'caption_color_text' ] ) ) {
			update_post_meta( $post_id, 'caption_color_text', sanitize_hex_color ( $_POST[ 'caption_color_text' ] ) );
		}
		
		#Checks for input and saves if needed
		if( isset( $_POST[ 'show_hide_links' ] ) ) {
			update_post_meta( $post_id, 'show_hide_links', sanitize_text_field( $_POST[ 'show_hide_links' ] ) );
		}
		
		#Checks for input and saves if needed
		if( isset( $_POST[ 'caption_text_align' ] ) ) {
			update_post_meta( $post_id, 'caption_text_align', sanitize_text_field( $_POST[ 'caption_text_align' ] ) );
		}
		
		#Checks for input and saves if needed
		if( isset( $_POST[ 'caption_font_size' ] ) ) {
			update_post_meta( $post_id, 'caption_font_size', sanitize_text_field( $_POST[ 'caption_font_size' ] ) );
		}
		
		#Checks for input and saves if needed
		if( isset( $_POST[ 'show_hide_lightboxes' ] ) ) {
			update_post_meta( $post_id, 'show_hide_lightboxes', sanitize_text_field( $_POST[ 'show_hide_lightboxes' ] ) );
		}

		#Checks for input and saves
		if( isset( $_POST[ 'overlay_color_alpha' ] ) ) {
			update_post_meta( $post_id, 'overlay_color_alpha', esc_html($_POST['overlay_color_alpha']) );
		}

		#Checks for input and saves
		if( isset( $_POST[ 'overlay_icons_bg' ] ) ) {
			update_post_meta( $post_id, 'overlay_icons_bg', esc_html($_POST['overlay_icons_bg']) );
		}

		#Checks for input and saves
		if( isset( $_POST[ 'overlay_color_icons' ] ) ) {
			update_post_meta( $post_id, 'overlay_color_icons', esc_html($_POST['overlay_color_icons']) );
		}

		#Checks for input and saves
		if( isset( $_POST[ 'tpsgallery_back_color' ] ) ) {
			update_post_meta( $post_id, 'tpsgallery_back_color', esc_html($_POST['tpsgallery_back_color']) );
		}

		#Checks for input and saves
		if( isset( $_POST[ 'tpsgallery_types_id' ] ) ) {
			update_post_meta( $post_id, 'tpsgallery_types_id', esc_html($_POST['tpsgallery_types_id']) );
		}

		#Checks for input and saves
		if( isset( $_POST[ 'tpsgallery_types_inc' ] ) ) {
			update_post_meta( $post_id, 'tpsgallery_types_inc', esc_html($_POST['tpsgallery_types_inc']) );
		}

	}
	add_action( 'save_post', 'tpsgallery_meta_box_save_func' );
	# Custom metabox field end