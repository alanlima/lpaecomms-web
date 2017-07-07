var gulp = require('gulp');
var gutil = require('gulp-util');
var ftp = require('vinyl-ftp');
var clean = require('gulp-clean');
var fs = require('fs');

/** Configuration **/
// var user = process.env.FTP_USER;
// var password = process.env.FTP_PWD;
// var user = '';
// var password = ''
// var host = 'files.000webhost.com';
// var port = 21;
var ftpDeployFilePath = './ftp-deploy.json' // File Struct: { user, host, port, pwd }
var localFilesGlob = ['./dist/**/*', './dist/.htaccess', '!./dist/config.php'];
var remoteFolder = '/public_html'

// helper function to build an FTP connection based on our configuration
function getFtpConnection() {
    var ftpDeploy = JSON.parse(fs.readFileSync('./ftp-deploy.json'));

    return ftp.create({
        host: ftpDeploy.host,
        port: ftpDeploy.port || 21,
        user: ftpDeploy.user,
        password: ftpDeploy.pwd,
        parallel: 5,
        log: gutil.log
    });
}

/**
 * Deploy task.
 * Copies the new files to the server
 *
 * Usage: `FTP_USER=someuser FTP_PWD=somepwd gulp ftp-deploy`
 */
gulp.task('ftp-deploy', function () {

    var conn = getFtpConnection();

    return gulp.src(localFilesGlob, { base: 'dist', buffer: false })
        .pipe(conn.newer(remoteFolder)) // only upload newer files 
        .pipe(conn.dest(remoteFolder))
        ;
});

/**
 * Watch deploy task.
 * Watches the local copy for changes and copies the new files to the server whenever an update is detected
 *
 * Usage: `FTP_USER=someuser FTP_PWD=somepwd gulp ftp-deploy-watch`
 */
gulp.task('ftp-deploy-watch', function () {

    var conn = getFtpConnection();

    gulp.watch(localFilesGlob)
        .on('change', function (event) {
            console.log('Changes detected! Uploading file "' + event.path + '", ' + event.type);

            return gulp.src([event.path], { base: 'dist', buffer: false })
                .pipe(conn.newer(remoteFolder)) // only upload newer files 
                .pipe(conn.dest(remoteFolder))
                ;
        });
});

var filesToMove = [
        './api/**/*.*',
        './Controllers/**/*.*',
        './css/**/*.*',
        './Database/**/*.*',
        './font-awesome/**/*.*',
        './images/**/*.*',
        './js/**/*.*',
        './Models/**/*.*',
        './MySQL/**/*.*',
        '.htaccess',
        '*.php',
        '*.html'
    ];

gulp.task('clean', function(){
  return gulp.src(['dist/*'], {read:false})
  .pipe(clean());
});

gulp.task('move',['clean'], function(){
  // the base option sets the relative root for the set of files,
  // preserving the folder structure
  gulp.src(filesToMove, { base: './' })
  .pipe(gulp.dest('dist'));
});


gulp.task('build', ['move']);

gulp.task('deploy', ['ftp-deploy']);