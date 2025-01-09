<?php
	if ( ! defined( 'ABSPATH' ) ) exit; # Exit if accessed directly

	function tps_gallery_shortcode_query( $atts ) {
		global $post;
		ob_start();
		extract( shortcode_atts( array('id' => ''), $atts ) );
		$postid = $atts['id'];
		
		$tps_gallery_cat_name   		= get_post_meta($postid, 'tps_gallery_cat_name', true);
		$tpsgallery_theme_id           	= get_post_meta($postid, 'tpsgallery_theme_id', true);
		$tpsgallery_img_size           	= get_post_meta($postid, 'tpsgallery_img_size', true);
		$tpsgallery_img_captions        = get_post_meta($postid, 'tpsgallery_img_captions', true);
		$tpsgallery_captions_style      = get_post_meta($postid, 'tpsgallery_captions_style', true);
		$tpsgallery_captions_positions  = get_post_meta($postid, 'tpsgallery_captions_positions', true);
		$tpsgallery_caption_color		= get_post_meta($postid, 'tpsgallery_caption_color', true);
		$tpsgallery_caption_color_text	= get_post_meta($postid, 'tpsgallery_caption_color_text', true);
		$tpsgallery_caption_font_size	= get_post_meta($postid, 'tpsgallery_caption_font_size', true);
		$tpsgallery_caption_text_align	= get_post_meta($postid, 'tpsgallery_caption_text_align', true);
		$tpsgallery_columns       		= get_post_meta($postid, 'tpsgallery_columns', true);
		$tpsgallery_back_color       	= get_post_meta($postid, 'tpsgallery_back_color', true);

		// Fallback to 'full' size if no size is selected
		if ( ! $tpsgallery_img_size ) {
		    $tpsgallery_img_size = 'full';
		}
		

		if( !empty( $tps_gallery_cat_name ) ) {
			$tps_gallerycat =  array();
			$num = count($tps_gallery_cat_name);
			for($j=0; $j<$num; $j++){
				array_push($tps_gallerycat, $tps_gallery_cat_name[$j]);
			}
			$args = array(
				'post_type' 	 	=> 'tp_photo_gallery',
				'post_status'	 	=> 'publish',
				'posts_per_page' 	=> -1,
				'tax_query' 	 	=> array(
					array(
						'taxonomy' 	=> 'tpgallerycat',
						'field' 	=> 'id',
						'terms' 	=> $tps_gallerycat,
					)
				)
			);
		}else {
			$args = array(
				'post_type' 		=> 'tp_photo_gallery',
				'post_status' 		=> 'publish',
				'posts_per_page' 	=> -1,
			);
		}
		
	$pages_query = new WP_Query( $args );
	
	switch ( $tpsgallery_theme_id ) {
		case '1': ?>
			<style type="text/css">
			.tpsgallery-style-01-<?php echo esc_attr( $postid ); ?> img:hover {
			  color: #fff;
			  content: "";
			  cursor: crosshair;
			}
			.tpsgallery-style-01-<?php echo esc_attr( $postid ); ?> {
			  background: <?php echo esc_attr($tpsgallery_back_color); ?>;
			  display: block;
			  overflow: hidden;
			  padding-top:10px;
			}
			.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?> {
				position: relative;
			}
			
			<?php
			if($tpsgallery_captions_style == 1){ ?>
				<?php
				if($tpsgallery_captions_positions == 1){ ?>
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?> span {
						background: <?php echo esc_attr( $tpsgallery_caption_color ); ?>;
						border: 0 none;
						color: <?php echo esc_attr( $tpsgallery_caption_color_text ); ?>;
						font-size: <?php echo esc_attr( $tpsgallery_caption_font_size ); ?>px;
						text-align: <?php echo esc_attr( $tpsgallery_caption_text_align ); ?>;
						padding: 15px;
						width: 100%;
						display: block;
						overflow: hidden;
					}
				<?php
				}
				elseif($tpsgallery_captions_positions == 2){ ?>
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?> span {
						background: <?php echo esc_attr( $tpsgallery_caption_color ); ?>;
						border: 0 none;
						color: <?php echo esc_attr( $tpsgallery_caption_color_text ); ?>;
						font-size: <?php echo esc_attr( $tpsgallery_caption_font_size ); ?>px;
						text-align: <?php echo esc_attr( $tpsgallery_caption_text_align ); ?>;
						height: 34px;
						left: 0;
						line-height: 20px;
						margin: 0;
						opacity: 1;
						padding: 5px;
						position: absolute;
						text-shadow: 1px 1px 1px hsla(0, 0%, 0%, 0.75);
						transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s;
						width: 100%;
						top:0px;
					}
					<?php
				}
				elseif($tpsgallery_captions_positions == 3){ ?>
				.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?> span {
					background: <?php echo esc_attr( $tpsgallery_caption_color ); ?>;
					border: 0 none;
					color: <?php echo esc_attr( $tpsgallery_caption_color_text ); ?>;
					font-size: <?php echo esc_attr( $tpsgallery_caption_font_size ); ?>px;
					text-align: <?php echo esc_attr( $tpsgallery_caption_text_align ); ?>;
					height: 34px;
					left: 0;
					line-height: 20px;
					margin: 0;
					opacity: 1;
					padding: 5px;
					position: absolute;
					text-shadow: 1px 1px 1px hsla(0, 0%, 0%, 0.75);
					transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s;
					width: 100%;
					margin-top:-34px;
				}
				<?php
				}
				elseif($tpsgallery_captions_positions == 4){ ?>
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?> span {
						background: <?php echo esc_attr( $tpsgallery_caption_color ); ?>;
						border: 0 none;
						color: <?php echo esc_attr( $tpsgallery_caption_color_text ); ?>;
						font-size: <?php echo esc_attr( $tpsgallery_caption_font_size ); ?>px;
						text-align: <?php echo esc_attr( $tpsgallery_caption_text_align ); ?>;
						height: 34px;
						left: 0;
						line-height: 20px;
						margin: 0;
						opacity: 1;
						padding: 5px;
						position: absolute;
						text-shadow: 1px 1px 1px hsla(0, 0%, 0%, 0.75);
						transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s;
						width: 100%;
						top:50%;
						margin-top: -24px;
					}
					<?php
				}
			}
			elseif($tpsgallery_captions_style == 2){ ?>
				<?php
				if($tpsgallery_captions_positions == 1){?>
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?> span {
						background: <?php echo esc_attr( $tpsgallery_caption_color ); ?>;
						border: 0 none;
						color: <?php echo esc_attr( $tpsgallery_caption_color_text ); ?>;
						font-size: <?php echo esc_attr( $tpsgallery_caption_font_size ); ?>px;
						text-align: <?php echo esc_attr( $tpsgallery_caption_text_align ); ?>;
						height: 34px;
						left: 0;
						line-height: 20px;
						margin: 0;
						opacity: 0;
						padding: 5px;
						position: absolute;
						text-shadow: 1px 1px 1px hsla(0, 0%, 0%, 0.75);
						transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s;
						width: 100%;
					}
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?>:hover span{
						opacity:1;
						margin-top:-34px;
					}
					<?php
				}
				if($tpsgallery_captions_positions == 2){?>
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?> span {
						background: <?php echo esc_attr( $tpsgallery_caption_color ); ?>;
						border: 0 none;
						color: <?php echo esc_attr( $tpsgallery_caption_color_text ); ?>;
						font-size: <?php echo esc_attr( $tpsgallery_caption_font_size ); ?>px;
						text-align: <?php echo esc_attr( $tpsgallery_caption_text_align ); ?>;
						height: 34px;
						left: 0;
						line-height: 20px;
						margin: 0;
						opacity: 0;
						padding: 5px;
						position: absolute;
						text-shadow: 1px 1px 1px hsla(0, 0%, 0%, 0.75);
						transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s;
						width: 100%;
						top:-34px;
					}
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?>:hover span{
						opacity:1;
						top:0px;
					}
					<?php
				}
				if($tpsgallery_captions_positions == 3){?>
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?> span {
						background: <?php echo esc_attr( $tpsgallery_caption_color ); ?>;
						border: 0 none;
						color: <?php echo esc_attr( $tpsgallery_caption_color_text ); ?>;
						font-size: <?php echo esc_attr( $tpsgallery_caption_font_size ); ?>px;
						text-align: <?php echo esc_attr( $tpsgallery_caption_text_align ); ?>;
						height: 34px;
						left: 0;
						line-height: 20px;
						margin: 0;
						opacity: 0;
						padding: 5px;
						position: absolute;
						text-shadow: 1px 1px 1px hsla(0, 0%, 0%, 0.75);
						transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s;
						width: 100%;
					}
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?>:hover span{
						opacity:1;
						margin-top:-34px;
					}
					<?php
				}
				if($tpsgallery_captions_positions == 4){?>
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?> span {
						background: <?php echo esc_attr( $tpsgallery_caption_color ); ?>;
						border: 0 none;
						color: <?php echo esc_attr( $tpsgallery_caption_color_text ); ?>;
						font-size: <?php echo esc_attr( $tpsgallery_caption_font_size ); ?>px;
						text-align: <?php echo esc_attr( $tpsgallery_caption_text_align ); ?>;
						height: 34px;
						left: 0;
						line-height: 20px;
						margin: 0;
						opacity: 0;
						padding: 5px;
						position: absolute;
						text-shadow: 1px 1px 1px hsla(0, 0%, 0%, 0.75);
						transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s;
						width: 100%;
						top:-34px;
					}
					.tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?>:hover span{
						opacity:1;
						top:50%;
						margin-top:-24px;
					}
					<?php
				}
			}
			?>
			</style>
			
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$(".tpsgallery-style-01-<?php echo esc_attr( $postid ); ?>").lightGallery();
				});
			</script>

			<?php if ( $pages_query->have_posts() ) { ?>
				<div class="tpsgallery-style-01-<?php echo esc_attr( $postid ); ?>">
					<?php while ( $pages_query->have_posts() ) : $pages_query->the_post();
						$featured_image 		= wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					?>
					<div class="tpsgallery-col-lg-<?php echo esc_attr( $tpsgallery_columns ); ?> tpsgallery-col-md-2 tpsgallery-col-sm-2 tpsgallery-col-xs-1" data-src="<?php echo $featured_image; ?>">
						<div class="tpsgallery-style-01-thumb-<?php echo esc_attr( $postid ); ?>">
							<?php if ( has_post_thumbnail() ) { ?>
								<div class="tpsgallery-thumbnail">
									<?php the_post_thumbnail( $tpsgallery_img_size ); ?>
								</div>
							<?php } ?>
							<div class="tpsgallery-caption-area">
								<?php if( $tpsgallery_img_captions == 1 ){ ?>
									<span class="tps-gallery-captions"> <?php the_title();?> </span>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php endwhile;?>
				</div>
			<?php }
			break;
		}
		$myvariable_pages = ob_get_clean();
		wp_reset_postdata();
		return $myvariable_pages;
	}
	add_shortcode( 'tps_gallery', 'tps_gallery_shortcode_query' );