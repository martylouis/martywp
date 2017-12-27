`use strict`;

/////////////////////////////
// Config
/////////////////////////////

var $url = 'martywp.dev'; // Local proxy address for browserSync
var $pkg = './package.json'; // Local package.json path
var pkg = require($pkg);


// Paths
var $scss_plugin_paths = [
  // 'node_modules/basscss-sass/scss'
];
var $js_path = './assets/scss/*.scss';
var $js_plugin_paths = [
  'node_modules/fitvids/fitvids.js',
  'node_modules/jquery.mmenu/dist/jquery.mmenu.all.js',
  'node_modules/jquery.mmenu/dist/wrappers/wordpress/jquery.mmenu.wordpress.js',
];

/////////////////////////////
// Load Plugins
/////////////////////////////

var gulp = require('gulp'),

    // Styles
    sass = require('gulp-sass'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssnano = require('cssnano'),
    mqpacker = require('css-mqpacker'),

    // Scripts
    jshint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),

    // Img/Svg
    svgmin = require('gulp-svgmin'),
    imagemin = require('gulp-imagemin'),
    svgstore = require('gulp-svgstore'),

    // Utils
    clean = require('gulp-clean'),
    rename = require('gulp-rename'),
    pump = require('pump'),
    sourcemaps = require('gulp-sourcemaps'),
    plumber = require('gulp-plumber'),
    path = require('path'),
    notify = require('gulp-notify'),
    browserSync = require('browser-sync').create(),
    reload = browserSync.reload,
    bump = require('gulp-bump');


function plumberNotify(error) {
  notify.onError({
    title: "Gulp Error in " + error.plugin,
    message: error.message.toString()
  })(error);
}


// Style Tasks
// --------------------------------------------

gulp.task("sass", cb => {
  pump(
    [
      plumber({
        errorHandler: error => {
          plumberNotify(error);
        }
      }),
      gulp.src("./assets/scss/*.scss"),
      sourcemaps.init(),
      sass(),
      postcss([mqpacker()]),
      sourcemaps.write("./"),
      gulp.dest("./assets/css/"),
      browserSync.stream()
    ],
    cb()
  );
});

gulp.task('mincss', ['clean-dist', 'sass'], () => {
  return gulp.src('./assets/css/*.css')
  .pipe(plumber())
  .pipe(postcss([
    autoprefixer({ browsers: ['last 2 versions'] }),
    cssnano({
        discardComments: {removeAll: true},
      })
    ]))
  .pipe(rename({suffix: '.min'}))
  .pipe(gulp.dest('./assets/dist/css/'));
});


// Clean Dist
// --------------------------------------------
gulp.task('clean-dist', () => {
  return gulp.src('./assets/dist/')
    .pipe(plumber())
    .pipe(clean());
});


// JavaScript Tasks
// --------------------------------------------
// Lint source js
gulp.task('lint', () => {
  pump([
    plumber({
      errorHandler: (error) => {
        plumberNotify(error);
      }
    }),
    gulp.src('./assets/js/_*.js'),
    jshint(),
    jshint.reporter('default')
  ]);
});

// Concat plugins and source scripts
gulp.task('concat', ['lint'], () => {
  return gulp.src(
    $js_plugin_paths.concat([
      './assets/js/plugins/**/*.js',
      './assets/js/_*.js'
    ]), {base: './assets/'})
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest('assets/js/'));
});

// Minify Scripts
gulp.task('uglify', ['clean-dist', 'lint', 'concat'], (cb) => {
  pump([
    plumber(),
    gulp.src('./assets/js/scripts.js'),
    uglify(),
    rename({suffix: '.min'}),
    gulp.dest('./assets/dist/js/')
  ], cb());
});

// Grab a local copy of jQuery
gulp.task('jquery', ['clean-dist'], () => {
  return gulp.src('./node_modules/jquery/dist/jquery.min.js')
    .pipe(concat('jquery.min.js'))
    .pipe(gulp.dest('./assets/dist/js/vendor/'));
});



// SVG Tasks
// --------------------------------------------
gulp.task('svg', ['clean-dist'], () => {
  return gulp.src('./assets/svg/*.svg')
    .pipe(plumber())
    .pipe(imagemin([
      imagemin.svgo({plugins: [{removeTitle: true}]})
    ]))
    .pipe(rename({prefix: 'svg-'}))
    .pipe(svgstore({ inlineSvg: true }))
    .pipe(rename({extname: '.php'}))
    .pipe(gulp.dest('./assets/dist/'));
});

// Image min tasks
// --------------------------------------------
gulp.task('img', ['clean-dist'], () => {
  return gulp.src('./assets/img/*')
    .pipe(plumber())
    .pipe(imagemin())
    .pipe(gulp.dest('./assets/dist/img/'));
});


// Version Bump Tasks
// --------------------------------------------
gulp.task('bump:pre', () => {
  gulp.src($pkg).pipe(bump({type: 'prerelease'}))
    .pipe(gulp.dest('./'));
});
gulp.task('bump', () => {
  gulp.src($pkg)
    .pipe(bump())
    .pipe(gulp.dest('./'));
});

gulp.task('bump:minor', () => {
  gulp.src($pkg)
    .pipe(bump({type: 'minor'}))
    .pipe(gulp.dest('./'));
});

gulp.task('bump:major', () => {
  gulp.src($pkg)
    .pipe(bump({type: 'major'}))
    .pipe(gulp.dest('./'));
});


// Serve Task
// --------------------------------------------
gulp.task('serve', () => {
  browserSync.init({
    proxy: $url,
    notify: false,
    open: false
  });
  gulp.watch('./assets/scss/**/*.scss', ['sass']);
  gulp.watch('./assets/js/**/*.js', ['lint', 'concat']).on('change', reload);
  gulp.watch('**/*.php').on('change', reload);
});


// Default Task
// --------------------------------------------
gulp.task('test', [
  'sass',
  'lint',
]);

gulp.task('build', [
  'clean-dist',
  'mincss',
  'uglify',
  'jquery',
  'svg',
  'img'
])

gulp.task('default', ['test']);
