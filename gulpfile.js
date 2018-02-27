// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var sass = require('gulp-sass'),
    prefix = require('gulp-autoprefixer'),
    notify = require('gulp-notify'),
    uglify = require('gulp-uglify'),
    include = require('gulp-include');

var sassIncludes = [
    'resources/sass/',
    'node_modules/'
];

var jsIncludes = [
    'resources/js/',
];

gulp.task('sass', function() {
    return gulp.src(__dirname + '/resources/sass/*.scss')
        .pipe(sass({
            sourceStyle: 'compressed',
            includePaths: sassIncludes,
            errLogToConsole: false,
            onError: function(err) {
                console.log(err);
                return notify().write(err);
            }
        }))
        .on('error', notify.onError())
        .pipe(
            // prefix(["last 2 versions", "> 1%", "ie 8", "ie 7"], { cascade: true })
            prefix({
              browsers: ['last 2 versions', 'ie >= 9', 'Android >= 2.3', 'ios >= 7']
            })
        )
        // .pipe(cleanCss())
        .pipe(gulp.dest('./web/css'))
        // .pipe(notify("SASS compilation complete: <%=file.relative%>"))
        ;
});

gulp.task('js', function() {
    return gulp.src([__dirname + '/resources/js/*.js'])
        .pipe(include({
            includePaths: jsIncludes
        }))
        // .pipe(uglify())
        .on('error', notify.onError())
        .pipe(gulp.dest('./web/js'))
        // .pipe(notify("JS compilation complete: <%=file.relative%>"))
        .on('error', notify.onError())
        ;
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch('./resources/sass/**/*.scss', ['sass']);
    gulp.watch('./resources/js/**/*.js', ['js']);
});

// Default Task
gulp.task('default', [
    'sass',
    'js',
    'watch'
]);
