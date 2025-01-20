<?php
// 
/**
 * Breadcrumbs
 */
function wp_breadcrumbs()
{
    $delimiter = '
	<span class="icon">
	<svg width="5" height="10" viewBox="0 0 5 10" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4.27148 0.933594L1.08398 9.5H0.123047L3.31641 0.933594H4.27148Z" fill="#D1D1D1"/>
    </svg>
	</span>
	';

    $home = __('Home', 'basetheme');
    $before = '<span class="current">';
    $after = '</span>';
    if (!is_admin() && !is_home() && (!is_front_page() || is_paged())) {

        global $post;

        echo '<nav>';
        echo '<div id="breadcrumbs" class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">';

        $homeLink = home_url();
        echo '<a href="' . $homeLink . '">' . $home . '</a>' . $delimiter . ' ';

        switch (true) {
            case is_category() || is_archive():
                $cat_obj = get_queried_object();
                echo $before . $cat_obj->name . $after;
                break;

            case is_single() && !is_attachment():
                $post_type = $post->post_type;

                if ($post_type == 'post') {
                    $categories = get_the_category($post->ID);

                    if (!empty($categories)) {
                        $first_category = $categories[0];
                        echo '<a aria-label="' . $first_category->name . '" href="' . get_category_link($first_category->term_id) . '">' . $first_category->name . '</a>' . $delimiter . ' ';
                    }
                }

                if ($post_type == 'product') {
                    $categories = get_the_terms($post->ID, 'product_cat');

                    if (!empty($categories)) {
                        $first_category = $categories[0];
                        echo '<a aria-label="' . $first_category->name . '" href="' . get_term_link($first_category->term_id, 'product_cat') . '">' . $first_category->name . '</a>' . $delimiter . ' ';
                    }
                }

                echo $before . $post->post_title . $after;
                break;

            case is_page():
                if ($post->post_parent) {
                    $parent_id = $post->ID;
                    echo generate_page_parent($parent_id, $delimiter);
                }

                echo $before . get_the_title() . $after;
                break;

            case is_search():
                echo $before . 'Search' . $after;
                break;

            case is_404():
                echo $before . 'Error 404' . $after;
                break;
        }

        echo '</div>';
        echo '</nav>';
    }
}

// Generate breadcrumbs ancestor page
function generate_page_parent($parent_id, $delimiter)
{
    $breadcrumbs = [];
    $output = '';

    while ($parent_id) {
        $page = get_post($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id = $page->post_parent;
    }


    $breadcrumbs = array_reverse($breadcrumbs);
    array_pop($breadcrumbs);

    foreach ($breadcrumbs as $crumb) {
        $output .= $crumb . $delimiter;
    }

    return rtrim($output);
}
// End wp_breadcrumbs()

// Lọc bài viết theo tháng và năm
function filter_posts_by_month_year($query)
{
    if (!is_admin() && $query->is_main_query()) {
        if (isset($_GET['month']) && !empty($_GET['month'])) {
            $query->set('monthnum', intval($_GET['month']));
        }
        if (isset($_GET['year']) && !empty($_GET['year'])) {
            $query->set('year', intval($_GET['year']));
        }
    }
}
add_action('pre_get_posts', 'filter_posts_by_month_year');

// 
add_filter('elementor_pro/post_info/terms_separator', function () {
    return ''; // Thay bằng dấu phân cách bạn muốn (hoặc giữ trống để loại bỏ).
});

add_filter('elementor/widget/render_content', function ($content, $widget) {
    if ($widget->get_name() === 'post-info') {
        // Thay thế dấu phẩy bằng khoảng trắng hoặc ký tự tùy chỉnh
        $content = str_replace(',', '', $content);
    }
    return $content;
}, 10, 2);

//
// 
// include CHILD_PATH . '/inc/post_comment/post_comment.php';

// // 
// function custom_comment_form_fields($fields)
// {
//     // Trường Tên
//     $fields['author'] = '<p class="comment-form-author">
//         <label for="author">' . __('Name', 'textdomain') . '</label>
//         <input id="author" name="author" type="text" value="" size="30" placeholder="Name" required />
//     </p>';

//     // Trường Email
//     $fields['email'] = '<p class="comment-form-email">
//         <label for="email">' . __('Email address', 'textdomain') . '</label>
//         <input id="email" name="email" type="email" value="" size="30" placeholder="Email address" required />
//     </p>';

//     return $fields;
// }
// add_filter('comment_form_default_fields', 'custom_comment_form_fields');

// function custom_comment_form_defaults($defaults)
// {
//     // Tùy chỉnh trường Comment
//     $defaults['comment_field'] = '<p class="comment-form-comment">
//         <label for="comment">' . __('Comment', 'textdomain') . '</label>
//         <textarea id="comment" name="comment" placeholder="Space for your comments" rows="5" required></textarea>
//     </p>';

//     // Thay đổi nút gửi bình luận
//     $defaults['label_submit'] = 'Send a comment';

//     return $defaults;
// }
// add_filter('comment_form_defaults', 'custom_comment_form_defaults');

// function force_show_comment_fields($fields)
// {
//     if (is_user_logged_in()) {
//         // Hiển thị cả trường Name và Email cho người dùng đã đăng nhập
//         $fields['author'] = '<p class="comment-form-author">
//             <label for="author">' . __('Name', 'textdomain') . '</label>
//             <input id="author" name="author" type="text" value="" size="30" placeholder="Name" required />
//         </p>';

//         $fields['email'] = '<p class="comment-form-email">
//             <label for="email">' . __('Email address', 'textdomain') . '</label>
//             <input id="email" name="email" type="email" value="" size="30" placeholder="Email address" required />
//         </p>';
//     }

//     return $fields;
// }
// add_filter('comment_form_default_fields', 'force_show_comment_fields');

// function modify_comment_form_defaults($defaults)
// {
//     $defaults['title_reply'] = 'Comments'; // Đổi tiêu đề "Leave a Reply" thành "Comment"
//     return $defaults;
// }
// add_filter('comment_form_defaults', 'modify_comment_form_defaults');
// comments_title

//
// function modify_title_comments()
// {
//     return 'Comments'; // Văn bản bạn muốn thay đổi
// }
// add_filter('comments_template_title', 'modify_title_comments');

//
// function customize_comments_title_output($content)
// {
//     // Kiểm tra và thay đổi tiêu đề của phần bình luận
//     $content = str_replace('Responses', 'Custom Comments Title', $content);
//     return $content;
// }
// add_filter('the_content', 'customize_comments_title_output');

// //
// function customize_comments_title_render_block($block_content, $block)
// {
//     // Kiểm tra nếu block là `core/comments-title`
//     if ('core/comments-title' === $block['blockName']) {
//         // Thay thế nội dung của $block_content
//         $block_content = str_replace('Responses', 'Custom Comments Title', $block_content);
//     }
//     return $block_content;
// }
// add_filter('render_block', 'customize_comments_title_render_block', 10, 2);

//
// Tắt văn bản "says" trong bình luận
// function custom_comment_author($author, $comment_id)
// {
//     // Lấy thông tin người dùng (nếu có)
//     $user = get_comment_author($comment_id);
//     $job_title = get_user_meta(get_comment_author_ID($comment_id), 'job_title', true); // Giả sử 'job_title' là meta chứa chức vụ

//     // Hiển thị tên người bình luận và chức vụ (nếu có)
//     if ($job_title) {
//         $author = '<b>' . $user . '</b> - ' . esc_html($job_title);
//     } else {
//         $author = '<b>' . $user . '</b>';
//     }
//     return $author;
// }
// add_filter('get_comment_author', 'custom_comment_author', 10, 2);

// Tắt văn bản "says" bằng cách loại bỏ từ này trong phần hiển thị
function remove_comment_author_says($text)
{
    return str_replace('says:', '', $text); // Xóa 'says:'
}
add_filter('comment_author_says', 'remove_comment_author_says');

// Tắt liên kết "Edit" trong phần metadata của bình luận
function remove_comment_edit_link($link)
{
    return ''; // Trả về một chuỗi rỗng để không hiển thị link Edit
}
add_filter('comment_edit_link', 'remove_comment_edit_link');

// Thêm chức vụ vào phần meta của người bình luận
// function add_job_title_to_comment_meta($comment_text, $comment)
// {
//     $user_id = $comment->user_id;
//     $job_title = get_user_meta($user_id, 'job_title', true); // Lấy chức vụ từ user meta

//     if ($job_title) {
//         $comment_text .= '<p class="comment-job-title"><strong>Chức vụ:</strong> ' . esc_html($job_title) . '</p>';
//     }

//     return $comment_text;
// }
// add_filter('comment_text', 'add_job_title_to_comment_meta', 10, 2);
