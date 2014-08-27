/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
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
				src : ['**/*.scss', '!**/_*.scss'],
				dest : 'css/',
				ext : '.css'
			} ]
		}
	},
	coffee : {
		dist : {
			files : [ {
				expand : true,
				flatten : true,
				cwd : 'assets/coffee',
				src : ['**/*.coffee'],
				dest : 'js/',
				ext : '.js'
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
				cwd : 'assets/images',
				src : ['*.png', '*.jpg'],
				dest : 'img/'
			} ]
		}
	},
    // Task configuration.
    watch: {
		dist : {
			files: ['assets/scss/**/*.scss','assets/coffee/**/*.coffee','assets/images/**/*.png','assets/images/**/*.jpg'],
			tasks: ['sass','coffee','concat'],
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
	    			'assets/js/main.js'
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
    			'assets/css/style.min.css' : [ 'assets/css/style.css' ],
    			'assets/css/ie.min.css' : [ 'assets/css/ie.css' ]
    		}
    	}
    }

  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-contrib-cssmin');

  // Default task.
  grunt.registerTask('default', ['sass','coffee','imagemin']);
  grunt.registerTask('build', ['default','concat','uglify','cssmin'])
};