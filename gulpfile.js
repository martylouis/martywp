`use strict`;

var $url = 'base.dev'; // Local proxy address for browserSync
var $pkg = './package.json'; // Local package.json path

var $js_plugins = [
  'node_modules/fitvids/fitvids.js',
  'node_modules/jquery.mmenu/dist/jquery.mmenu.all.js',
  'node_modules/jquery.mmenu/dist/wrappers/wordpress/jquery.mmenu.wordpress.js',
];
var $sass_plugins = [
  'node_modules/normalize-scss/sass/',
  'node_modules/basscss-sass/scss'
];

var gulp = require('gulp'),
    pkg = require($pkg),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    pump = require('pump'),
    sass = require('gulp-sass'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssnano = require('cssnano'),
    sourcemaps = require('gulp-sourcemaps'),
    plumber = require('gulp-plumber'),
    svgstore = require('gulp-svgstore'),
    svgmin = require('gulp-svgmin'),
    imagemin = require('gulp-imagemin'),
    path = require('path'),
    browserSync = require('browser-sync').create();
    bump = require('gulp-bump');


// Serve Task
// --------------------------------------------
gulp.task('serve', ['sass', 'lint', 'concat'], () => {
  browserSync.init({
    proxy: $url
  });
  gulp.watch('./assets/scss/**/*.scss', ['sass']);
  gulp.watch(['./assets/js/_*.js', './gulpfile.js'], ['lint', 'concat']);
  gulp.watch('./**/*.php').on('change', browserSync.reload);
});


// JavaScript Tasks
// --------------------------------------------
// Lint source js
gulp.task('lint', () => {
  return gulp.src('./assets/js/_*.js')
    .pipe(plumber())
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});

// Concat plugins and source scripts
gulp.task('concat', () => {
  return gulp.src(
    $js_plugins.concat([
      './assets/js/plugins/**/*.js',
      './assets/js/_*.js'
    ]), {base: './assets/'})
    .pipe(plumber())
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest('assets/js/'));
});

// Minify Scripts
gulp.task('uglify', (cb) => {
  pump([
    plumber(),
    gulp.src('./assets/js/scripts.js'),
    uglify(),
    rename({suffix: '.min'}),
    gulp.dest('./assets/dist/js/')
  ], cb);
});

// Grab a local copy of jQuery
gulp.task('jquery', () => {
  return gulp.src('./node_modules/jquery/dist/jquery.min.js')
    .pipe(concat('jquery.min.js'))
    .pipe(gulp.dest('./assets/dist/js/vendor/'));
});

gulp.task('js', ['lint', 'concat', 'uglify', 'jquery']);


// Style Tasks
// --------------------------------------------
// Compile Sass to CSS
gulp.task('sass', () => {
  return gulp.src('./assets/scss/*.scss')
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: $sass_plugins
    }).on('error', sass.logError))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./assets/css/'))
    .pipe(browserSync.stream());
});

// Autoprefix and Minify CSS
gulp.task('postcss', () => {
  gulp.src('./assets/css/*.css')
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

gulp.task('css', ['sass', 'postcss']);


// SVG Tasks
// --------------------------------------------
gulp.task('svg', () => {
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

// Version Bump Tasks
// --------------------------------------------
gulp.task('patch', () => {
  gulp.src($pkg).pipe(bump()).pipe(gulp.dest('./'));
});

gulp.task('minor', () => {
  gulp.src($pkg).pipe(bump({type: 'minor'})).pipe(gulp.dest('./'));
});

gulp.task('major', () => {
  gulp.src($pkg).pipe(bump({type: 'major'})).pipe(gulp.dest('./'));
});


// Default Task
// --------------------------------------------
gulp.task('default', ['js', 'css', 'svg']);

gulp.task('build', [
  'lint',
  'concat',
  'uglify',
  'jquery',
  'sass',
  'postcss',
  'svg'
])
