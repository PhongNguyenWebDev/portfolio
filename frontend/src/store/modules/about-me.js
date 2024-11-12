// src/store/modules/about-me.js
import axios from "axios"; // Giả sử bạn sử dụng axios để gọi API
import Cookies from "js-cookie"; // Đảm bảo bạn đã cài đặt js-cookie

const state = {
  info: [],
  error: null, // Thêm state để lưu trữ lỗi
};

const mutations = {
  SET_INFO(state, info) {
    state.info = info;
  },
  ADD_INFO(state, newInfo) {
    state.info.push(newInfo);
  },
  SET_INFO_BY_ID(state, info) {
    state.info = info; // Đảm bảo bạn cập nhật đúng thuộc tính trong state
  },
  UPDATE_INFO(state, updatedInfo) {
    if (!updatedInfo || !updatedInfo.id) {
      console.warn("Received invalid updatedInfo:", updatedInfo);
      return; // Exit if updatedInfo is invalid
    }
    const index = state.info.findIndex((item) => item.id === updatedInfo.id);
    if (index !== -1) {
      state.info.splice(index, 1, updatedInfo);
    }
  },

  DELETE_INFO(state, id) {
    state.info = state.info.filter((item) => item.id !== id);
  },
  SET_ERROR(state, error) {
    // Mutation để lưu trữ lỗi
    state.error = error;
  },
  CLEAR_ERROR(state) {
    // Mutation để xóa lỗi
    state.error = null;
  },
};

const actions = {
  async fetchInfo({ commit }) {
    try {
      const response = await axios.get("v1/admin/about-me");
      commit("SET_INFO", response.data.data);
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error fetching About Me info:", error);
    }
  },

  async createAboutMe({ commit }, newInfo) {
    try {
      const response = await axios.post("v1/admin/about-me", newInfo);
      commit("ADD_INFO", response.data.data); // Thêm bản ghi vừa tạo vào store
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error creating About Me info:", error);
    }
  },
  // get id
  async getAboutMeById({ commit }, id) {
    try {
      const token = Cookies.get("token");
      const response = await axios.get(`v1/admin/about-me/${id}`);
      commit("SET_INFO_BY_ID", response.data.data); // Cập nhật state
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công

      return response.data.data; // Trả về dữ liệu để sử dụng trong component
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error fetching About Me info:", error);

      // Có thể trả về null hoặc một giá trị mặc định khác
      return null; // Trả về null nếu có lỗi
    }
  },
  async updateAboutMe({ commit }, updatedInfo) {
    try {
      const token = Cookies.get("token");
      const response = await axios.put(
        `v1/admin/about-me/${updatedInfo.id}`,
        updatedInfo,
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );
      if (response.data && response.data.data) {
        commit("UPDATE_INFO", response.data.data);
      } else {
        commit("SET_ERROR", "Invalid response structure");
      }
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message);
      console.error("Error updating About Me info:", error);
    }
  },

  async deleteAboutMe({ commit }, id) {
    try {
      const token = Cookies.get("token");
      await axios.delete(`/v1/admin/about-me/${id}`, {}); // Xóain
      commit("DELETE_INFO", id); // Cập nhật state
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error deleting About Me info:", error);
    }
  },
};

const getters = {
  info: (state) => state.info,
  error: (state) => state.error, // Getter cho lỗi
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
