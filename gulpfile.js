const css_syntax = 'scss', // sass|scss
    source_dir = 'app/', // must contain js and (sass or scss) directories
    destination_dir = 'assets/'; // will receive result files in js and css subdirectories respectively

const gulp = require('gulp'),
    svgSprite = require('gulp-svg-sprite'),
	cheerio = require('gulp-cheerio'),
	replace = require('gulp-replace');
;



function generate_sprite() {
    return gulp.src('./resources/images/sprites/*.svg') // svg files for sprite
    .pipe(svgSprite({
            mode: {
                stack: {
                    sprite: "../sprite.svg"  //sprite file name
                }
            },
        }
    ))
        .pipe(gulp.dest('./resources/images/'));
}

exports.sprite = function () {
    generate_sprite();
};

gulp.task('svg', function () {
	return gulp.src('./resources/images/sprites/*.svg')
	// minify svg
		// remove all fill, style and stroke declarations in out shapes
		.pipe(cheerio({
			run: function ($) {

			},
			parserOptions: {xmlMode: true}
		}))
		// cheerio plugin create unnecessary string '&gt;', so replace it.
		.pipe(replace('&gt;', '>'))
		// build svg sprite
		.pipe(svgSprite({
			mode: {
                stack: {
					sprite: "../../public/images/sprite.svg",
				}
			}
		}))
		.pipe(gulp.dest('./images/'));
});
