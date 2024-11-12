//src/store/modules/auth.js
import axios from "axios";
import Cookies from "js-cookie";

const state = {
  user: null,
  isAuthenticated: false,
};

const mutations = {
  setUser(state, user) {
    state.user = user;
    state.isAuthenticated = true;

    const expires = 2 / 24; // 1 hour
    const tokenExpiry = new Date(
      new Date().getTime() + expires * 60 * 60 * 1000
    ).toISOString();

    // Save user data and token in cookies
    Cookies.set("user", JSON.stringify(user), {
      expires: expires,
      secure: true,
      sameSite: "Strict",
    });
    Cookies.set("token", user.token, {
      expires: expires,
      secure: true,
      sameSite: "Strict",
    });
    Cookies.set("tokenExpiry", tokenExpiry, {
      expires: expires,
      secure: true,
      sameSite: "Strict",
    });
  },
  clearUser(state) {
    state.user = null;
    state.isAuthenticated = false;
    Cookies.remove("user");
    Cookies.remove("token");
    Cookies.remove("tokenExpiry");
  },
};

const actions = {
  initializeStore({ commit, dispatch }) {
    const user = Cookies.get("user") ? JSON.parse(Cookies.get("user")) : null;
    const token = Cookies.get("token");
    const tokenExpiry = Cookies.get("tokenExpiry");

    // Lấy thời gian hiện tại ở múi giờ GMT+7 (Giờ Việt Nam)
    const currentTime = new Date().toLocaleString("vi-VN", {
      timeZone: "Asia/Bangkok",
    });
    const currentTimestamp = new Date(currentTime).getTime(); // Chuyển đổi thành timestamp

    if (user && token && tokenExpiry) {
      const expiryTime = new Date(tokenExpiry).getTime();

      // Kiểm tra xem token đã hết hạn chưa
      if (currentTimestamp > expiryTime) {
        // Token đã hết hạn, thực hiện logout
        dispatch("logout");
      } else {
        commit("setUser", user);

        // Thiết lập kiểm tra định kỳ thời gian hết hạn token
        setInterval(() => {
          const currentExpiryTime = Cookies.get("tokenExpiry");
          if (
            currentExpiryTime &&
            currentTimestamp > new Date(currentExpiryTime).getTime()
          ) {
            dispatch("logout"); // Token đã hết hạn, thực hiện logout
          }
        }, 7200000); // Kiểm tra mỗi 60 giây
      }
    } else {
      commit("clearUser");
    }
  },

  login({ commit }, user) {
    if (user && user.token) {
      commit("setUser", user);
    } else {
      console.error("Invalid user data provided for login.");
    }
  },

  async logout({ commit }) {
    const token = Cookies.get("token");

    if (!token) {
      console.error("No token found. Cannot logout.");
      commit("clearUser"); // Clear user data if no token found
      return;
    }

    try {
      const response = await axios.post(
        "v1/auth/logout", // Sử dụng biến môi trường
        {},
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      if (response.status === 200) {
        commit("clearUser"); // Xóa dữ liệu người dùng khi logout thành công
      } else {
        console.error("Logout failed:", response.data);
        commit("clearUser"); // Xóa dữ liệu người dùng ngay cả khi yêu cầu logout không thành công
      }
    } catch (error) {
      console.error("Logout failed:", error);
      commit("clearUser"); // Xóa dữ liệu người dùng ngay cả khi yêu cầu logout không thành công
    }
  },
};

const getters = {
  isAuthenticated: (state) => state.isAuthenticated,
  getUser: (state) => state.user,
  testUser: (state) => {
    return (
      state.user ||
      (Cookies.get("user") ? JSON.parse(Cookies.get("user")) : null)
    );
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
