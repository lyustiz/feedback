const mix = require('laravel-mix');
var path = require('path');

mix.webpackConfig({
    resolve: {
      alias: {
        'vue$': 'vue/dist/vue.esm.js',
        '~'   : path.resolve(__dirname, './resources/js'),
        '@components': path.resolve(__dirname, './resources/js/components'),
        '@store'     : path.resolve(__dirname, './resources/js/store'),
        '@mixins'    : path.resolve(__dirname, './resources/js/mixins'),
        '@views'     : path.resolve(__dirname, './resources/js/views'),
        '@images'    : path.resolve(__dirname, './resources/js/assets/img'),
      },
    },
  });
  
 
 let productionSourceMaps = !mix.inProduction(); productionSourceMaps, 'source-map'

  mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps(productionSourceMaps, 'source-map')
    
    if (mix.inProduction()) {
       mix.version()
   } 