import axios from "axios"; // Giả sử bạn sử dụng axios để gọi API

const state = {
  info: [],
  error: null,
};

const actions = {
  async fetchInfo({ commit }) {
    try {
      const response = await axios.get("v1/admin/icons");
      const info = Array.isArray(response.data.data) ? response.data.data : [];
      commit("SET_INFO", info);
      commit("CLEAR_ERROR");
    } catch (err) {
      commit("SET_ERROR", err.response ? err.response.data : err.message);
      console.error("Error fetching info:", err);
    }
  },
  async createInfo({ commit }, newInfo) {
    try {
      const response = await axios.post("v1/admin/icons", newInfo);
      commit("ADD_INFO", response.data.data);
      commit("CLEAR_ERROR");
    } catch (err) {
      commit("SET_ERROR", err.response ? err.response.data : err.message);
      console.error("Error creating info:", err);
    }
  },
  async getIconById({ commit }, id) {
    try {
      const response = await axios.get(`v1/admin/icons/${id}`);
      commit("SET_INFO_BY_ID", response.data.data);
      return response.data.data;
    } catch (err) {
      commit("SET_ERROR", err.response ? err.response.data : err.message);
      console.error("Error fetching info by id:", err);
    }
  },
  async updateInfo({ commit }, updatedInfo) {
    try {
      const response = await axios.put(
        `v1/admin/icons/${updatedInfo.id}`,
        updatedInfo
      );
      commit("UPDATE_INFO", response.data.data);
      commit("CLEAR_ERROR");
    } catch (err) {
      commit("SET_ERROR", err.response ? err.response.data : err.message);
      console.error("Error updating info:", err);
    }
  },
  async deleteInfo({ commit }, id) {
    try {
      await axios.delete(`v1/admin/icons/${id}`);
      commit("DELETE_INFO", id);
      commit("CLEAR_ERROR");
    } catch (err) {
      commit("SET_ERROR", err.response ? err.response.data : err.message);
      console.error("Error deleting info:", err);
    }
  },
};

const mutations = {
  SET_INFO: (state, info) => {
    state.info = Array.isArray(info) ? info : []; // Đảm bảo là mảng
  },
  ADD_INFO: (state, info) => {
    state.info.push(info);
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
  DELETE_INFO: (state, id) => {
    state.info = state.info.filter((item) => item.id !== id);
  },
  SET_ERROR: (state, error) => {
    state.error = error;
  },
  CLEAR_ERROR: (state) => {
    state.error = null;
  },
};

const getters = {
  info: (state) => state.info,
  error: (state) => state.error,
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters,
};
