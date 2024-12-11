const { defineConfig } = require('@vue/cli-service')
const webpack = require('webpack');

module.exports = defineConfig({
  transpileDependencies: true,
  configureWebpack: {
    plugins: [
      new webpack.DefinePlugin({
        '__VUE_OPTIONS_API__': JSON.stringify(true),
        '__VUE_PROD_DEVTOOLS__': JSON.stringify(false),
        '__VUE_PROD_HYDRATION_MISMATCH_DETAILS__': JSON.stringify(false)
      })
    ]
  },
  devServer: {
    //代理可以写多个，代理不同的后端地址
      proxy: {
        "/api": {
          target: "http://localhost:8081", // 将请求代理到后端的地址
          changeOrigin: true,
          pathRewrite: {
            "/api": "", // 重写路径，后端接受到的将不带/api
          }
      },
    },
  }
});
