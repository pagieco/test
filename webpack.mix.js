const fs = require('fs');
const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

fs.readdirSync('resources/modules')
  .forEach((dir) => {
    if (fs.existsSync(`resources/modules/${dir}/js/index.js`)) {
      mix.js(`resources/modules/${dir}/js/index.js`, `public/js/${dir}.js`);
    }

    if (fs.existsSync(`resources/modules/${dir}/sass/index.scss`)) {
      mix.sass(`resources/modules/${dir}/sass/index.scss`, `public/css/${dir}.css`);
    }
  });

mix.options({
  processCssUrls: false,
  postCss: [
    tailwindcss('./tailwind.config.js'),
  ],
}).webpackConfig({
  output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
}).version();
