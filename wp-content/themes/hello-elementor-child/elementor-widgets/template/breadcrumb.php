<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Breadcrumb_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Breadcrum_Widget';
    }

    public function get_title()
    {
        return __('Breadcrum', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-code-bold'; // https://elementor.github.io/elementor-icons/
    }

    public function get_categories()
    {
        return ['custom_builder_theme'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'child_theme'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        wp_breadcrumbs();
    }
}

