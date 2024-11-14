// src/main.js
import "./assets/main.css";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import axios from "./axios/axios";
import store from "./store";
import { FontAwesomeIcon } from "./assets/js/fontAwesome";
import { Toast } from "./notification/toast.js";
import "vue3-toastify/dist/index.css";
import { CkeditorPlugin } from "@ckeditor/ckeditor5-vue";
const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.config.globalProperties.$toast = Toast;
app.use(CkeditorPlugin);
app.component("font-awesome-icon", FontAwesomeIcon);
app.use(store);
app.use(router);
app.mount("#app");
// Khởi tạo store
store.dispatch("auth/initializeStore");
