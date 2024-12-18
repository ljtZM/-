const { defineConfig } = require('@vue/cli-service')
// module.exports = defineConfig({
//   transpileDependencies: true
// })

module.exports = {
  devServer: {
    client: {
      overlay: false, // 禁用 Webpack 的错误覆盖层
    },
  },
};
