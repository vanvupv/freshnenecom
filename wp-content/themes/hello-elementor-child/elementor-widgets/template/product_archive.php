<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Product_Archive_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Product_Archive_Widget';
    }

    public function get_title()
    {
        return __('Product Archive', 'child_theme');
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


        $paged = !empty($_GET['paging']) ? intval($_GET['paging']) : 1;

        // Thực hiện WP_Query
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 9,
            'paged' => $paged,
        );

        if (!empty($_GET['title'])) {
            $args['s'] = sanitize_text_field($_GET['title']);
        }

        if (!empty($_GET['product_cat'])) {
            $args['tax_query'][] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['product_cat']),
                ),
            );
        }

        if (!empty($_GET['product_tags'])) {
            $product_tags = array_map('intval', $_GET['product_tags']);
            $args['tax_query'][] = array(
                array(
                    'taxonomy' => 'product_tag',
                    'field' => 'term_id',
                    'terms' => $product_tags,
                ),
            );
        }

        if (!empty($_GET['min_price']) && !empty($_GET['max_price'])) {
            $min_price = floatval($_GET['min_price']);
            $max_price = floatval($_GET['max_price']);
            $args['meta_query'][] = array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'DECIMAL',
            );
        }


        // if (!empty($_GET['rating'] && intval($_GET['rating']) > 0)) {
        //     $rating = intval($_GET['rating']);
        //     $args['meta_query'][] = array(
        //         array(
        //             'key' => '_wc_average_rating', // Trường meta chứa điểm sao
        //             'value' => $rating, // Giá trị để so sánh
        //             'compare' => '>=', // So sánh lớn hơn hoặc bằng
        //             'type' => 'NUMERIC' // Chỉ định kiểu dữ liệu là số
        //         ),
        //     );
        // }

        if (isset($_GET['rating']) && !empty($_GET['rating'] && intval($_GET['rating']) > 0)) {
            $rating = intval($_GET['rating']);
            $args['meta_query'][] = array(
                array(
                    'key' => '_wc_average_rating', // Trường meta chứa điểm sao
                    'value' => $rating, // Giá trị để so sánh
                    'compare' => '>=', // So sánh lớn hơn hoặc bằng
                    'type' => 'NUMERIC' // Chỉ định kiểu dữ liệu là số
                ),
            );
        }


        // Kết hợp tax_query nếu tồn tại nhiều điều kiện
        if (!empty($args['tax_query'])) {
            $args['tax_query']['relation'] = 'AND';
        }

        $order_by = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : '';

        switch ($order_by) {
            case 'price-desc':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order'] = 'DESC';
                break;

            case 'price':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order'] = 'ASC';
                break;

            case 'popularity':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = 'total_sales'; // Sắp xếp theo số lượng bán
                $args['order'] = 'DESC';
                break;

            case 'rating':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_wc_average_rating'; // Sắp xếp theo số lượng bán
                $args['order'] = 'DESC';
                break;

            default:
                $args['orderby'] = 'date'; // Mặc định sắp xếp theo ngày
                $args['order'] = 'DESC';
                break;
        }

        $query = new WP_Query($args);

        ?>
        <div class="secSpace">
            <div class="product_cat_wrap">
                <div class="container">
                    <?php wp_breadcrumbs(); ?>

                    <h1 class="h2 product_cat_title">
                        <?php woocommerce_page_title(); ?>
                    </h1>

                    <div class="catalog_ordering">
                        <div class="woocommerce-result-count">
                            <span><?php echo $query->found_posts; ?> </span> kết quả
                        </div>

                        <?php woocommerce_catalog_ordering(); ?>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <?php include CHILD_PATH . '/template-parts/sidebar-product.php'; // Hiển thị sản phẩm theo ID ?>
                        </div>
                        <div class="col-lg-9">
                            <?php if ($query->have_posts()): ?>
                                <div class="row">
                                    <?php
                                    while ($query->have_posts()):
                                        $query->the_post(); ?>
                                        <div class="col-lg-4 col-md-6">
                                            <?php include CHILD_PATH . '/template-parts/product.php'; ?>
                                        </div>
                                        <?php
                                    endwhile;
                                    ?>
                                </div>
                                <?php
                                echo '<div class="pagination">';
                                echo paginate_links(
                                    array(
                                        'total' => $query->max_num_pages,
                                        'current' => max(1, $paged),
                                        'format' => '?paging=%#%',
                                        'end_size' => 2,
                                        'mid_size' => 1,
                                        'prev_text' => __('Prev', 'basetheme'),
                                        'next_text' => __('Next', 'basetheme'),
                                    )
                                );
                                echo '</div>';
                                ?>
                                <?php
                            endif;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

add_action('wp_footer', function () {
    ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        (function ($) {

            var minPrice = parseFloat($("#slider-range").data("min"));
            var maxPrice = parseFloat($("#slider-range").data("max"));

            var minVal = $("#min-price").val() ? parseFloat($("#min-price").val()) : minPrice;
            var maxVal = $("#max-price").val() ? parseFloat($("#max-price").val()) : maxPrice;

            $("#slider-range").slider({
                range: true,
                min: minPrice,
                max: maxPrice,
                values: [minVal, maxVal],
                slide: function (event, ui) {
                    $("#min-price").val(ui.values[0]);
                    $("#max-price").val(ui.values[1]);
                    $("#min-label").text("$" + ui.values[0]);
                    $("#max-label").text("$" + ui.values[1]);
                }
            });

            $("#min-label").text("$" + minVal);
            $("#max-label").text("$" + maxVal);

        })(jQuery);
    </script>
    <?php
});
