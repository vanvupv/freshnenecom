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


        $this->end_controls_section();
    }

    private function get_product_categories()
    {
        $categories = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);

        $options = ['' => __('All categories', 'child_theme')];
        foreach ($categories as $category) {
            $options[$category->slug] = $category->name;
        }
        return $options;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $categories = $this->get_product_categories();
        ?>
        <div class="search-bar-container">
            <form action="<?php echo esc_url(home_url('/')); ?>" method="GET">
                <!-- Input tìm kiếm -->
                <input type="text" name="s" id="search-input" class="search-input"
                    placeholder="<?php _e('Search products...', 'child_theme'); ?>" />

                <!-- Dropdown danh mục -->
                <select name="category" id="search-category" class="search-category">
                    <option value=""><?php _e('All Categories', 'child_theme'); ?></option>
                    <?php foreach ($categories as $slug => $name): ?>
                        <option value="<?php echo esc_attr($slug); ?>">
                            <?php echo esc_html($name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Kết quả tìm kiếm -->
                <div id="search-results" class="search-results"></div>
            </form>
        </div>
        <?php
    }
}

add_action('wp_footer', function () {
    ?>
    <script>
        (function ($) {
            // Hàm dùng chung để gọi AJAX
            function performSearch() {
                const keyword = $('#search-input').val();
                const category = $('#search-category').val();

                // Chỉ thực hiện AJAX khi keyword >= 3 ký tự hoặc có danh mục được chọn
                if (keyword.length >= 3 || category !== '') {
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        method: 'POST',
                        data: {
                            action: 'search_products',
                            security: '<?php echo wp_create_nonce('search_products_nonce'); ?>',
                            keyword: keyword,
                            category: category,
                        },
                        beforeSend: function () {
                            $('#search-results').html('<p>Loading...</p>');
                        },
                        success: function (response) {
                            $('#search-results').html(response);
                        },
                        error: function () {
                            $('#search-results').html('<p>Error loading results.</p>');
                        },
                    });
                } else {
                    $('#search-results').html('');
                }
            }

            // Lắng nghe sự kiện trên input tìm kiếm
            $('#search-input').on('input', function () {
                performSearch();
            });

            // Lắng nghe sự kiện thay đổi trên dropdown danh mục
            $('#search-category').on('change', function () {
                performSearch();
            });
        })(jQuery);
    </script>
    <?php
});
