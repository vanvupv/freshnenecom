<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Post_Banner_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Post_Banner_Widget';
    }

    public function get_title()
    {
        return __('Post Banner', 'child_theme');
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

        $this->add_control(
            'selected_posts',
            [
                'label' => __('Select Products', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_posts(), // Lấy danh sách sản phẩm từ hàm get_products()
                'multiple' => false, // Cho phép chọn nhiều sản phẩm
                'default' => [],
                'description' => __('Select products to display in the widget.', 'child_theme'), // Thêm mô tả
            ]
        );

        $this->end_controls_section();
    }

    private function get_posts()
    {
        $args = [
            'post_type' => 'post',       // Kiểu post là bài viết
            'posts_per_page' => 10,           // Lấy 10 bài viết
            'post_status' => 'publish',    // Chỉ lấy bài viết đã được công khai
        ];

        $query = new WP_Query($args);

        $options = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                // Lấy ID và tiêu đề bài viết
                $post_id = get_the_ID();
                $post_title = get_the_title();

                // Thêm vào mảng options với ID bài viết là key và tiêu đề là value
                $options[$post_id] = $post_title;
            }
        } else {
            echo 'Không có bài viết nào.';
        }

        wp_reset_postdata(); // Đặt lại dữ liệu sau khi query xong

        return $options;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Lấy danh sách ID sản phẩm từ thiết lập
        $product_ids = $settings['selected_posts']; // Giả sử đây là ID sản phẩm bạn đã chọn

        //
        // Kiểm tra xem có ID nào trong mảng không
        if (!empty($product_ids)) {
            // Tạo câu truy vấn để lấy sản phẩm theo ID
            $args = [
                'post_type' => 'post',     // Kiểu post là sản phẩm
                'posts_per_page' => -1,       // Lấy tất cả sản phẩm theo ID đã chọn
                // 'post_status' => 'publish',   // Chỉ lấy sản phẩm đã được công khai
                'post__in' => [$product_ids],   // Lọc theo các ID sản phẩm
                'orderby' => 'post__in',      // Giữ đúng thứ tự của ID đã chọn
            ];
            $query = new WP_Query($args);

            // Kiểm tra có bài viết nào trong query không
            if ($query->have_posts()) {
                // Lặp qua các sản phẩm
                while ($query->have_posts()) {
                    $query->the_post();
                    ?>
                    <div class="blog-card">
                        <div class="blog-image">
                            <?php if (has_post_thumbnail()): ?>
                                <a class="d-block blog-content__img" href="<?php the_permalink(); ?>">
                                    <?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
                                </a>
                            <?php endif; ?>
                            <div class="blog-content">
                                <span class="blog-tag">Tag</span>
                                <h2 class="blog-title">
                                    <?php echo get_the_title(); ?>
                                </h2>
                                <div class="blog-meta">
                                    <div class="author-avatar"></div>
                                    <div class="meta-info">
                                        <span class="author-name"> <?php echo get_the_author_meta('nickname'); ?></span>
                                        <span class="publish-date"><?php echo get_the_date('d/m/Y'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            wp_reset_postdata(); // Đặt lại dữ liệu sau khi query xong
        }
    }
}


