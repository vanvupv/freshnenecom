<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Month_Year_Filter_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Month_Year_Filter_Widget';
    }

    public function get_title()
    {
        return __('Month and Year Filter', 'child_theme');
    }

    public function get_icon()
    {
        return 'eicon-calendar'; // https://elementor.github.io/elementor-icons/
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
        // Lấy danh sách tháng và năm từ bài viết
        global $wpdb;
        $results = $wpdb->get_results("
            SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
            FROM {$wpdb->posts}
            WHERE post_type = 'post' AND post_status = 'publish'
            ORDER BY year DESC, month DESC
        ");

        if (!empty($results)): ?>
            <div class="monthYearFilter">
                <ul>
                    <?php
                    foreach ($results as $result) {
                        $month_name = date('F', mktime(0, 0, 0, $result->month, 1));
                        $archive_link = add_query_arg(
                            ['month' => $result->month, 'year' => $result->year],
                            home_url('/')
                        );
                        echo '<li><a href="' . esc_url($archive_link) . '">' . esc_html($month_name . ' ' . $result->year) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        <?php else: ?>
            <p><?php _e('No archives available!', 'child_theme'); ?></p>
        <?php endif;
    }
}
