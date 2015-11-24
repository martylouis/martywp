'use strict';

module.exports = function(grunt) {
  // Load all tasks
  require('load-grunt-tasks')(grunt);
  // Show elapsed time
  require('time-grunt')(grunt);

  var $bower_dir = 'assets/bower_components/';
  var $jsFileList = [
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
        'assets/js/*.js',
        '!assets/js/scripts.js',
        '!assets/**/*.min.*'
      ]
    },
    compass: {
      clean: {
        options: {
          clean: true,
          importPath: $bower_dir,
          sassDir: 'assets/sass',
          cssDir: 'assets/css',
        }
      },
      dev: {
        options: {
          importPath: $bower_dir,
          sassDir: 'assets/sass',
          cssDir: 'assets/css',
          sourcemap: true
        },
      }
    },
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: [$jsFileList],
        dest: 'assets/js/scripts.js',
      },
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
    uglify: {
      dist: {
        files: {
          'assets/js/scripts.min.js': [$jsFileList],
          'assets/js/vendor/jquery.min.js' : 'assets/bower_components/jquery/dist/jquery.min.js'
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
      compass: {
        files: [
          'assets/sass/**/*.scss'
        ],
        tasks: ['compass:dev', 'autoprefixer:dev']
      },
      js: {
        files: [
          $jsFileList,
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
    'compass:dev',
    'autoprefixer:dev',
    'concat',
    'modernizr'
  ]);
  grunt.registerTask('build', [
    'clean',
    'jshint',
    'compass',
    'autoprefixer:build',
    'concat',
    'cssmin',
    'uglify',
    'modernizr',
    'version'
  ]);
};
