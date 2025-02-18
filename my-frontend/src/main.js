import './assets/css/main.css'
import '@fortawesome/fontawesome-free/css/all.min.css';
import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import './assets/css/main.css';
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(router)
app.use(ElementPlus, { size: 'small', zIndex: 3000 })
app.mount('#app')

