const path = require("path");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");

function getRules(mode) {
  return [
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
      test: /\.css$/i,
      use: [
        { loader: "style-loader" },
        {
          loader: "css-loader",
          options: {
            sourceMap: mode !== "production",
          },
        },
      ],
    },
    {
      test: /\.s[ac]ss$/i,
      use: [
        { loader: "style-loader" },
        {
          loader: "css-loader",
          options: {
            sourceMap: mode !== "production",
          },
        },
        {
          loader: "sass-loader",
          options: {
            sourceMap: mode !== "production",
          },
        },
      ],
    },
    {
      test: /\.(png|svg|jpg|jpeg|gif)$/i,
      type: "asset/resource",
    },
    {
      test: /\.(woff|woff2|eot|ttf|otf)$/i,
      type: "asset/resource",
    },
  ];
}

const configs = {
  devtool: "inline-source-map",
  entry: {
    index: "./resources/js/index.js",
    adminLogin: "./resources/js/adminLogin.js",
  },
  output: {
    filename: "[name].bundle.js",
    path: path.resolve(__dirname, "./public/vendor"),
    clean: true,
  },
  module: {
    rules: getRules("development"),
  },
  plugins: [new CleanWebpackPlugin()],
};

module.exports = (env, argv) => {
  if (argv.mode === "production") {
    configs.devtool = undefined;
    configs.module.rules = getRules("production");
  }

  return configs;
};
