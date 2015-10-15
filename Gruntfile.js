module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      build: {
        src: 'src/js/*.js',
        dest: 'js/scripts.min.js'
      },
      dev: {
          options: {
              beautify: true,
              mangle: false,
              compress: false,
              preserveComments: 'all'
          },
          src: 'src/js/*.js',
          dest: 'js/scripts.min.js'
      }
    },
   concat: {
        css: {
           src: 'src/css/*.css',
           dest: 'src/cache/concat.css'
        }
    },
    cssmin: {
        css:{
          src: 'src/cache/concat.css',
          dest: 'css/styles.min.css'
        }
    },
    watch: {
        js: {
            files: ['src/js/*.js'],
            tasks: ['uglify:dev']
        },
        css: {
            //files: ['/less/**/*.less'],
            files: ['src/css/*.css'],
            tasks: ['concat', 'cssmin']
            //tasks: ['cssmin']
        }
    },
    less: {
        dev: {
            options: {
                paths: ["./src/less"],
                yuicompress: false
            },
            files: {
                'css/styles.css' : 'src/less/application.less'
            }
        },
        build: {
            options: {
                paths: ["./src/less"],
                yuicompress: true
            },
            files: {
                'css/styles.css' : 'src/less/application.less'
            }
        }
    }

  });

  // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-css');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');


    // Default task(s).
    //grunt.registerTask('default', ['uglify:dev','less:dev']);
    grunt.registerTask('default', ['uglify:dev', 'concat', 'cssmin']);
    grunt.registerTask('build', ['uglify:build', 'concat', 'cssmin']);

};

