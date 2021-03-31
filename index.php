<?php

// Makes request to Instagram and returns data in JSON format
function tct_instagram_feed_data($data)
{
    $insta_id = 'nike';

    if (! $response_data = get_transient('tct_instagram_feed_data' . $data) ) {
  
        // If not using Wordpress then replace this section with Curl Request  
        $request = wp_remote_get('https://www.instagram.com/'. $insta_id .'/channel/?__a=1');
        if(is_wp_error($request) ) {
            echo 'empty'; // Bail early
        }

        $body = wp_remote_retrieve_body($request);
        //print_r($body);
        $response_data = json_decode($body);
        set_transient('tct_instagram_feed_data' . $data, $response_data, 86400); //86400 = 1 day, 3600 = 1 hour
   }
    return $response_data;
}

// Adds shortcode and sets variables from JSON data
add_shortcode('instafeed', 'tct_instagram_feed_shortcode');
function tct_instagram_feed_shortcode($atts)
{
    $data = tct_instagram_feed_data($atts['data']);
    $user = $atts['user'];
    $post_count = $atts['post_count'];
    $post_caption = $atts['caption'];
    $custom_class = $atts['class'];
    
    if(empty($post_count)) {
        $post_count = 12;
    }
    if($post_caption == "true" || $post_caption == "True" ) {
        $post_caption = true;
    }else{
        $post_caption = false;
    }
    
    // To see full list of available data, check the response from this URL - https://www.instagram.com/nike/channel/?__a=1 
    $username = $data->graphql->user->username;
    $name = $data->graphql->user->full_name;
    $user_pp = $data->graphql->user->profile_pic_url;
    $user_pp_hd = $data->graphql->user->profile_pic_url_hd;
    $followers = number_format($data->graphql->user->edge_followed_by->count);
    $following = number_format($data->graphql->user->edge_follows->count);
    $bio = $data->graphql->user->biography;
    $user_post_count = $data->graphql->user->edge_owner_to_timeline_media->count;
    
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
    case 'user_post_count':
        return $user_post_count; // int
    case 'feed-grid':
        for($i = 0; $i < $post_count; $i++) {
            $post_url = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->shortcode;
            $post_img = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->thumbnail_resources[1]->src;
            $post_access_caption = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->accessibility_caption;
            $post_caption_text = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->edge_media_to_caption->edges[0]->node->text;
            $post_caption_trim = tct_truncate($post_caption_text);
              
            if ($post_caption == true) {
                $post_caption_html = '<div class="insta-caption-div '.$custom_class.'"><span class="insta-caption">'.$post_caption_trim.'</span></div>';
            }
            // To modify the output of the feed, change $feed string.     
            $feed .= '<a class="insta-wrapper" alt="'.$post_access_caption.'" href="https://instagram.com/p/'.$post_url.'"><img class="insta-image"  src="'. $post_img .'">'.$post_caption_html.'</a>';
        }
        return $feed;
    case 'feed-slider':
        // Adds Slider pre div
	$slider_pre = '<div class="insta-slider '.$custom_class.'">';
        
        for($i = 0; $i < $post_count; $i++) {
            $post_url = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->shortcode;
            $post_img = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->thumbnail_resources[1]->src;
            $post_access_caption = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->accessibility_caption;
            $post_caption_text = $data->graphql->user->edge_owner_to_timeline_media->edges[$i]->node->edge_media_to_caption->edges[0]->node->text;
            $post_caption_trim = tct_truncate($post_caption_text);
              
	
            if ($post_caption == true) {
                $post_caption_html = '<div class="slider-insta-caption-div"><span class="insta-caption">'.$post_caption_trim.'</span></div>';
            }
            // To modify the output of the feed, change $feed string.     
            $slider_content .= '<div class="slider-insta"><a class="slider-insta-wrapper" alt="'.$post_access_caption.'" href="https://instagram.com/p/'.$post_url.'"><img class="insta-image-slider"  data-lazy="'. $post_img .'">'.$post_caption_html.'</a></div>';
        }
	// Adds closing slider div	    
        $slider_after = '</div>';
        
	$feed_slider = $slider_pre . $slider_content . $slider_after;
        return $feed_slider;
    } 
    
}

// Trim caption length to 100 characters
function tct_truncate($string,$length=100,$append="&hellip;")
{
    $string = trim($string);

    if(strlen($string) > $length) {
        $string = wordwrap($string, $length);
        $string = explode("\n", $string, 2);
        $string = $string[0] . $append;
    }

    return $string;
}
