/**
 * Created by recchia on 21/10/15.
 */
var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify');

gulp.task('default', ['css', 'js']);

gulp.task('css', function () {
    gulp.src([
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'app/Resources/assets/css/custom.css'
    ])
        .pipe(concat('app.css'))
        .pipe(gulp.dest('web/assets/css'))
});

gulp.task('js', function () {
    gulp.src([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js',
        'app/Resources/assets/css/custom.js'
    ])
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest('web/assets/js'))
});