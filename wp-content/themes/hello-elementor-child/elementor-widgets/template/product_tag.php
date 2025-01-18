<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Product_Tag_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Product_Tag_Widget';
    }

    public function get_title()
    {
        return __('Product Tag', 'child_theme');
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

        // Lấy toàn bộ danh sách tags
        $product_tags = get_terms(array(
            'taxonomy' => 'product_tag',
            'hide_empty' => false, // Hiển thị cả tags không có sản phẩm
        ));

        //
        if (!empty($product_tags) && !is_wp_error($product_tags)): ?>
            <div class="productTag__list">
                <?php foreach ($product_tags as $tag): ?>
                    <a class="productTag" href="<?php echo esc_url(get_term_link($tag)); ?>">
                        <?php echo esc_html($tag->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Không có tags nào!</p>
        <?php endif; ?>
    <?php
    }
}

