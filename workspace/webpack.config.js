const toml = require("toml");
const yaml = require("yamljs");
const json5 = require("json5");
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
      use: {
        loader: "file-loader",
      },
    },
    {
      test: /\.(woff|woff2|eot|ttf|otf)$/i,
      use: {
        loader: "file-loader",
      },
    },
    {
      test: /\.(csv|tsv)$/i,
      use: {
        loader: "csv-loader",
      },
    },
    {
      test: /\.xml$/i,
      use: {
        loader: "xml-loader",
      },
    },
    {
      test: /\.toml$/i,
      type: "json",
      parser: {
        parse: toml.parse,
      },
    },
    {
      test: /\.yaml$/i,
      type: "json",
      parser: {
        parse: yaml.parse,
      },
    },
    {
      test: /\.json5$/i,
      type: "json",
      parser: {
        parse: json5.parse,
      },
    },
  ];
}

const configs = {
  devtool: "inline-source-map",
  entry: "./resources/js/index.js",
  output: {
    filename: "bundle.js",
    path: path.resolve(__dirname, "./public"),
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
