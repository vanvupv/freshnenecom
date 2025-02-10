<?php
function favorite_posts()
{
    $user_id = get_current_user_id();
    if (!$user_id) {
        wp_send_json_error(['message' => 'User not logged in.']);
    }

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    $favorite_posts = get_user_meta($user_id, 'favorite_posts', true);
    if (!is_array($favorite_posts)) {
        $favorite_posts = [];
    }

    $index = array_search($post_id, $favorite_posts);
    if ($index === false) {
        $favorite_posts[] = $post_id;
        $status = 'added';
    } else {
        unset($favorite_posts[$index]);
        $favorite_posts = array_values($favorite_posts);
        $status = 'removed';
    }

    update_user_meta($user_id, 'favorite_posts', $favorite_posts);

    wp_send_json_success([
        'message' => "Save successfully.",
        'status' => $status,
        'post_id' => $post_id,
    ]);

    wp_die();
}

add_action('wp_ajax_favorite_posts', 'favorite_posts');
add_action('wp_ajax_nopriv_favorite_posts', 'favorite_posts');
