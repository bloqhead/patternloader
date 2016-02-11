/* global module:false */
module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		banner:
			'/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
			'<%= grunt.template.today("yyyy-mm-dd") %>\n' +
		  '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>',

		// Sass
		sass: {
			dist : {
				options : {
					require : [
						'bourbon',
						'neat',
						'sass-globbing'
					]
				},
				files : [ {
					expand : true,
					flatten : true,
					cwd : 'public/assets/scss',
					src : [
						'styles.scss'
					],
					dest : 'public/assets/css',
					ext : '.css'
				} ]
			}
		},

		// Asset Watch
		watch: {
			dist : {
				files: [
					'public/assets/scss/**/*.scss',
					'public/assets/scss/styles.scss',
					'docs/src/**/*.md'
				],
				tasks: [
					'sass',
					'concat',
					'md2html'
				],
				options: {
					livereload: true
				}
			}
		},

		// Coffeescript
    coffee : {
      dist : {
        files : [ {
          expand : true,
          flatten : true,
          cwd : 'public/assets/coffee',
          src : [
          	'**/*.coffee'
          ],
          dest : 'public/assets/js',
          ext : '.js'
        } ]
      }
    },

		// JS Concatenation
		concat : {
			options : {
				separator : ';'
			},
			dist : {
				files : {
					'public/assets/js/build.js' : [
						'public/assets/js/**/*.js'
					]
				}
			}
		},

		// JS Uglification
		uglify : {
			dist : {
				files : {
					'public/assets/js/build.min.js' : [
						'public/assets/js/build.js'
					]
				}
			}
		},

		// CSS Minification
		cssmin : {
			dist : {
				files : {
					'public/assets/css/styles.min.css': [
						'public/assets/css/styles.css'
					]
				}
			}
		},

		// Markdown to HTML
		md2html : {
			dist : {
				options : {
					layout: 'system/md-docs-template.html',
					basePath: 'public/docs/src',
					markedOptions: {
						gfm: true
					}
				},
				files: [{
					expand : true,
					cwd : 'public/docs/src',
					src : [
						'**/*.md'
					],
					dest : 'public/docs',
					ext: '.html'
				}]
			}
		}

	});

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-coffee');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-md2html');

	grunt.registerTask('default', ['sass','md2html','coffee','concat']);
	grunt.registerTask('build', ['default','uglify','cssmin']);
};
