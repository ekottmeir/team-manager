// Require gulp and plugins
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    autoprefixer = require('gulp-autoprefixer'),
    gutil = require('gulp-util'),
    livereload = require('gulp-livereload');
    fileDir = './wp-content/themes/team-manager/';

livereload({ start: true });
// Define file sources
var sassMain = [fileDir + 'src/scss/main.scss'];


// Task to compile SASS files
gulp.task('sass', function() {
    gulp.src(sassMain) // use sassMain file source
        .pipe(sass({
            outputStyle: 'compressed' // Style of compiled CSS
        })
            .on('error', gutil.log)) // Log descriptive errors to the terminal
        .pipe(autoprefixer('last 2 version'))
        .pipe(gulp.dest(fileDir))// The destination for the compiled file
        .pipe(livereload());
});

// Task to watch for changes in our file sources
gulp.task('watch', function() {
    gulp.watch(fileDir + 'src/scss/**/*.*',['sass']); // If any changes in 'sassMain', perform 'sass' task
});


// Default gulp task
gulp.task('default', ['sass', 'watch']);