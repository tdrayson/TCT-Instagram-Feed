# Custom Instagram Feed
Add instagram feed to page from URL

---

## Usage

** Using Wordpress **
1. Add index.php to code snippets or functions.php
2. Replace `$insta_id` with Instagram username
3. Add shortcode to page

## Shortcode 

``` [instafeed attribute="ATTRIBUTE_NAME"] ```

**Attribute name options**
* `feed` - User image feed
* `username` - Users username
* `name` - Users display name
* `user_pp` - Users profile picture thumbnail
* `user_pp_hd` - Users profile picture HD
* `followers` - Users follower count
* `following` - Users following count
* `bio` - Users bio
* `post_count` - Total number of users posts

To see what other data is available, use - https://www.instagram.com/instagram/channel/?__a=1 

You can change the length of the transient (cache) by changing line 18 `86400` to a different time (in seconds). Default is 1 day.

* 604800 = 1 week
* 86400 = 1 day
* 3600 = 1 day

The default instagram feed does not come with any styling.

**Feel free to make a pull request if you come up with a nice design and share it with the community**
