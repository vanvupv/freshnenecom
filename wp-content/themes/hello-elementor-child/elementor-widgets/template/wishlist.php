<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Wishlist_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'Wishlist_Widget';
    }

    public function get_title()
    {
        return __('Wishlist', 'child_theme');
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
        ?>
        <?php
        $post_id = get_the_ID();
        $thumbnail_id = get_post_thumbnail_id($post_id);
        $categories = get_the_category($post_id);
        $user_id = get_current_user_id();
        //
        if ($user_id):
            $favorite_posts = get_user_meta($user_id, 'favorite_posts', true) ?: [];
            $active_class = in_array($post_id, $favorite_posts) ? 'active' : '';
            var_dump($active_class);
            //
            ?>
            <span class="favorite_posts <?php echo $active_class; ?>" data-post_id="<?php echo $post_id; ?>">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_19367_335)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.70094 3.76001C10.3375 3.12349 11.2008 2.7659 12.1009 2.7659C13.0011 2.7659 13.8644 3.12349 14.5009 3.76001C15.1375 4.39653 15.4951 5.25984 15.4951 6.16001C15.4951 7.06019 15.1375 7.92349 14.5009 8.56001L13.6276 9.43334L8.8276 14.2333L4.0276 9.43334L3.15427 8.56001C2.51775 7.92349 2.16016 7.06019 2.16016 6.16001C2.16016 5.25984 2.51775 4.39653 3.15427 3.76001C3.79079 3.12349 4.65409 2.7659 5.55427 2.7659C6.45444 2.7659 7.31775 3.12349 7.95427 3.76001L8.8276 4.63335L9.70094 3.76001Z"
                            stroke="#E6704B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_19367_335">
                            <rect width="16" height="16" fill="white" transform="translate(0.828125 0.5)" />
                        </clipPath>
                    </defs>
                </svg>
                Add to my wish list
            </span>
            <?php
        endif;
    ?>
    <?php
    }
}

add_action('wp_footer', function () {
    ?>
    <script>
        var url_ajax = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
    <?php
});

