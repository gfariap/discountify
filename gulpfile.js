var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifyCSS = require('gulp-minify-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');

var sassPath = 'resource/assets/sass';
var vendorPath = 'node_modules';
var jsPath = 'resource/assets/js';

var jsDependencies = [
    vendorPath + '/jquery/dist/jquery.min.js',
    vendorPath + '/bootstrap-sass/assets/javascripts/bootstrap.js'
];

var targetCSS = 'public/css';
var targetJS = 'public/js';

gulp.task('css', function() {
    return gulp.src(sassPath + '/app.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer('last 10 version'))
        .pipe(minifyCSS())
        .pipe(gulp.dest(targetCSS));
});

gulp.task('js', function() {
    return gulp.src(jsDependencies)
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest(targetJS));
});

gulp.task('watch', function() {
    gulp.watch(sassPath + '/**/*.scss', ['css']);
});

gulp.task('default', ['css', 'js', 'watch']);
