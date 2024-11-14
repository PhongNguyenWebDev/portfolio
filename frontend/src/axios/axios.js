import axios from "axios";
import Cookies from "js-cookie";
import dayjs from "dayjs"; // Thư viện xử lý thời gian
import utc from "dayjs/plugin/utc"; // Plugin để xử lý UTC
import timezone from "dayjs/plugin/timezone"; // Plugin để xử lý múi giờ

// Kích hoạt các plugin
dayjs.extend(utc);
dayjs.extend(timezone);

axios.defaults.withCredentials = true;
axios.defaults.baseURL =
  import.meta.env.VITE_APP_API_URL || "http://localhost:8000/api"; // Sử dụng biến môi trường
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.xsrfCookieName = "XSRF-TOKEN"; // Tên cookie CSRF Laravel dùng mặc định
axios.defaults.xsrfHeaderName = "X-XSRF-TOKEN"; // Tên header để gửi token

// Thêm interceptor cho request để thêm token
axios.interceptors.request.use(
  (config) => {
    const token = Cookies.get("token"); // Lấy token từ cookie
    if (token) {
      config.headers.Authorization = `Bearer ${token}`; // Thêm token vào header
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Thêm interceptor cho response để xử lý lỗi và chuyển đổi thời gian
axios.interceptors.response.use(
  (response) => {
    // Giả sử thời gian bạn nhận được từ API có dạng UTC
    if (response.data && response.data.timestamp) {
      // Kiểm tra xem có trường timestamp không
      // Chuyển đổi thời gian sang múi giờ địa phương (ví dụ: Việt Nam)
      response.data.localTime = dayjs
        .utc(response.data.timestamp)
        .tz("Asia/Ho_Chi_Minh")
        .format("YYYY-MM-DD HH:mm:ss");
    }
    return response; // Trả về response bình thường
  },
  (error) => {
    if (error.response && error.response.status === 401) {
      // Nếu lỗi là 401, nghĩa là token đã hết hạn hoặc không hợp lệ
      store.dispatch("auth/logout"); // Gọi action logout trong Vuex để xoá token
      router.push("/"); // Điều hướng về trang đăng nhập
    }
    return Promise.reject(error); // Trả về lỗi để các nơi khác có thể xử lý tiếp
  }
);

export default axios;
