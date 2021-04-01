# Instagram Feed Styles by Amanda Lucas


* In order to make Taylors instagram feed responsive, I created the following CSS.
* Add a class to the shortcode wrapper, in this example I used 'i-instagram'
## <a href="https://amandalucas.eu/custom-Instagram-grid/"> Full blog post </a>
![bespace](https://user-images.githubusercontent.com/19773620/113296658-ae102780-92f1-11eb-949c-bc7d7a71bb8b.gif)

```css
`/*Instagram grid styling */

.i-instagram {
  width: 100%;
  display: flex;
  flex-wrap: wrap;  
}

.i-instagram>* {
 margin: 10px;
 flex: 1 1 14%;
      }

@media ( max-width: 960px) {
  .i-instagram >* {
    flex-basis: 28%;
  }
}
  
@media ( max-width: 768px) {
  .i-instagram >* {
    flex-basis: 28%;}
  
  .i-instagram {
      font-size: 12px;}
  
  .insta-caption-div {
  line-height:1.2!important;}
}
  
@media ( max-width: 320px) {
  .i-instagram >* {
   flex-basis: 40%;
  }
}

.insta-image { 
  width: 100%!important;
  max-width: 300px;
  min-width: 140px;
  }

```
