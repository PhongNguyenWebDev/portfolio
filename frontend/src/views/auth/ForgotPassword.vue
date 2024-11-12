<template>
  <section v-if="isVisible" class="w-[30%] z-20 absolute h-screen">
    <div
      class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
    >
      <div
        class="w-full shadow-2xl p-6 bg-slate-100 rounded-lg dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8"
      >
        <h2
          class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
        >
          Reset Password
        </h2>
        <p class="text-sm py-2 m-0 text-slate-700">
          Enter your email address to receive a password reset link
        </p>
        <form class="space-y-4 md:space-y-5 w-full" @submit.prevent="sendMail">
          <div>
            <label
              for="email"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
              >Email</label
            >
            <input
              type="email"
              v-model="email"
              name="email"
              id="email"
              placeholder="phong302.work@gmail.com..."
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              required
            />
          </div>
          <div class="w-full text-center">
            <button
              type="submit"
              class="p-2 text-sm border rounded bg-cyan-400 hover:bg-cyan-500 cursor-pointer"
            >
              Send Password Reset Link
            </button>
          </div>
        </form>

        <!-- Close button -->
        <div class="absolute top-[33%] right-10 translate-x-3">
          <ButtonClose @close="closePopup" />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import ButtonClose from "@/components/portfolio/ButtonClose.vue"; // Import close button component
import axios from "@/axios/axios.js";

export default {
  components: {
    ButtonClose, // Register the component
  },
  props: {
    isVisible: { type: Boolean, default: false }, // Control popup visibility
  },
  data() {
    return {
      email: "", // Bind email directly in data
    };
  },
  methods: {
    async sendMail() {
      try {
        const payload = { email: this.email };
        const response = await axios.post("/v1/auth/forgot-password", payload);

        // Kiểm tra mã trạng thái của phản hồi
        if (response.status === 200) {
          alert("Please check your email!");
          this.$router.push("/"); // Chuyển hướng về trang chính
        } else {
          alert("Email does not exist."); // Thông báo nếu email không tồn tại
        }
      } catch (error) {
        console.error("Error sending reset email:", error);
        alert(
          "An error occurred while sending the email: " +
            error.response?.data?.message || error.message
        );
        // Hiển thị thông báo lỗi cụ thể nếu có
      }
    },
    closePopup() {
      this.$emit("close"); // Emit event to parent to close the popup
    },
  },
};
</script>

<style scoped>
/* Thêm các style tùy chọn của bạn ở đây */
</style>
