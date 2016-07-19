# `_base`

`_base` is a WordPress starter theme.

#### Feature List

- [Grunt](http://gruntjs.com)
- [Sass](http://sass-lang.com/) w/ minimal default styles and normalizer.
- [BrowserSync](http://www.browsersync.io/)

## Install and develop

#### 1. Clone repo
`git clone https://github.com/martylouis/_base.git themename`

#### 2. Run `npm install`
This will download all [Grunt](http://gruntjs.com/) package dependencies and install [Bower](http://bower.io) components. If you don't have it yet, see [how to install node](https://docs.npmjs.com/getting-started/installing-node).

#### 3. Define your local development
Add `define('WP_ENV', 'development');` to `wp-config.php`.

#### 4. Update BrowserSync [proxy](http://www.browsersync.io/docs/grunt/#grunt-proxy)
Point the proxy to your WP install host address.

```js
  // Gruntfile.js
  browserSync: {
    dev: {
      bsFiles: {
        src: [
          'assets/css/main.css',
          'assets/js/**/*.js',
          '**/*.php'
        ]
      },
      options: {
        watchTask: true,
        proxy: "wp.dev", // Update to match your local host address
        notify: false
      }
    }
  }
```

#### 5. Run `grunt serve`
Have fun!

### WordPress Configuration

- See `lib/init.php` to setup/update navigation menus, post thumbnail sizes, post formats, and sidebars.
- See `lib/scripts.php` to add, update or remove theme CSS and Javascript.
- See `lib/config.php` to enable or disable theme features and to define a Google Analytics ID.


### Grunt commands

* `grunt serve` — BrowserSync and live compiling of Sass to CSS and JS concatenating and validating
* `grunt dev` — Compile Sass to CSS, concatenate and validate JS
* `grunt build` — Create minified assets that are used on production environments

Review `Grunfile.js` to familiarize yourself with the setup.

### WP ENGINE

This themes is setup to be pushed up to WP Engine. By default we ignore tracking theme compiled files, `assets/css/main.css`, `assets/css/main.css.map`, and `assets/js/scripts.js`.

[See WP Engine's documentation](http://wpengine.com/git/) for setting up your local WP install to push up to WP Engine production and staging.

------

Maintained by [Marty Thierry](http://twitter.com/martylouis).

This starter theme was originally forked from the smart guys behind [Roots](https://roots.io) and their [Roots Starter Theme](https://github.com/roots/sage/releases/tag/7.0.3).
