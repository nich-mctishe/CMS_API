module.exports = function(grunt) {

  grunt.initConfig({
    dirs: {
      css: 'public/css',
      js: 'public/js',
      dev: {
        sass: 'resources/assets/sass',
        js: 'resources/assets/js'
      }
    },
    jshint: {
      files: ['Gruntfile.js', 'public/**/*.js', 'resources/assets/js/**.js'],
      options: {
        globals: {
          jQuery: true
        }
      }
    },
    // Sass
    sass: {
      dev: {
        files: {
          '<%= dirs.css %>/application.css': '<%= dirs.dev.sass %>/main.scss'
        }
      }
    },
    // CSS min
    cssmin: {
      dev: {
        options: {
          keepSpecialComments: 0
        },
        files: {
          '<%= dirs.css %>/application.min.css': '<%= dirs.css %>/application.css'
        }
      }
    },
    concat: {
      options: {
        // define a string to put between each file in the concatenated output
        separator: ';'
      },
      javascript: {
        // the files to concatenate
        src: ['<%= dirs.dev.js %>/libraries/*.js', '<%= dirs.dev.js %>/*.js', '<%= dirs.dev.js %>/directives/*.js', '<%= dirs.dev.js %>/services/*.js', '<%= dirs.dev.js %>/factories/*.js', '<%= dirs.dev.js %>/controllers/*.js'],
        // the location of the resulting JS file
        dest: '<%= dirs.js %>/application.js'
      }
    },
    // Uglify
    uglify: {
      options: {
        preserveComments: false,
        compress: true
      },
      dev: {
        files: {
          '<%= dirs.js %>/application.min.js': '<%= dirs.js %>/application.js'
        }
      }
    },
    // Watch
    watch: {
      css: {
        files: [
          '<%= dirs.dev.sass %>/*.scss'
        ],
        tasks: ['sass', 'cssmin']
      },
      js: {
        files: ['<%= dirs.dev.js %>/libraries/*.js', '<%= dirs.dev.js %>/*.js', '<%= dirs.dev.js %>/factories/*.js', '<%= dirs.dev.js %>/services/*.js', '<%= dirs.dev.js %>/controllers/*.js'],
        tasks: ['concat', 'uglify']
      },
      tasks: ['default']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('default', ['sass', 'cssmin', 'concat', 'uglify']);

};
