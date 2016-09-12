// Include gulp
var gulp = require('gulp');

// Include Our Plugins
//var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var compass = require('gulp-compass'); //commented out all compass functions as couldn't get it to work
//path = require('path');
//var concat = require('gulp-concat');
//var uglify = require('gulp-uglify');
//var rename = require('gulp-rename');

// Lint Task
//gulp.task('lint', function() {
//    return gulp.src('js/*.js')
//        .pipe(jshint())
//        .pipe(jshint.reporter('default'));
//});

// Compile Our Sass
gulp.task('sass', function() {
    return gulp.src('sass/*.scss')
        .pipe(sass())
        .pipe(gulp.dest('css'));
});

// Compile with Compass
//gulp.task('compass', function() {
//  gulp.src('sass/*.scss')
//    .pipe(compass({
//     config_file: 'config.rb',
//      css: 'css',
//      sass: 'scss'
//    }))
//    .pipe(gulp.dest('css'));
//});

// Concatenate & Minify JS
//gulp.task('scripts', function() {
//    return gulp.src('js/*.js')
//        .pipe(concat('all.js'))
//        .pipe(gulp.dest('dist'))
//        .pipe(rename('all.min.js'))
//        .pipe(uglify())
//        .pipe(gulp.dest('dist/js'));
//});

// Watch Files For Changes
gulp.task('watch', function() {
//    gulp.watch('js/*.js', ['lint', 'scripts']);
    gulp.watch('sass/*.scss', ['sass']);
});

// Default Task
gulp.task('default', ['sass', 'watch']);

