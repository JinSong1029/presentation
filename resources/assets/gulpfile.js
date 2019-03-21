var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var compass = require('gulp-compass');
var jshint = require('gulp-jshint');
var rename = require("gulp-rename");
var del = require('del');

var paths = {
    build: '../../',
    scripts: {
        base: './js/**/*.js',
        libs: './lib/**/*.js'
    },
    scss: {
        main: './sass/main.scss',
        frontend: './sass/frontend.scss',
        // framework: './scss/framework.scss'
    }
};


gulp.task('js:base', [], function () {
    return gulp.src(paths.scripts.base)
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'))
        .pipe(concat('base.min.js'))
        //.pipe(uglify())
        .on('error', onError)
        .pipe(gulp.dest(paths.build + '/js'));
});

gulp.task('js:libs', [], function () {
    return gulp.src(paths.scripts.libs)
        .pipe(concat('libs.min.js'))
//        .pipe(uglify())
        .on('error', onError)
        .pipe(gulp.dest(paths.build + '/js'));
});

// handle errors and prevet gulp crash on syntax errors
function onError(err) {
    console.log(err);
    this.emit('end');
}

gulp.task('css:main', [], function () {
    return gulp.src(paths.scss.main)
        .pipe(compass({
            config_file: './config.rb',
            css: '../../css',
            sass: './sass'
        }))
        .on('error', onError)
        .pipe(gulp.dest(paths.build + '/css'));
});
gulp.task('css:frontend', [], function () {
    return gulp.src(paths.scss.frontend)
        .pipe(compass({
            config_file: './config.rb',
            css: '../../css',
            sass: './sass'
        }))
        .on('error', onError)
        .pipe(gulp.dest(paths.build + '/css'));
});

// gulp.task('css:framework', [], function () {
//     return gulp.src(paths.scss.framework)
//         .pipe(compass({
//             config_file: './config.rb',
//             css: '../assets/build/css',
//             sass: './scss'
//         }))
//         .on('error', onError)
//         .pipe(gulp.dest(paths.build + '/css'));
// });


// Rerun the task when a file changes
gulp.task('watch', function () {
    gulp.watch(paths.scripts.base, ['js:base']);
    gulp.watch('./sass/**/*.scss', ['css:main','css:frontend']);
    // gulp.watch('./scss/framework/**/*.scss', ['css:framework']);
});

// The default task (called when you run `gulp` from cli) 
gulp.task('default', ['watch', 'js:base', 'js:libs', 'css:main','css:frontend']);

gulp.task('build', ['js:base', 'js:libs', 'css:main','css:frontend']);