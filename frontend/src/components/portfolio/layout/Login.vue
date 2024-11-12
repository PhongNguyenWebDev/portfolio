<template>
  <div
    v-if="isVisible"
    class="fixed inset-0 mx-auto md:h-screen flex items-center justify-center lg:bg-black lg:bg-opacity-50"
  >
    <div
      class="bg-white lg:w-[30%] w-[100%] lg:translate-x-0 translate-x-20 h-auto p-6 rounded-lg ring-1 ring-cyan-500 shadow-md relative pb-16 dark:bg-gray-800"
    >
      <a
        href="javascript:void(0)"
        class="flex items-center mb-6 justify-center text-2xl font-semibold text-gray-900 dark:text-white"
      >
        <img
          class="object-cover w-[50%]"
          src="@/assets/img/logo.png"
          alt="logo"
        />
      </a>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label
            for="email"
            class="block text-base text-gray-700 dark:text-white"
            >Email</label
          >
          <input
            type="email"
            v-model="email"
            required
            class="mt-1 block w-full px-3 py-3 text-sm bg-white border dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500"
          />
        </div>
        <div class="mb-4">
          <label
            for="password"
            class="block text-base text-gray-700 dark:text-white"
            >Password</label
          >
          <input
            type="password"
            v-model="password"
            required
            class="mt-1 block w-full px-3 py-3 text-sm bg-white border dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500"
          />
        </div>
        <div class="text-end w-full pb-3">
          <a
            href="javascript:void(0)"
            class="dark:text-cyan-400 block hover:underline hover:underline-offset-1 text-lg text-gray-600 hover:text-gray-800"
            @click="showForgotPassword = true"
            >Forgot Password?</a
          >
        </div>
        <button
          type="submit"
          :disabled="isLoading"
          class="bg-cyan-400 hover:bg-cyan-500 text-white rounded-md p-2 w-full"
        >
          <span v-if="isLoading">Loading...</span>
          <span v-else>Login</span>
        </button>
        <p v-if="errorMessage" class="text-red-500">{{ errorMessage }}</p>
      </form>

      <!-- ButtonClose component used here -->
      <div class="absolute top-0 right-0 -translate-x-3">
        <ButtonClose @close="closePopup" />
      </div>
    </div>

    <!-- Forgot Password Popup -->
    <ForgotPasswordPopup
      v-if="showForgotPassword"
      :isVisible="showForgotPassword"
      @close="showForgotPassword = false"
    />
  </div>
</template>

<script>
import axios from "@/axios/axios.js";
import ForgotPasswordPopup from "@/views/auth/ForgotPassword.vue";
import ButtonClose from "@/components/portfolio/ButtonClose.vue"; // Import the ButtonClose component

export default {
  components: { ForgotPasswordPopup, ButtonClose }, // Register the ButtonClose component
  name: "Login",
  data() {
    return {
      showForgotPassword: false,
      email: "",
      name: "",
      password: "",
      errorMessage: "",
      isVisible: true,
      isLoading: false,
      access_token: "",
    };
  },
  methods: {
    showForgotPasswordPopup() {
      this.isForgotPasswordPopupVisible = true;
    },
    closeForgotPasswordPopup() {
      this.isForgotPasswordPopupVisible = false;
    },
    async handleLogin() {
      this.isLoading = true;
      this.errorMessage = "";

      try {
        // Lấy CSRF cookie
        await axios.get("../sanctum/csrf-cookie");

        // Gửi yêu cầu đăng nhập với email và mật khẩu
        const response = await axios.post(
          "/v1/auth/login",
          {
            email: this.email,
            password: this.password,
          },
          { withCredentials: true }
        );

        // Xóa thông tin sau khi nhận phản hồi
        this.email = "";
        this.password = "";

        // Sử dụng store để lưu thông tin user và token
        this.$store.dispatch("auth/login", {
          name: response.data.user.name,
          email: response.data.user.email,
          token: response.data.access_token,
        });

        // Chuyển hướng đến dashboard
        this.$router.push("/admin/profile");

        // Đóng popup đăng nhập
        this.closePopup();
      } catch (error) {
        // Xử lý lỗi
        if (error.response) {
          this.errorMessage = error.response.data.error || "Sai mật khẩu!";
        } else {
          this.errorMessage = "Đăng nhập không thành công!";
        }
      } finally {
        this.isLoading = false;
      }
    },

    closePopup() {
      this.isVisible = false;
      this.$emit("close");
    },
  },
};
</script>

<style scoped>
/* Add any additional styles here */
.size-6 {
  width: 24px;
  height: 24px;
}
</style>
