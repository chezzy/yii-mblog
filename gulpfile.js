var gulp = require('gulp'),
    concatCss = require('gulp-concat-css'),
    rename = require('gulp-rename'),
    notify = require('gulp-notify'),
    minifyCss = require('gulp-minify-css');

gulp.task('default', function () {
    return gulp.src('css/*.css')
        .pipe(concatCss("bundle.css"))
        .pipe(minifyCss())
        .pipe(rename("bundle.min.css"))
        .pipe(gulp.dest('out/'))
        .pipe(notify('Done!'));
});

gulp.task('watch', function () {
    gulp.watch('css/*.css', ['default'])
});

gulp.task('default', function () {
    gulp.src('view/default/javascript/*.js')
        .pipe(jsmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('view/default/javascript/min/'))
});
