# _base

_base is a WordPress starter theme.

#### Feature List

- [Grunt](http://gruntjs.com)
- [Bower](http://bower.io)
- [BrowserSync](http://www.browsersync.io/)

## Install and develop

#### 1. Clone repo
`git clone git@bitbucket.org:martylouis/_base.git`

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
- See `lib/config.php` to enable or disable theme features and to define a Google Analytics ID.


### Grunt commands

* `grunt serve` — BrowserSync and live compiling of Sass to CSS and JS concatenating and validating
* `grunt dev` — Compile Sass to CSS, concatenate and validate JS
* `grunt build` — Create minified assets that are used on production environments

Review `Grunfile.js` to familiarize yourself with the setup.

### WP ENGINE and Git push

[See WP Engine's documentation](http://wpengine.com/git/) for setting up your local WP install to push up to WP Engine production and staging.


##### Edit `.gitignore`

To correctly push up to production via git you need to track production assets.

```sh
# Comment to track production assets
# dist
# assets/manifest.json
```

------

Maintained by [Marty Thierry](http://twitter.com/martylouis).

This starter theme was orginally forked from the smart guys behind [Roots](https://roots.io) and their [Roots Starter Theme](https://github.com/roots/sage/releases/tag/7.0.3).
