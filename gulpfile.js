/**
 * Created by recchia on 21/10/15.
 */
var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify');

gulp.task('default', ['css', 'js', 'fonts']);

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
        'app/Resources/assets/css/custom.js',
        'web/bundles/fosjsrouting/js/router.js',
        'web/js/fos_js_routes.js'
    ])
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest('web/assets/js'))
});

gulp.task('fonts', function () {
    gulp.src('bower_components/bootstrap/dist/fonts/*.{eot,svg,ttf,woff,woff2}')
      .pipe(gulp.dest('web/assets/fonts'))
});