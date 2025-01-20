<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Related_Post_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Related_Post_Widget';
    }

    public function get_title()
    {
        return __('Related Post', 'child_theme');
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
        //
        $bai_viet_lien_quan = get_field('bai_viet_lien_quan') ?? [];
        $post_id = get_the_ID();

        // Loại bỏ bài viết hiện tại khỏi danh sách ID
        $filtered_ids = array_diff($bai_viet_lien_quan, array($post_id));
        if (!empty($filtered_ids)) {
            $query = new WP_Query(array(
                'post_type' => 'post',          // Loại bài viết
                'post__in' => $filtered_ids,  // Lấy bài viết theo danh sách ID đã lọc
                'orderby' => 'post__in',     // Sắp xếp theo thứ tự trong mảng $filtered_ids
                'posts_per_page' => -1,             // Lấy tất cả bài viết phù hợp
            ));

            if ($query->have_posts()) {
                ?>
                <div class="related_post">
                    <div class="row">
                        <?php
                        while ($query->have_posts()) {
                            $query->the_post(); ?>
                            <div class="col-3">
                                <?php include CHILD_PATH . '/template-parts/post.php'; // Hiển thị sản phẩm theo ID ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
            // Khôi phục lại truy vấn gốc
            wp_reset_postdata();
        }
    }
}
