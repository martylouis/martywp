'use strict';

module.exports = function(grunt) {
  require('load-grunt-tasks')(grunt);
  require('time-grunt')(grunt);

  var $js_files = [
        'assets/js/plugins/*.js',
        'assets/js/_*.js'
      ];

  grunt.initConfig({
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        'assets/js/_main.js',
      ]
    },
    uglify: {
      dist: {
        files: {
          'assets/js/scripts.min.js': [$js_files],
        }
      }
    },
    sass: {
      options: {
        includePaths: [
          'node_modules/bootstrap-sass/assets/stylesheets/',
        ],
        sourceMap: true
      },
      dist: {
        files: { 'assets/css/main.css': 'assets/sass/main.scss'  }
      }
    },
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: [$js_files],
        dest: 'assets/js/scripts.js',
      },
      jquery: {
        src: 'node_modules/jquery/dist/jquery.min.js',
        dest: 'assets/js/vendor/jquery.min.js'
      }
    },
    cssmin: {
      build: {
        files: {
          'assets/css/main.min.css' : 'assets/css/main.css'
        },
        options: {
          // keepBreaks: true,
          keepSpecialComments: 0
        }
      }
    },
    autoprefixer: {
      options: {
        browsers: ['last 2 versions', 'android 4', 'opera 12']
      },
      dev: {
        options: {
          map: {
            prev: 'assets/css/'
          }
        },
        src: 'assets/css/main.css'
      },
      build: {
        src: 'assets/css/main.css'
      }
    },
    modernizr: {
      build: {
        dest: 'assets/js/vendor/modernizr.min.js',
        files: {
          'src': ['assets/js/scripts.js', 'assets/css/main.css']
        },
        extra: {
          shiv: true
        },
        uglify: true,
        parseFiles: true
      }
    },
    clean: {
      src: ["assets/css/main*", "assets/js/scripts.js"]
    },
    version: {
      default: {
        options: {
          format: true,
          length: 8,
          manifest: 'assets/manifest.json',
          querystring: {
            style: 'base_css',
            script: 'base_js'
          }
        },
        files: {
          'lib/scripts.php': 'assets/{css,js}/{main,scripts}.min.{css,js}'
        }
      }
    },
    watch: {
      sass: {
        files: [
          'assets/sass/**/*.scss'
        ],
        tasks: ['sass', 'autoprefixer:dev']
      },
      js: {
        files: [
          $js_files,
          '<%= jshint.all %>'
        ],
        tasks: ['jshint', 'concat']
      }
    },

    /**
     * BrowserSync - http://browsersync.io
     */
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

  });

  // Register tasks
  //
  grunt.registerTask('serve', [
    'browserSync', 'watch'
  ]);
  grunt.registerTask('default', [
    'dev'
  ]);
  grunt.registerTask('dev', [
    'clean',
    'jshint',
    'sass',
    'autoprefixer:dev',
    'concat',
    'modernizr'
  ]);
  grunt.registerTask('build', [
    'clean',
    'jshint',
    'sass',
    'autoprefixer:build',
    'concat',
    'cssmin',
    'uglify',
    'modernizr',
    'version'
  ]);
};
