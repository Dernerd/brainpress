<?php
/**
 * BrainPress Theme Customizer
 *
 * @package WordPress
 * @subpackage BrainPress_Theme
 **/
class BrainPress_Theme_Customizer {
	public static $customizer;

	public static function init( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		$colors = array();

		$colors[] = array(
			'slug' => 'body_text_color',
			'default' => '#878786',
			'label' => __( 'Body Text Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'content_text_color',
			'default' => '#666666',
			'label' => __( 'Content Text Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'content_header_color',
			'default' => '#878786',
			'label' => __( 'Content Header Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'content_link_color',
			'default' => '#1cb8ea',
			'label' => __( 'Content Links Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'content_link_hover_color',
			'default' => '#1cb8ea',
			'label' => __( 'Content Links Hover Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'main_navigation_link_color',
			'default' => '#666',
			'label' => __( 'Main Navigation Links Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'main_navigation_link_hover_color',
			'default' => '#74d1d4',
			'label' => __( 'Main Navigation Links Hover Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'footer_background_color',
			'default' => '#f2f6f8',
			'label' => __( 'Footer Background Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'footer_link_color',
			'default' => '#83abb6',
			'label' => __( 'Footer Links Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'footer_link_hover_color',
			'default' => '#74d1d4',
			'label' => __( 'Footer Links Hover Color', 'brainpress' ),
		);

		$colors[] = array(
			'slug' => 'widget-text-color',
			'default' => '#c0c21e',
			'label' => __( 'Widgets Title Color', 'brainpress' ),
		);

		sort( $colors );

		foreach ( $colors as $color ) {
			// SETTINGS.
			$wp_customize->add_setting(
				$color['slug'],
				array(
					'default' => $color['default'],
					'type' => 'option',
					'capability' => 'edit_theme_options',
				)
			);

			// CONTROLS.
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'],
					array(
						'label' => $color['label'],
						'section' => 'colors',
						'setting' => $color['slug'],
					)
				)
			);

		}


		if ( ! function_exists( 'get_custom_logo' ) ) {
			// Logo fallback for WP earlier version
			$wp_customize->add_section(
				'cp_logo_section',
				array(
					'title' => __( 'Logo', 'brainpress' ),
					'priority' => 1,
				)
			);

			$wp_customize->add_setting(
				'brainpress_logo',
				array(
					'default' => get_template_directory_uri() . '/images/logo-default.png',
					'type' => 'theme_mod',
					'capability' => 'edit_theme_options',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'logo',
					array(
						'label' => __( 'Upload a logo', 'brainpress' ),
						'section' => 'cp_logo_section',
						'settings' => 'brainpress_logo',
					)
				)
			);
		}
	}

	public static function customize_preview_js() {
		wp_enqueue_script(
			'brainpress_customizer',
			get_template_directory_uri() . '/js/customizer.js',
			array( 'customize-preview' ),
			BrainPress::$version,
			true
		);
	}
}
// Register customizer
add_action( 'customize_register', array( 'BrainPress_Theme_Customizer', 'init' ) );
/** Binds JS handlers to make Theme Customizer preview reload changes asynchronously. **/
add_action( 'customize_preview_init', array( 'BrainPress_Theme_Customizer', 'customize_preview_js' ) );