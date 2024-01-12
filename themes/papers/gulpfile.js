'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');

function compileCss() {
    return gulp.src('./asset/sass/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./asset/css'));  
}

function compileScriptoCss() {
    return gulp.src('./asset/sass/scripto/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./asset/css/scripto'));  
}

function buildScriptoTheme() {
    return gulp.src('./asset/css/scripto/papers.css')
        .pipe(gulp.dest('../../modules/Scripto/asset/css/site-themes'));
}

gulp.task('css', compileCss);

gulp.task('scripto', gulp.series(compileCss, compileScriptoCss, buildScriptoTheme));

gulp.task('css:watch', function () {
    gulp.watch('./asset/sass/*.scss', gulp.parallel('css'));
});

gulp.task('scripto:watch', function () {
    gulp.watch('./asset/sass/**/*.scss', gulp.series(compileCss, compileScriptoCss, buildScriptoTheme));
});