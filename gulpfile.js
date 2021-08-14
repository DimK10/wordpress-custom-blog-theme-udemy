var gulp = require('gulp');
var rename = require('gulp-rename');
const sass = require('gulp-sass')(require('sass'));
const del = require('del');
const concat = require('gulp-concat');

gulp.task('styles', async function() {
    await gulp.src('scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('style.css'))
        .pipe(gulp.dest('./css/'));
});

gulp.task('clean', async function() {
    await del([
        'css/style.css',
    ]);
});

gulp.task('copy-modules', async function() {
    await gulp.src('src/modules/**/*.*')
        .pipe(gulp.dest('js/modules/'));
});

gulp.task('copy-scripts', async function() {
    await gulp.src('src/index.js')
        .pipe(rename({ basename: 'scripts' }))
        .pipe(gulp.dest('js'));
});

gulp.task('copy-js', gulp.series('clean', 'styles', 'copy-modules' ,'copy-scripts'))