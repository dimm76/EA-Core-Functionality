<?php
/**
 * Advanced Custom Fields
 *
 * @package    DMKTCore
 * @version    1.0
 * @author     Bill Erickson & Diego Medina
 * @copyright  Copyright (c) 2020, Diego Medina
 * @license    GPL-2.0+
 * 
 * Based in original CoreFunctionality acf.php file v2.0
 */

class DMKT_ACF_Customizations {
	
	public function __construct() {

		// Only allow fields to be edited on development
		if ( ! defined( 'WP_LOCAL_DEV' ) || ! WP_LOCAL_DEV ) {
			add_filter( 'acf/settings/show_admin', '__return_false' );
		}

		// Save fields in functionality plugin
		add_filter( 'acf/settings/save_json', array( $this, 'get_local_json_path' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'add_local_json_path' ) );

		// Register options page
		//add_action( 'init', array( $this, 'register_options_page' ) );

		// Register Block Category
		add_filter( 'block_categories', array( $this, 'dmkt_block_category'), 10, 2  );

		// Register Blocks
		if( function_exists('acf_register_block_type') ) {
			add_action('acf/init', array($this, 'dmkt_register_acf_block_types' ) );
		}

		// Adds image size for images block
		add_image_size( 'big-image-block', 1100, 800, true );
		//add_image_size( 'text-image-block', 700, 800, true );

	}


	/**
	 * Define where the local JSON is saved
	 *
	 * @return string
	 */
	public function get_local_json_path() {
		return DMKT_DIR . '/acf-json';
	}

	/**
	 * Add our path for the local JSON
	 *
	 * @param array $paths
	 *
	 * @return array
	 */
	public function add_local_json_path( $paths ) {
		$paths[] = DMKT_DIR . '/acf-json';

		return $paths;
	}

	/**
	 * Register Options Page
	 *
	 */
	function register_options_page() {
	    if ( function_exists( 'acf_add_options_page' ) ) {
	        acf_add_options_page( array(
	        	'title'      => __( 'Site Options', 'core-functionality' ),
	        	'capability' => 'manage_options',
	        ) );
	    }
	}



	/**
	 * Creating block categories for the menu content editor
	 *
	 */
	function dmkt_block_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'schotten-blocks',
					'title' => __( 'Schotten&Woods Blocks', 'dmkt' ),
				),
			)
		);
	}


	/**
	 * Enqueue acf-blocks styles
	 *
	 */      
	function dmkt_enqueue_block_styles() {
		$plugin_url = plugin_dir_url( __DIR__ );

		wp_enqueue_style( 'dmkt-blocks', $plugin_url . 'css/blocks-styles.css',false,'1.0.0','all');

	}



	/**
	 * Register Blocks
	 * @link https://www.billerickson.net/building-gutenberg-block-acf/#register-block
	 *
	 * Categories: common, formatting, layout, widgets, embed
	 * Dashicons: https://developer.wordpress.org/resource/dashicons/
	 * ACF Settings: https://www.advancedcustomfields.com/resources/acf_register_block/
	 * Some blocks are shown as examples
	 */

	function dmkt_register_acf_block_types() {

		/**
		 * register a projects slider block
		 * Example of slider with owl-carousel library. Sometimes you must load the library from the
		 */ 

		acf_register_block_type(array(
			'name'              => 'dmkt-post-slider',
			//'post_types' 		=> array('proyectos'), // Limit block to project post type
			'title'             => __('Projects slider'),
			'description'       => __('Inserta un slider con los últimos proyectos.'),
			'render_template'   => DMKT_DIR . '/block-templates/dmkt-post-slider.php',
			'category'          => 'schotten-blocks',
			'mode' 				=> 'preview',
			'icon'              => array(
				// Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
				'foreground' => '#B76203',
				// Specifying a dashicon for the block
				'src' => 'slides',
			),
			'keywords'          => array( 'proyectos', 'proyectos slide' ),
			'supports' 			=> array( 'align' =>false ),
			'enqueue_assets' => function(){
				wp_enqueue_style( 'owl-carousel', plugin_dir_url( __DIR__ ) . 'css/owl.carousel.css' );
				wp_enqueue_style( 'owl-theme', plugin_dir_url( __DIR__ ) . 'css/owl.theme.default.min.css' );
				wp_enqueue_style( 'dmkt-blocks', plugin_dir_url( __DIR__ ) . 'css/blocks-styles.css' );
			  },
		));   


		/**
		 * register schottenwood icono + texto
		 * Example of a block that supports the align property of wordpress
		 */ 
		acf_register_block_type(array(
			'name'              => 'sw-icon-text',
			//'post_types' 		=> array('proyectos'), // Limit block to project post type
			'title'             => __('SW Icono + texto'),
			'description'       => __('Inserta un bloque de icono + texto.'),
			'render_template'   => DMKT_DIR . '/block-templates/dmkt-icone-text.php',
			'category'          => 'schotten-blocks',
			'mode' 				=> 'preview',
			'icon'              => array(
				// Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
				'foreground' => '#B76203',
				// Specifying a dashicon for the block
				'src' => 'star-filled',
			),
			'keywords'          => array( 'icono+texto' ),
			'supports' 			=> array( 'align' =>true ),
			'enqueue_assets' 	=> array( $this, 'dmkt_enqueue_block_styles' ),	
		));  

	}
}
new DMKT_ACF_Customizations();

