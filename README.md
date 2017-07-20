# Theme Development

#### Feature List

 - [Gulp](http://gulpjs.com)
 - [Sass](http://sass-lang.com/) w/ minimal default styles and normalizer.
 - [BrowserSync](http://www.browsersync.io/)

#### Setup

 1. **IMPORTANT:** Add `define('WP_ENV', 'development');` to your `wp-config.php`.
 * Open up your command line and do `yarn install` or `npm install`
 * Change your local WP dev host URL to the `gulpfile.js`.
```js
// gulpfile.js
 var $url = 'base.dev'; // Local proxy address for browserSync
```


#### Gulp commands

 * `gulp serve` — BrowserSync and live compiling of Sass to CSS and JS concatenating and validating
 * `gulp` — Create minified assets that are used on production environments

#### WordPress Configuration

 * See `lib/setup.php` to setup/update navigation menus, post thumbnail sizes, post formats, and sidebars.
 * See `lib/filters.php` for modifications and customizations.
 * See `lib/helpers.php` for useful functions like debugging and modifying `the_title()`.

------

### To Do's

 - [x] ~~Upgrade Grunt to gulp~~
 - [ ] Add es6 support
 - [ ] Setup Gulp to generate `.pot` files to support internationalization.
