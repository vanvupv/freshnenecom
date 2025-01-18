<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Product_Custom_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Product_Custom_Widget';
    }

    public function get_title()
    {
        return __('Product Custom', 'child_theme');
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
            'selected_products',
            [
                'label' => __('Select Products', 'child_theme'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_products(), // Lấy danh sách sản phẩm từ hàm get_products()
                'multiple' => false, // Cho phép chọn nhiều sản phẩm
                'default' => [],
                'description' => __('Select products to display in the widget.', 'child_theme'), // Thêm mô tả
            ]
        );

        $this->end_controls_section();
    }

    private function get_products()
    {
        $args = [
            'post_type' => 'product',     // Kiểu post là sản phẩm
            'posts_per_page' => 10,       // Lấy 10 sản phẩm
            'post_status' => 'publish',   // Chỉ lấy sản phẩm đã được công khai
        ];

        $query = new WP_Query($args);

        $options = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                // Lấy đối tượng sản phẩm
                $product = wc_get_product(get_the_ID());

                // Thêm vào mảng options với ID sản phẩm là key và tên sản phẩm là value
                $options[$product->get_id()] = $product->get_name();
            }
        } else {
            echo 'Không có sản phẩm nào.';
        }
        wp_reset_postdata(); // Đặt lại dữ liệu sau khi query xong

        return $options;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Lấy danh sách ID sản phẩm từ thiết lập
        $product_ids = $settings['selected_products']; // Giả sử đây là ID sản phẩm bạn đã chọn

        // Kiểm tra xem có ID nào trong mảng không
        if (!empty($product_ids)) {
            // Tạo câu truy vấn để lấy sản phẩm theo ID
            $args = [
                'post_type' => 'product',     // Kiểu post là sản phẩm
                'posts_per_page' => -1,       // Lấy tất cả sản phẩm theo ID đã chọn
                // 'post_status' => 'publish',   // Chỉ lấy sản phẩm đã được công khai
                'post__in' => [$product_ids],   // Lọc theo các ID sản phẩm
                'orderby' => 'post__in',      // Giữ đúng thứ tự của ID đã chọn
            ];

            $query = new WP_Query($args);

            // Kiểm tra có bài viết nào trong query không
            if ($query->have_posts()) {
                echo '<div class="custom-products-container">';
                // Lặp qua các sản phẩm
                while ($query->have_posts()) {
                    $query->the_post();
                    // Gọi hàm render_product() để hiển thị sản phẩm
                    include CHILD_PATH . '/template-parts/product.php'; // Hiển thị sản phẩm theo ID
                }
                echo '</div>';
            } else {
                echo '<p>' . __('No products found.', 'child_theme') . '</p>';
            }
            // 
            wp_reset_postdata(); // Đặt lại dữ liệu sau khi query xong
        } else {
            echo '<p>' . __('No products selected.', 'child_theme') . '</p>';
        }
    }
}
