# _base

Super bare bones WordPress starter theme.

#### Feature List

- [Grunt](http://gruntjs.com)
- [Sass](http://sass-lang.com/) w/ minimal default styles and normalizer.
- [BrowserSync](http://www.browsersync.io/)

#### Setup
1. Add `define('WP_ENV', 'development');` to your `wp-config.php`.
- `git clone https://github.com/martylouis/_base.git themename`
- `npm install`
- Add your [local WP dev host to Gruntfile.js](http://www.browsersync.io/docs/grunt/#grunt-proxy).

#### WordPress Configuration

- See `lib/init.php` to setup/update navigation menus, post thumbnail sizes, post formats, and sidebars.
- See `lib/scripts.php` to add, update or remove theme CSS and Javascript.
- See `lib/config.php` to enable or disable theme features and to define a Google Analytics ID.


#### Grunt commands

* `grunt serve` — BrowserSync and live compiling of Sass to CSS and JS concatenating and validating
* `grunt dev` — Compile Sass to CSS, concatenate and validate JS
* `grunt build` — Create minified assets that are used on production environments

Review `Grunfile.js` to familiarize yourself with the setup.

#### Working files

By default we ignore tracking theme compiled files, `assets/css/main.css`, `assets/css/main.css.map`, and `assets/js/scripts.js`.

------

Maintained by [Marty Thierry](http://twitter.com/martylouis).

This starter theme was originally forked from the smart guys behind [Roots](https://roots.io) and their [Roots Starter Theme](https://github.com/roots/sage/releases/tag/7.0.3).
