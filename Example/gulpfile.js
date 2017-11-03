const gulp = require('gulp'),
      browserSync = require('browser-sync')

gulp.task('server', ['watch'], () => {
  browserSync.init({
    server: {
      baseDir: './',
      port   : 1111,
    }
  })
})

gulp.task('watch', () => {
  gulp.watch('js/*.js').on('change', browserSync.reload);
  gulp.watch('index.html').on('change', browserSync.reload);
})