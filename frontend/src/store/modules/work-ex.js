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
  ADD_NEW_WORK_EX(state, newWorkEx) {
    state.info.push(newWorkEx);
  },
  SET_INFO_BY_ID(state, info) {
    state.aboutMe = info; // Đảm bảo bạn cập nhật đúng thuộc tính trong state
  },
  UPDATE_WORK_EX(state, updatedWorkEx) {
    if (!updatedWorkEx || !updatedWorkEx.id) {
      console.warn("Received invalid updatedWorkEx:", updatedWorkEx);
      return; // Exit if updatedWorkEx is invalid
    }
    const index = state.info.findIndex((item) => item.id === updatedWorkEx.id);
    if (index !== -1) {
      state.info.splice(index, 1, updatedWorkEx);
    }
  },
  DELETE_WORK_EX(state, id) {
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
  async fetchWorkEx({ commit }) {
    try {
      const response = await axios.get("/v1/admin/work-experience");
      commit("SET_INFO", response.data.data);
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error fetching Work Ex info:", error);
    }
  },
  async createWorkEx({ commit }, newWorkEx) {
    try {
      const response = await axios.post("/v1/admin/work-experience", newWorkEx);
      commit("ADD_NEW_WORK_EX", response.data.data); // Thêm bản ghi vừa tạo vào store
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error creating Work Ex:", error);
    }
  },
  // get id
  async getWorkExById({ commit }, id) {
    try {
      const response = await axios.get(`v1/admin/work-experience/${id}`);
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
  async updateWorkEx({ commit }, updatedWorkEx) {
    try {
      const token = Cookies.get("token");
      const response = await axios.put(
        `/v1/admin/work-experience/${updatedWorkEx.id}`,
        updatedWorkEx,
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );
      if (response.data && response.data.data) {
        commit("UPDATE_WORK_EX", response.data.data); // Cập nhật thông tin trong store
        commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
      } else {
        commit("SET_ERROR", "Invalid response structure");
      }
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error updating Work Ex:", error);
    }
  },
  async deleteWorkEx({ commit }, id) {
    try {
      const token = Cookies.get("token");
      await axios.delete(`/v1/admin/work-experience/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      commit("DELETE_WORK_EX", id); // Cập nhật state
      commit("CLEAR_ERROR"); // Xóa lỗi nếu thành công
    } catch (error) {
      commit("SET_ERROR", error.response ? error.response.data : error.message); // Lưu thông tin lỗi
      console.error("Error deleting Work Ex:", error);
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
