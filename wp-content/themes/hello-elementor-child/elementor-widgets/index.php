<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

function register_custom_widgets($widgets_manager)
{
    // include file
    require_once TEMPLATE_PATH . 'header--1.php';
    require_once TEMPLATE_PATH . 'duplicate_widget.php';
    require_once TEMPLATE_PATH . 'search.php';
    require_once TEMPLATE_PATH . 'slider_slick.php';
    require_once TEMPLATE_PATH . 'product_custom.php';
    require_once TEMPLATE_PATH . 'product_tag.php';

    // Register widgets product_custom
    $widgets_manager->register(new \Header_Widget());
    $widgets_manager->register(new \Duplicate_Widget());
    $widgets_manager->register(new \Search_Widget());
    $widgets_manager->register(new \Slider_Slick_Widget());
    $widgets_manager->register(new \Product_Custom_Widget());
    $widgets_manager->register(new \Product_Tag_Widget());
}
add_action('elementor/widgets/register', 'register_custom_widgets');

function register_custom_widget_category($elements_manager)
{
    $elements_manager->add_category(
        'custom_widgets_theme',
        [
            'title' => __('Custom Widgets', 'child_theme'),
            'priority' => 0,
        ]
    );

    $elements_manager->add_category(
        'custom_builder_theme',
        [
            'title' => __('Custom Builder', 'child_theme'),
            'priority' => 1,
        ]
    );
}
add_action('elementor/elements/categories_registered', 'register_custom_widget_category');
