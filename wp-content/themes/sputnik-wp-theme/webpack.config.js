const webpack = require("webpack");
const path = require("path");

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const UglifyJSPlugin = require("uglifyjs-webpack-plugin");
const OptimizeCssAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const CopyPlugin = require("copy-webpack-plugin");

module.exports = {
  entry: {
    public: "./app/public/public.js",
    admin: "./app/admin/admin.js",
  },  
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "[name]/[name].bundle.js",
  },
  mode: "development",
  devtool: "source-map",
  module: {
    rules: [
      {
        // Please disable default jQuery in Wordpress on Frontend & use newest version
        test: require.resolve("jquery"),
        loader: "expose-loader",
        options: {
          exposes: {
            globalName: ["$", "jQuery"],
            override: true,
          },
        },
      },
      {
        // If using cookies js
        test: require.resolve("js-cookie"),
        loader: "expose-loader",
        options: {
          exposes: ["Cookies"],
        },
      },
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
          },
        },
      },
      {
        test: /\.s?[ac]ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: "css-loader",
            options: {
              url: true,
              sourceMap: true,
              importLoaders: 1
            }
          },
          {
            loader: 'postcss-loader'
          },
          {
            loader: "sass-loader",
            options: {
              sourceMap: true
             }
          },
        ],
      },
      {
        test: /\.(png|svg|jpe?g|gif)$/,
        use: {
          loader: "file-loader",
          options: {
            outputPath: (url, resourcePath, context) => {
              const relativePath = path.relative(context, resourcePath);
              const outputPath = relativePath.replace("app", "");

              return outputPath;
            },
            publicPath: (url, resourcePath, context) => {
              const relativePath = path.relative(context, resourcePath);
              const publicPath = relativePath.replace("app", "");

              return `../images/${url}`;
            },
            name: "[name].[ext]",
            limit: 10000,
          },
        },
      },
      {
        test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
        use: [
          {
            loader: "file-loader",
            options: {
              name: "[name].[ext]",
              outputPath: (url, resourcePath, context) => {
                const relativePath = path.relative(context, resourcePath);
                const outputPath = relativePath.replace("app", "");

                return outputPath;
              },
            },
          },
        ],
      },
    ],
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
    }),
    new MiniCssExtractPlugin({
      path: path.resolve(__dirname, ""),
      filename: "[name]/styles/style.css",
    }),
    new CopyPlugin({
      patterns: [
        //** Copy working properly when folder images isnt empty **//
        { from: "app/public/images", to: "public/images" },
        { from: "app/admin/images", to: "admin/images" },
      ],
    }),
  ],
  optimization: {
    minimizer: [new UglifyJSPlugin(), new OptimizeCssAssetsPlugin()],
  },
};
