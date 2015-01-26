/*global module:false*/
module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
		  '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
		  '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>',
		sass: {
			dist : {
				options : {
					require : [ 'bourbon', 'neat', 'sass-globbing' ]
				},
				files : [ {
					expand : true,
					flatten : true,
					cwd : 'assets/scss',
					src : [
						'**/*.scss',
						'!**/_*.scss',
					],
					dest : 'assets/css/',
					ext : '.css'
				} ]
			}
		},
		imagemin : {
			dist : {
				options : {
					optimizationLevel : 3
				},
				files : [ {
					expand : true,
					flatten : true,
					cwd : 'assets/img',
					src : [ '*.png', '*.jpg' ],
					dest : 'img/'
				} ]
			}
		},
		watch: {
			dist : {
				files: [
					'assets/scss/**/*.scss',
					'assets/img/**/*.png',
					'assets/img/**/*.jpg',
					'docs/src/**/*.md'
				],
				tasks: ['sass','concat'],
				options: {
					livereload: true
				}
			}
		},
		concat : {
			options : {
				separator : ';'
			},
			dist : {
				files : {
					'assets/js/build.js' : [
						'assets/js/**/*',
						'!assets/js/highlight.pack.js',
						'!assets/js/jquery-1.10.2.min.js'
					]
				}
			}
		},
		uglify : {
			dist : {
				files : {
					'assets/js/build.min.js' : [ 'assets/js/build.js' ]
				}
			}
		},
		cssmin : {
			dist : {
				files : {
					'assets/css/styles.min.css' : [ 'assets/css/styles.css' ],
					'assets/css/pattern-library.min.css' : [ 'assets/css/pattern-library.css' ],
					'assets/css/doc-styles.min.css' : [ 'assets/css/doc-styles.css' ]
				}
			}
		},
		md2html : {
			dist : {
				options : {
					layout: 'docs/src/tpl/mdtemplate.html',
					basePath: 'docs/src',
					markedOptions: {
						gfm: true
					}
				},
				files: [{
					expand : true,
					cwd : 'docs/src',
					src : [ '**/*.md' ],
					dest : 'docs',
					ext: '.html'
				}]
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-md2html');

	grunt.registerTask('default', ['sass','md2html']);
	grunt.registerTask('build', ['default','imagemin','concat','uglify','cssmin']);
};
