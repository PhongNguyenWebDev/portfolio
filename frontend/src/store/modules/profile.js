// src/store/modules/about-me.js
import axios from "axios"; // Giả sử bạn sử dụng axios để gọi API
import Cookies from "js-cookie"; // Đảm bảo bạn đã cài đặt js-cookie

const state = {
  info: [],
  error: null, // Thêm state để lưu trữ lỗi
};

const mutations = {
  SET_INFO: (state, info) => {
    // Mutation để lưu trữ thông tin
    state.info = info;
  },
  UPDATE_INFO: (state, updatedInfo) => {
    if (!updatedInfo || !updatedInfo.id) {
      console.warn("Received invalid updatedInfo:", updatedInfo);
      return;
    }
    // Đảm bảo state.info là mảng trước khi sử dụng findIndex
    if (Array.isArray(state.info)) {
      const index = state.info.findIndex((item) => item.id === updatedInfo.id);
      if (index !== -1) {
        state.info.splice(index, 1, updatedInfo);
      } else {
        console.warn(`Icon with id ${updatedInfo.id} not found for update.`);
      }
    } else {
      console.error("state.info is not an array:", state.info);
    }
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
      const response = await axios.get("v1/admin/profiles"); // Gọi API lấy thông tin
      commit("SET_INFO", response.data.data); // Cập nhật state
      commit("CLEAR_ERROR"); // Xóa l��i nếu thành công
      return response.data.data;
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin l��i
      console.error("Error fetching info:", error);
    }
  },
  // get id
  async updateInfo({ commit }, updatedInfo) {
    const { id } = updatedInfo; // extract id from the payload
    try {
      const response = await axios.put(`v1/admin/profiles/${id}`, updatedInfo);
      commit("UPDATE_INFO", response.data.project); // assuming response.data.project has the updated info
      commit("CLEAR_ERROR");
    } catch (error) {
      console.error("Error updating project:", error);
      commit("SET_ERROR", error.response ? error.response.data : error.message);
      throw error;
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
