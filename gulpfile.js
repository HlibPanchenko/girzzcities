'use strict';

const gulp   = require('gulp');
const sass   = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const cssBase64 = require('gulp-base64-inline');
const uglify = require('gulp-uglify-es').default;
const concat = require('gulp-concat');


const paths  = {
    'style': ['./assets/scss/style.scss'],
    'scripts': [
        './assets/js/helpers/*.js',
        './assets/js/parts/*.js'
    ],
};

/**
 * Task Callbacks
 */
function themeStyles()
{
    return gulp.src(paths.style)
        .pipe(
            sass({outputStyle: 'compressed'}).on('error', sass.logError)
        )
        .pipe(cssBase64())
        .pipe(rename({extname: '.css'}))
        .pipe(gulp.dest('.'));
}

function themeScripts()
{
    return gulp.src(paths.scripts)
        .pipe(uglify())
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest('./assets/js'));
}

function watchFiles()
{
    gulp.watch(['./assets/scss/**/*.scss', './assets/icons/*.scss'], gulp.series(themeStyles));
    gulp.watch(paths.scripts, gulp.series(themeScripts));
}

/**
 * Create Tasks.
 */
gulp.task('default', gulp.series(themeStyles, themeScripts));
gulp.task('watch', gulp.series('default', watchFiles));
