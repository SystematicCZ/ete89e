const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

const prefix = process.env.NODE_ENV === 'dev' ? '' : '/2021zs/ete89e/07';

Encore
  .setOutputPath('public/build/')
  .setPublicPath(`${prefix}/build`)
  .setManifestKeyPrefix('build')
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .addEntry('js/main', './src/main.js')
  .addStyleEntry('style', './assets/scss/style.scss')
  .disableSingleRuntimeChunk()
  .addPlugin(new CopyWebpackPlugin({
    patterns: [
      { from: 'assets/images', to: 'images' },
      { from: 'assets/svg', to: 'images/svg' },
    ],
  }))
  .enableSassLoader((options) => {
    options.additionalData = '@import "variables";';
    options.sassOptions.includePaths = [path.resolve(__dirname, './assets/scss/')];
  })
  .enableVueLoader();

module.exports = Encore.getWebpackConfig();
