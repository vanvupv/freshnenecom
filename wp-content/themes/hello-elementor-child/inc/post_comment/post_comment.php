<?php
// function custom_comment_form_fields($fields)
// {
//     // Thay đổi placeholder của trường Name
//     $fields['author'] = '<p class="comment-form-author">
//         <input id="author" name="author" type="text" placeholder="Name" size="30" /></p>';

//     // Thay đổi placeholder của trường Email
//     $fields['email'] = '<p class="comment-form-email">
//         <input id="email" name="email" type="email" placeholder="Email address" size="30" /></p>';

//     return $fields;
// }
// add_filter('comment_form_default_fields', 'custom_comment_form_fields');

// function custom_comment_form_defaults($defaults)
// {
//     // Thay đổi placeholder của trường Comment
//     $defaults['comment_field'] = '<p class="comment-form-comment">
//         <textarea id="comment" name="comment" placeholder="Space for your comments" rows="5"></textarea></p>';

//     // Thay đổi nút gửi bình luận
//     $defaults['label_submit'] = 'Send a comment';

//     return $defaults;
// }
// add_filter('comment_form_defaults', 'custom_comment_form_defaults');
// 
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

