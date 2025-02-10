<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Search_Results_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Search_Results_Widget';
    }

    public function get_title()
    {
        return __('Search Results', 'child_theme');
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

        // Lấy thông tin tìm kiếm từ URL
        $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
        $category_slug = isset($_GET['category']) && !empty($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        // Thiết lập truy vấn sản phẩm
        $args = array(
            'post_type' => 'product',
            's' => $search_query,
            'posts_per_page' => 9,
            'paged' => $paged,
        );

        // Nếu có danh mục, thêm bộ lọc danh mục vào truy vấn
        if (!empty($category_slug)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category_slug,
                ),
            );
        }

        $query = new WP_Query($args);
        ?>

        <div class="secSpace">
            <div class="product_cat_wrap">
                <div class="container">
                    <h1 class="h2 product_cat_title">
                        Kết quả tìm kiếm cho: "<?php echo esc_html($search_query); ?>"
                    </h1>

                    <div class="catalog_ordering">
                        <div class="woocommerce-result-count">
                            <span><?php echo $query->found_posts; ?></span> sản phẩm được tìm thấy
                        </div>
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                    <?php if ($query->have_posts()): ?>
                        <div class="row ">
                            <?php while ($query->have_posts()):
                                $query->the_post(); ?>
                                <div class="col-lg-4 col-md-6">
                                    <?php // include CHILD_PATH . '/template-parts/product.php'; ?>
                                    <?php get_template_part('template-parts/product'); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="pagination_custom">
                            <?php
                            echo paginate_links(array(
                                'total' => $query->max_num_pages,
                                'current' => max(1, $paged),
                                'format' => '?paged=%#%',
                                'end_size' => 2,
                                'mid_size' => 1,
                                'prev_text' => __('Trước', 'basetheme'),
                                'next_text' => __('Sau', 'basetheme'),
                            ));
                            ?>
                        </div>
                    <?php else: ?>
                        <p class="no-results">Không tìm thấy sản phẩm nào phù hợp với từ khóa
                            "<?php echo esc_html($search_query); ?>"</p>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
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
