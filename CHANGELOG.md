### 2.0.0: Oct 8, 2015
 - Rename theme to '_base'
 - Update to Bootstrap v4-alpha
 - Update to jQuery v2.1.4
 - Update to Modernizr 3, (remove bower dep)
 - Update Advanced Custom Fields v5.3.1
 - Reorganized template structure
 - Setup `dist` folder for production assets
 - Updates to npm package deps
 - Fixes various bugs and issues

### 1.0.0: January 29th, 2015
 - Init Marty Roots
 - Update devDependencies
 - Switch to [BrowserSync](http://browsersync.io)
 - Reorganize wrapper in `base.php` to allow for full control over content sections
 - Update to Bootstrap for Sass v3.3.3
 - Remove all CHANGELOG documentation from before Roots v7

### 7.0.3: December 18th, 2014
* Use `get_the_archive_title`
* Remove `wp_title`, add title-tag theme support
* Remove `Roots_Nav_Walker` as default for all menus
* Update to Bootstrap 3.3.1
* Add some base comment styling
* Make search term `required` in search form

### 7.0.2: October 24th, 2014
* Simplify comments, use core comment form and list
* Remove HTML5 shiv from Modernizr build
* Move JavaScript to footer
* Update hEntry schema to use `updated` instead of `published`
* Move variables into `main.less`
* Add `roots_body_class` function that checks for page slug in `body_class`
* Move `wp_footer` from footer template into `base.php`

### 7.0.1: August 15th, 2014
* Move `<main>` and `.sidebar` markup out of PHP and into LESS
* Define `WP_ENV` if it is not already defined
* Only load Google Analytics in production environment

### 7.0.0: July 3rd, 2014
* Updated Grunt workflow
* Use grunt-modernizr to make a lean Modernizr build
* Use Bower for front-end package management
* Update to Bootstrap 3.2.0
* Update to Modernizr 2.8.2
* Update to jQuery 1.11.1
* Move clean up, relative URLs, and nice search to [Soil](https://github.com/roots/soil)
* Update LESS organization
* Move [community translations](https://github.com/roots/roots-translations) to separate repository
