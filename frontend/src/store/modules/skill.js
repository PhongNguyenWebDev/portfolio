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
  SET_INFO_BY_ID: (state, info) => {
    if (info && typeof info === "object") {
      // Nếu info là đối tượng, bạn có thể cập nhật hoặc thêm vào state.info
      const index = state.info.findIndex((item) => item.id === info.id);
      if (index !== -1) {
        // Cập nhật mục hiện tại nếu đã tồn tại
        state.info.splice(index, 1, info);
      } else {
        // Nếu không tồn tại, có thể thêm vào mảng
        state.info.push(info);
      }
    } else {
      console.warn("Expected info to be an object:", info);
    }
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
      const response = await axios.get("v1/admin/skills");
      commit("SET_INFO", response.data.data);
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error fetching info:", error);
    }
  },

  async createAboutMe({ commit }, newInfo) {
    try {
      const response = await axios.post("v1/admin/skills", newInfo);
      commit("ADD_INFO", response.data.data); // Thêm bản ghi vừa tạo vào store
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error creating info:", error);
    }
  },
  // get id
  async getInfoById({ commit }, id) {
    try {
      const response = await axios.get(`v1/admin/skills/${id}`);
      commit("SET_INFO_BY_ID", response.data.data); // Cập nhật state
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công

      return response.data.data; // Trả về dữ liệu để sử dụng trong component
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error fetching info:", error);

      // Có thể trả về null hoặc một giá trị mặc định khác
      return null; // Trả về null nếu có lỗi
    }
  },
  async updateInfo({ commit }, updatedInfo) {
    try {
      const response = await axios.put(
        `v1/admin/skills/${updatedInfo.id}`,
        updatedInfo
      );
      if (response.data && response.data.data) {
        commit("UPDATE_INFO", response.data.data);
      } else {
        commit("SET_ERROR", "Invalid response structure");
      }
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message);
      console.error("Error updating info:", error);
    }
  },

  async deleteInfo({ commit }, id) {
    try {
      await axios.delete(`/v1/admin/skills/${id}`, {}); // Xóain
      commit("DELETE_INFO", id); // Cập nhật state
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error deleting info:", error);
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
