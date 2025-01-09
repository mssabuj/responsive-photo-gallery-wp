<?php
	if( !defined( 'ABSPATH' ) ){
		exit;
	}

	function tp_custom_photo_gallery_post_register() {

		# Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Photo Gallery', 'Post Type General Name', 'tpcgallery' ),
			'singular_name'       => _x( 'Photo Gallery', 'Post Type Singular Name', 'tpcgallery' ),
			'menu_name'           => __( 'Photo Gallery', 'tpcgallery' ),
			'parent_item_colon'   => __( 'Parent Image', 'tpcgallery' ),
			'all_items'           => __( 'All Images', 'tpcgallery' ),
			'view_item'           => __( 'View Image', 'tpcgallery' ),
			'add_new_item'        => __( 'Add New Image', 'tpcgallery' ),
			'add_new'             => __( 'Add New Image', 'tpcgallery' ),
			'edit_item'           => __( 'Edit Image', 'tpcgallery' ),
			'update_item'         => __( 'Update Image', 'tpcgallery' ),
			'search_items'        => __( 'Search Image', 'tpcgallery' ),
			'not_found'           => __( 'Not Found', 'tpcgallery' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'tpcgallery' ),
		);

		# Set other options for Custom Post Type
		$args = array(
			'label'               => __( 'photogallerys', 'tpcgallery' ),
			'description'         => __( 'Gallery reviews', 'tpcgallery' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail', 'editor'),
			'taxonomies'          => array( 'genres' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		// Registering your Custom Post Type
		register_post_type( 'tp_photo_gallery', $args );

	}
	add_action( 'init', 'tp_custom_photo_gallery_post_register', 0 );


	/**
	 * Register custom taxonomy for 'tp_photo_gallery' post type.
	 */
	function tp_custom_photo_gallery_taxonomies_register() {
	    $labels = array(
	        'name'              => _x( 'Categories', 'taxonomy general name', 'tpcgallery' ),
	        'singular_name'     => _x( 'Category', 'taxonomy singular name', 'tpcgallery' ),
	        'search_items'      => __( 'Search Categories', 'tpcgallery' ),
	        'all_items'         => __( 'All Categories', 'tpcgallery' ),
	        'parent_item'       => __( 'Parent Category', 'tpcgallery' ),
	        'parent_item_colon' => __( 'Parent Category:', 'tpcgallery' ),
	        'edit_item'         => __( 'Edit Category', 'tpcgallery' ),
	        'update_item'       => __( 'Update Category', 'tpcgallery' ),
	        'add_new_item'      => __( 'Add New Category', 'tpcgallery' ),
	        'new_item_name'     => __( 'New Category Name', 'tpcgallery' ),
	        'menu_name'         => __( 'Categories', 'tpcgallery' ),
	    );

	    $args = array(
	        'hierarchical'      => true,   // Hierarchical like categories.
	        'labels'            => $labels, // Use custom labels for the taxonomy.
	        'show_ui'           => true,   // Show the UI in the WordPress admin.
	        'show_admin_column' => true,   // Display it as a column in the admin post list.
	        'query_var'         => true,   // Enable query variables for this taxonomy.
	        'rewrite'           => array( 'slug' => 'gallery-category' ), // Custom rewrite slug.
	    );

	    register_taxonomy( 'tpgallerycat', array( 'tp_photo_gallery' ), $args );
	}
	add_action( 'init', 'tp_custom_photo_gallery_taxonomies_register', 0 );


	/**
	 * Define custom columns for the 'tp_photo_gallery' post type.
	 *
	 * @param array $columns The existing columns.
	 * @return array Modified columns for the 'tp_photo_gallery' post type.
	 */
	function tpcgallery_post_columns( $columns ) {
	    // Toggle order based on the current order query parameter (asc/desc)
	    $order = isset( $_GET['order'] ) && $_GET['order'] === 'asc' ? 'desc' : 'asc';

	    // Define new columns
	    $columns = array(
	        "cb"                      => "<input type=\"checkbox\" />",  // Checkbox for bulk actions.
	        "thumbnail"               => __( 'Image', 'tpcgallery' ),   // Thumbnail column.
	        "title"                   => __( 'Name', 'tpcgallery' ),    // Post title.
	        "tpcgallery_catcols_columns" => __( 'Categories', 'tpcgallery' ),  // Categories column.
	        "date"                    => __( 'Date', 'tpcgallery' ),    // Date column.
	    );

	    return $columns;
	}
	

	/**
	 * Display custom columns for the 'tp_photo_gallery' post type.
	 *
	 * @param string $column_name The name of the column to display.
	 * @param int    $post_id     The ID of the post being displayed.
	 */
	function tpcgallery_post_columns_display( $column_name, $post_id ) {
	    global $post;
	    $width = 80;  // Set the width for the thumbnail.
	    $height = 80; // Set the height for the thumbnail.

	    // Display the post thumbnail in the 'thumbnail' column.
	    if ( 'thumbnail' === $column_name ) {
	        if ( has_post_thumbnail( $post_id ) ) {
	            $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
	            $thumb = wp_get_attachment_image( $thumbnail_id, array( $width, $height ), true );
	            echo $thumb;
	        } else {
	            echo __( 'None', 'tpcgallery' );
	        }
	    }

	    // Display categories in the 'tpcgallery_catcols_columns' column.
	    if ( 'tpcgallery_catcols_columns' === $column_name ) {
	        $terms = get_the_terms( $post_id, 'tpgallerycat' ); // Get terms for the 'tpgallerycat' taxonomy.
	        if ( $terms && ! is_wp_error( $terms ) ) {
	            $term_links = array();
	            foreach ( $terms as $term ) {
	                $term_links[] = '<a href="' . esc_url( admin_url( 'edit.php?post_type=tp_photo_gallery&tpgallerycat=' . $term->slug ) ) . '">' . esc_html( $term->name ) . '</a>';
	            }
	            echo implode( ', ', $term_links );
	        } else {
	            echo __( 'No Categories', 'tpcgallery' );
	        }
	    }
	}


	# Add manage posts columns Filter 
	add_filter("manage_tp_photo_gallery_posts_columns", "tpcgallery_post_columns");

	# Add manage posts custom column Action
	add_action("manage_tp_photo_gallery_posts_custom_column",  "tpcgallery_post_columns_display", 10, 2 );


	# Add Option Page Generate Shortcode
	function tpcgallery_shortcode_submenu_page(){
		add_submenu_page('edit.php?post_type=tp_photo_gallery', __('Generate Shortcode', 'tpcgallery'), __('Generate Shortcode', 'tpcgallery'), 'manage_options', 'post-new.php?post_type=generategallery');
	}
	add_action('admin_menu', 'tpcgallery_shortcode_submenu_page');

	
	# Registering Post Type For Generate Shortcode
	function tpcgallery_generate_shortcode_post_types() {

		# Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'All Shortcodes', 'Post Type General Name' ),
			'singular_name'       => _x( 'Carousel Shortcode', 'Post Type Singular Name' ),
			'menu_name'           => __( 'Carousel Shortcode' ),
			'parent_item_colon'   => __( 'Parent Shortcode' ),
			'all_items'           => __( 'All Shortcodes' ),
			'view_item'           => __( 'View Shortcode' ),
			'add_new_item'        => __( 'Add New Shortcode' ),
			'add_new'             => __( 'Generate Shortcode' ),
			'edit_item'           => __( 'Edit Shortcode' ),
			'update_item'         => __( 'Update Shortcode' ),
			'search_items'        => __( 'Search Shortcode' ),
			'not_found'           => __( 'Not Found' ),
			'not_found_in_trash'  => __( 'Not found in Trash' )
		);

		# Set other options for Custom Post Type...
		$args = array(
			'labels'              => $labels,
			'label'               => __( 'carousel-sliders' ),
			'description'         => __( 'Carousel Slider news and reviews' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu' 		  => 'edit.php?post_type=tp_photo_gallery',
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'supports'            => array( 'title' ),
			'menu_icon'		      => 'dashicons-images-alt2'
		);
		register_post_type( 'generategallery', $args );
	}
	add_action( 'init', 'tpcgallery_generate_shortcode_post_types', 0 );

	#
	function tpcgallery_add_shortcode_column( $tpcgallerycolumns ) {
	 return array_merge( $tpcgallerycolumns, 
	  array(
	  		'shortcode' => __( 'Shortcode', 'tpcgallery' ),
	  		'doshortcode' => __( 'Template Shortcode', 'tpcgallery' ) )
	   );
	}
	add_filter( 'manage_generategallery_posts_columns' , 'tpcgallery_add_shortcode_column' );

	#
	function tpcgallery_add_shortcode_column_display( $tpcgallery_column, $post_id ) {
		 if ( $tpcgallery_column == 'shortcode' ){
		  ?>
		  <input style="background:#ddd" type="text" onClick="this.select();" value="[tps_gallery <?php echo 'id=&quot;'.$post_id.'&quot;';?>]" />
		  <?php
		}
		if ( $tpcgallery_column == 'doshortcode' ){
		?>
		<textarea cols="40" rows="2" style="background:#ddd;" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[tps_gallery id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea>
		<?php
		}
	}
	add_action( 'manage_generategallery_posts_custom_column' , 'tpcgallery_add_shortcode_column_display', 10, 2 );