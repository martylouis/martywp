import gulp, { task, src, dest, watch, parallel, series } from "gulp"; // eslint-disable-line

// Utils
import del from "del";
import plumber from "gulp-plumber";
import rename from "gulp-rename";
import { init, write } from "gulp-sourcemaps";
import bump from "gulp-bump";
import print from "gulp-print";

// Scripts
import concat from "gulp-concat";
import jshint, { reporter } from "gulp-jshint";
import uglify from "gulp-uglify-es";
import pump from "pump";

// Styles
import sass, { logError } from "gulp-sass";
import postcss from "gulp-postcss";
import cachebuster from "postcss-cachebuster";
import autoprefixer from "autoprefixer";
import cssnano from "cssnano";
import mqpacker from "css-mqpacker";

// Images
import imagemin from "gulp-imagemin";
import svgstore from "gulp-svgstore";

// Browsersync
const browserSync = require("browser-sync").create(); // eslint-disable-line
const reload = browserSync.reload; // eslint-disable-line

// Dev Proxy
const proxy = "martywp.localsite";

// --------------------------
// Paths
// --------------------------
const path = {
  assets: "assets/",
  temp: ".temp",
  dist: "assets/dist",
  scss: {
    src: `${path.assets}/scss/*.scss`,
    glob: `${path.assets}/scss/**/*.scss`
  },
  css: {
    src: `${path.temp}/css`,
    glob: `${path.temp}/css/*.css`,
    dist: `${path.dist}/css`
  },
  // styles: {
  //   scss: "./assets/scss/*.scss",
  //   scss_glob: "./assets/scss/**/*.scss",
  //   css_tmp: "./assets/./tmp/css",
  //   src_glob: "./assets/css/*.css",
  //   dest: "./assets/dist/css",
  //   vendor: [
  //     "node_modules/jquery.mmenu/dist/",
  //     "node_modules/slick-carousel/slick/"
  //   ]
  // },
  // scripts: {
  //   js_tmp: "./assets/.tmp/js/scripts.js",
  //   src_glob: "./assets/js/**/_*.js",
  //   src_dest: "./assets/js/",
  //   plugins: "./assets/js/plugins/**/*.js",
  //   dest: "./assets/dist/js/",
  //   jquery: "./node_modules/jquery/dist/jquery.min.js",
  //   vendor: [
  //     "node_modules/fitvids/fitvids.js",
  //     "node_modules/jquery.mmenu/dist/jquery.mmenu.all.js",
  //     "node_modules/jquery.mmenu/dist/wrappers/wordpress/jquery.mmenu.wordpress.js"
  //     // "node_modules/slick-carousel/slick/slick.js",
  //     // "node_modules/instafeed.js/instafeed.min.js"
  //   ]
  // },
  svg: {
    src: "./assets/svg/*.svg",
    dest: "./components/"
  },
  img: {
    src: "./assets/img/*",
    dest: "./assets/dist/img/"
  },
  package: "./package.json"
};

// --------------------------
// Clean
// --------------------------
export const clean = () => del("assets/dist");

// --------------------------
// Styles
// --------------------------
export function scss() {
  return src(path.scss.src)
    .pipe(plumber())
    .pipe(print())
    .pipe(init())
    .pipe(sass({ includePaths: path.styles.vendor }).on("error", logError))
    .pipe(write("./"))
    .pipe(dest(path.styles.css_tmp))
    .pipe(browserSync.stream());
}
task("scss", scss);

export function css() {
  return src(path.styles.src_glob)
    .pipe(plumber())
    .pipe(print())
    .pipe(
      postcss([
        cachebuster(),
        autoprefixer({
          browsers: ["last 1 versions", "IE 11"],
          grid: true
        }),
        mqpacker({ sort: true }),
        cssnano({
          discardComments: { removeAll: true },
          mergeRules: true
        })
      ])
    )
    .pipe(rename({ suffix: ".min" }))
    .pipe(dest(path.styles.dest));
}

const styles = series(scss, css);

// --------------------------
// Scripts
// --------------------------
export function jslint() {
  return src(path.scripts.src_glob)
    .pipe(plumber())
    .pipe(jshint())
    .pipe(reporter("default"));
}
task("jslint", jslint);

export function jsconcat() {
  return src(
    Object.values(path.scripts.vendor).concat([
      path.scripts.plugins,
      path.scripts.src_glob
    ]),
    { base: "./assets/" }
  )
    .pipe(plumber())
    .pipe(concat("scripts.js"))
    .pipe(dest(path.scripts.src_dest));
}
task("jsconcat", jsconcat);

export function jsuglify(cb) {
  pump(
    [
      src(path.scripts.src),
      rename({ suffix: ".min" }),
      uglify(),
      dest(path.scripts.dest)
    ],
    cb
  );
}

export function jquery() {
  return src(path.scripts.jquery)
    .pipe(concat("jquery.min.js"))
    .pipe(dest(path.scripts.dest));
}

const scripts = series(jslint, jsconcat, jsuglify, jquery);
task("scripts", scripts);

// --------------------------
// Images & SVG
// --------------------------
export function img() {
  return src(path.img.src)
    .pipe(plumber())
    .pipe(imagemin())
    .pipe(dest(path.img.dest));
}

export function svg() {
  return src(path.svg.src)
    .pipe(plumber())
    .pipe(imagemin([imagemin.svgo({ plugins: [{ removeTitle: true }] })]))
    .pipe(rename({ prefix: "svg-" }))
    .pipe(svgstore({ inlineSvg: true }))
    .pipe(rename({ extname: ".php" }))
    .pipe(dest(path.svg.dest));
}

const imgs = series(img, svg);
task("imgs", imgs);

// --------------------------
// Bump
// --------------------------
task("bump", () =>
  src(path.package)
    .pipe(bump())
    .pipe(dest("./"))
);

task("bump:pre", () =>
  src(path.package)
    .pipe(bump({ type: "prerelease" }))
    .pipe(dest("./"))
);

task("bump:minor", () =>
  src(path.package)
    .pipe(bump({ type: "minor" }))
    .pipe(dest("./"))
);

task("bump:major", () =>
  src(path.package)
    .pipe(bump({ type: "major" }))
    .pipe(dest("./"))
);

// --------------------------
// Serve
// --------------------------
export function serve() {
  browserSync.init({
    proxy,
    notify: true,
    open: false,
    files: ["**/*.php"]
  });
  watch(path.styles.scss_glob, series("scss"));
  watch(path.scripts.src_glob, series("jslint", "jsconcat")).on(
    "change",
    reload
  );
}

// --------------------------
// Build
// --------------------------
const build = series(clean, parallel(styles, scripts, img, svg));
task("build", build);

// --------------------------
// Default
// --------------------------
export default build;
