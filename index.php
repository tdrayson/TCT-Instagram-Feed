<?php

// Makes request to Instagram and returns data in JSON format
function tct_instagram_feed_data($data){
$insta_id = 'nike';

if ( ! $response_data = get_transient( 'tct_instagram_feed_data' . $data ) ) {
  
  // If not using Wordpress then replace this section with Curl Request  
  $request = wp_remote_get('https://www.instagram.com/'. $insta_id .'/channel/?__a=1');
    if( is_wp_error( $request ) ) {
	    echo 'empty'; // Bail early
    }

    $body = wp_remote_retrieve_body( $request );
    //print_r($body);
    $response_data = json_decode( $body );
    set_transient( 'tct_instagram_feed_data' . $data, $response_data, 86400 ); //86400 = 1 day, 3600 = 1 hour
}
return $response_data;
}

// Adds shortcode and sets variables from JSON data
add_shortcode( 'instafeed', 'tct_instagram_feed' );
function tct_instagram_feed($atts){
    $data = tct_instagram_feed_data( $atts['data'] );
    $user = $atts['user'];
   
    // To see full list of available data, check the response from this URL - https://www.instagram.com/instagram/channel/?__a=1 
    $username = $data->graphql->user->username;
    $name = $data->graphql->user->full_name;
    $user_pp = $data->graphql->user->profile_pic_url;
    $user_pp_hd = $data->graphql->user->profile_pic_url_hd;
    $followers = $data->graphql->user->edge_followed_by->count;
    $following = $data->graphql->user->edge_follows->count;
    $bio = $data->graphql->user->biography;
    $post_count = $data->graphql->user->edge_owner_to_timeline_media->count;
    
    switch ($user) {
        case 'username':
            return $username; //string
        case 'name':
            return $name; // string
        case 'user_pp':
            return '<img src="'.$user_pp.'">'; //image
        case 'user_pp_hd':
            return '<img src="'.$user_pp_hd.'">'; // image
        case 'followers':
            return $followers; // int
        case 'following':
            return $following; // int
        case 'bio':
            return $bio; // string
        case 'post_count':
            return $post_count; // int
        case 'feed':
            for($i = 0; $i < 12; $i++) {
              $post_url = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->shortcode;
              $post_img = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->thumbnail_resources[1]->src;
              $post_access_caption = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->accessibility_caption;
              $post_caption = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->edge_media_to_caption->edges[0]->node->text;
              $post_caption_trim = truncate($post_caption);
        
              // To modify the output of the feed, change $feed string.     
              $feed .= '<a class="insta-wrapper" alt="'.$post_access_caption.'" href="https://instagram.com/p/'.$post_url.'"><img  src="'. $post_img .'"><span>'.$post_caption_trim.'</span></a>';
            }
            return $feed;
    }   
}

// Trim caption length to 100 characters
function truncate($string,$length=100,$append="&hellip;") {
  $string = trim($string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n", $string, 2);
    $string = $string[0] . $append;
  }

  return $string;
}
