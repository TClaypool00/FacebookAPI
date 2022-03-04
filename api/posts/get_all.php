<?php
include '../../partial_files/get_all_headeres.php';
include '../../partial_files/object_partial_files/new_post.php';
include '../../global_functions.php';

$all_posts = $post->get_all();
$num = $all_posts->rowCount();

if ($num > 0) {
    $post_array = array();

    while ($row = $all_posts->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'postId' => $PostId,
            'body' => $Body,
            'datePosted' => $DatePosted,
            'userId' => $UserId,
            'firstName' => $FirstName,
            'lastName' => $LastName
        );

        array_push($post_array, $post_item);
    }

    http_response_code(200);
    echo json_encode($post_array);
} else {
    http_response_code(404);
    echo custom_array('No posts found');
}