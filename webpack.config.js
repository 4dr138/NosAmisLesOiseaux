var Encore = require('@symfony/webpack-encore');
Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .addEntry('style', './public/assets/css/style.css')
    .addEntry('js', './public/assets/js/main.js')
    .addEntry('homepage', './public/assets/js/homepage.js')

;
// export the final configuration
module.exports = Encore.getWebpackConfig();