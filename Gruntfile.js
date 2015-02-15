module.exports = function (grunt) {

    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        bowercopy: {

           options: {
                srcPrefix: 'web/front/vendor',
                destPrefix: 'web/front'
            },
            scripts: {
                files: {
                    'scripts/jquery.js': 'jquery/dist/jquery.js',
                    'scripts/bootstrap.js': 'bootstrap-sass-official/assets/javascripts/bootstrap.js',
                    'scripts/markdown.js' : 'bootstrap-markdown/js/bootstrap-markdown.js',
                    'styles/mardown.css' : 'bootstrap-markdown/css/bootstrap-markdown.min.css',
                    'web/front/vendor/bootstrap-sass-official/assets/stylesheets/bootstrap.scss': 'web/front/vendor/bootstrap-sass-official/assets/stylesheets/_bootstrap.scss',
                }
            },
            fonts: {
                files: {
                    'fonts': 'bootstrap-sass-official/assets/fonts/bootstrap'
                }
            }
        },



        sass: {
            dist: {
                options: {
                        style: 'expanded'
                    },

                    files: {

                        'web/front/styles/bootstrap.css': 'web/front/vendor/bootstrap-sass-official/assets/stylesheets/bootstrap.scss'
                    }
                }
        },


        concat: {
            css: {
                src: [
                    'web/front/styles/bootstrap.css',
                    'web/front/styles/*.css',
                    '!web/front/styles/concat.css',
                    '!web/front/styles/min.css'
                ],
                dest: 'web/front/styles/concat.css'
            },

            js : {
                options: {
                    separator: ';'
                },
                src : [
                    'web/front/scripts/jquery.js',
                    'web/front/scripts/bootstrap.js',
                    'web/front/scripts/markdown.js',
                    'web/front/scripts/markdown-to.js',
                    'web/front/scripts/to-markdown.js',
                    '!web/front/scripts/concat.js'
                ],
                dest: 'web/front/scripts/concat.js'
            }
        },


        cssmin: {
          combine: {
                files: {
                  'web/front/styles/min.css': ['web/front/styles/concat.css', '!web/front/styles/min.css']
                }
            }
        },

        uglify: {
            options: {
                mangle: false
            },
            dist:{
                files:{
                    'web/front/scripts/app.js': ['web/front/scripts/concat.js', 'web/front/scripts/script.js']
                }
            }
        }


    });

    grunt.registerTask('default', ['bowercopy', 'sass', 'concat', 'cssmin', 'uglify']);

    grunt.registerTask('final', ['sass', 'concat', 'cssmin', 'uglify', 'bowercopy'])
};
