# Custom Instagram Feed
Add instagram feed to page from URL

---

## Table of Contents
* [Usage](#usage)
* [Shortcode](#shortcode)
   * [Attribute Options](#attribute)
   * [Examples](#examples)
* [Extra Info](#extra_info)
* [Troubleshooting](#troubleshooting)
* [Support](#support)


## <a name="usage"></a>Usage

**Using Wordpress**
1. Add index.php to code snippets or functions.php
2. Replace `$insta_id` with Instagram username
4. Add shortcode to page

**For slider integration**
1. Add slider CSS to head of website
2. Add slider JS just before closing `</body>` tag
3. Add the `<script>` and `<styles>` code to functions.php or code snippets
4. 

## <a name="shortcode"></a>Shortcode 

``` [instafeed user="ATTRIBUTE_NAME"] ```

To use grid = [instafeed user="feed-grid"]
To use slider = [instafeed user="feed-slider"]

You can pass extra parameters to the grid and slider:
* `caption=true` - shows the caption (Default is false)
* `class="my-custom-class"` - this adds a custom class to the grid or slider so you can target specific sliders if more than 1 on the page
* `post_count="6"` - returns 6 in the slider or grid (Default is 12)


**<a name="attribute"></a>Attribute name options** 
* `feed-grid` - User feed grid
* `feed-slider` - User feed slider
* `username` - Users username
* `name` - Users display name
* `user_pp` - Users profile picture thumbnail
* `user_pp_hd` - Users profile picture HD
* `followers` - Users follower count
* `following` - Users following count
* `bio` - Users bio
* `user_post_count` - Total number of users posts

## <a name="examples"></a>Examples

### Grid
`[instafeed user="feed-grid" caption=true post_count=6]`
<img width="1087" alt="Feed Grid" src="https://user-images.githubusercontent.com/33532995/113164592-25ce4b80-9239-11eb-9d68-40720425a860.png">

### Slider
`[instafeed user="feed-slider"]`
<img width="1148" alt="Feed Slider" src="https://user-images.githubusercontent.com/33532995/113162703-6af17e00-9237-11eb-841b-832dd8f965d0.png">


## <a name="extra_info"></a>Extra Info
* To see what other data is available, use - https://www.instagram.com/{username}/channel/?__a=1

* You can change the length of the transient (cache) by changing line 19 `86400` to a different time (in seconds). Default is 1 day.
  * `604800` = 1 week
  * `86400` = 1 day
  * `3600` = 1 hour

* The default instagram feed does not come with any styling.

* **Feel free to make a pull request if you come up with a nice design and share it with the community**

## <a name="troubleshooting"></a>Troubleshooting
### Instagram Feed showing wrong user
If the instagram feed is showing the wrong user, this is usually down to the transients showing a cached version.

To fix this, pleaase use these steps:
1. uncomment lines `18` and `20` in index.php
2. Load the frontend where the shortcode appears
3. Re-comment lines `18` and `20`

## <a name="support"></a>Support
If you found this useful,and would like to support me. You can use my buyMeACoffee link below. <br>
Please note: it is **NOT** required. It is here for you to enjoy either way.<br><br>
<a href="https://www.buymeacoffee.com/tdrayson" target="_blank"><img src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: 41px !important;width: 174px !important;box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;" ></a>
