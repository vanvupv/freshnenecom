<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'Search_Widget';
    }

    public function get_title()
    {
        return __('Search', 'child_theme');
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

        // Thêm ô select để chọn post type
        $this->add_control(
            'post_type',
            [
                'label' => __('Select Post Type', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $this->get_post_types()
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Number of Posts', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    10 => '10',
                    15 => '15',
                    20 => '20',
                    25 => '25',
                    30 => '30',
                    35 => '35',
                    40 => '40',
                    45 => '45',
                    50 => '50',
                ],
                'default' => '10',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Number of Columns', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 3,
                'options' => [
                    1 => __('1 Columns', 'child_theme'),
                    2 => __('2 Columns', 'child_theme'),
                    3 => __('3 Columns', 'child_theme'),
                    4 => __('4 Columns', 'child_theme'),
                    6 => __('6 Columns', 'child_theme'),
                    12 => __('12 Columns', 'child_theme'),
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'device_default' => [
                    'desktop' => 3,
                    'tablet' => 2,
                    'mobile' => 1,
                ],
            ]
        );

        $this->add_control(
            'enable_pagination',
            [
                'label' => __('Enable Pagination', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'child_theme'),
                'label_off' => __('No', 'child_theme'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    private function get_post_types()
    {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = [];
        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->label;
        }
        return $options;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="search-container">
            <div class="dropdown">
                <select>
                    <option>All categories</option>
                    <option>Category 1 Category 1</option>
                    <option>Category 2</option>
                    <option>Category 3</option>
                </select>
            </div>
            <input type="text" class="search-input" placeholder="Search Products, categories...">
            <button type="submit" class="search-button"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9.19303 11.4333C11.7704 11.4333 13.8597 9.34394 13.8597 6.76661C13.8597 4.18928 11.7704 2.09995 9.19303 2.09995C6.61571 2.09995 4.52637 4.18928 4.52637 6.76661C4.52637 9.34394 6.61571 11.4333 9.19303 11.4333Z"
                        stroke="#151515" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="bevel" />
                    <path d="M5.81319 10.24L2.68652 13.3667" stroke="#151515" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="bevel" />
                </svg>
            </button>
        </div>
        <?php
    }
}
