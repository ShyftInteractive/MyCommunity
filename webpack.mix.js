const mix = require("laravel-mix")
const path = require("path")

mix
   .babelConfig({
      plugins: [
         "@babel/plugin-syntax-dynamic-import"
      ],
   })
   .webpackConfig({
      output: { chunkFilename: "assets/js/[name].js?id=[chunkhash]" },
      resolve: {
         alias: {
            vue$: "vue/dist/vue.runtime.esm.js",
            "@": path.resolve(process.env.MIX_INPUT_JS),
            "@@": path.resolve(process.env.MIX_INPUT_STYLE),
         },
      }
   })
   .options({
      cssNano: {
         calc: false,
         discardComments: { removeAll: true },
         normalizeWhitespace: false,
      },
      processCssUrls: false,
      postCss: [
         require("postcss-import")(),
         require("postcss-sort-media-queries")()
      ],
   })
   .sass(`${process.env.MIX_INPUT_STYLE}/app.scss`, process.env.MIX_OUTPUT_STYLE)
   .sass(`${process.env.MIX_INPUT_STYLE}/customer.scss`, process.env.MIX_OUTPUT_STYLE)
   .sass(`${process.env.MIX_INPUT_STYLE}/front.scss`, process.env.MIX_OUTPUT_STYLE)
   .js(`${process.env.MIX_INPUT_JS}/app.js`, process.env.MIX_OUTPUT_JS)
   .vue({
      extractVueStyles: true,
      globalVueStyles: false
   })
   .copyDirectory(process.env.MIX_INPUT_FILES, process.env.MIX_OUTPUT_FILES)
   .copyDirectory(process.env.MIX_INPUT_IMAGES, process.env.MIX_OUTPUT_IMAGES)
   .copyDirectory(process.env.MIX_INPUT_FONTS, process.env.MIX_OUTPUT_FONTS)
   .version()
   .sourceMaps()
