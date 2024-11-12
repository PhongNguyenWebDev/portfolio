<template>
  <section class="dark:bg-gray-900">
    <div
      class="flex flex-col w-[100%] items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
    >
      <div
        class="w-full p-28 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8"
      >
        <h2
          class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
        >
          Change Password
        </h2>
        <form
          class="mt-4 space-y-4 lg:mt-5 md:space-y-5"
          @submit.prevent="resetPass"
        >
          <div>
            <label
              for="password"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
              >New Password</label
            >
            <input
              type="password"
              v-model="password"
              name="password"
              id="password"
              placeholder="••••••••"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              required=""
            />
          </div>
          <div>
            <label
              for="confirm-password"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
              >Confirm password</label
            >
            <input
              type="password"
              v-model="confirmPassword"
              name="confirm-password"
              id="confirm-password"
              placeholder="••••••••"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              required=""
            />
          </div>
          <button
            type="submit"
            class="w-full bg-cyan-500 hover:bg-cyan-600 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
          >
            Reset Password
          </button>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "@/axios/axios.js";
export default {
  props: {
    token: {
      type: String,
      required: true,
    },
    email: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      password: "",
      confirmPassword: "",
    };
  },
  methods: {
    async resetPass() {
      if (this.password !== this.confirmPassword) {
        alert("Passwords do not match!");
        return;
      }

      try {
        const payload = {
          token: this.token,
          email: this.email,
          password: this.password,
          password_confirmation: this.confirmPassword,
        };

        const response = await axios.post("/v1/auth/reset-password", payload);

        alert("Password reset successful!");
        this.$router.push("/");
        // Redirect hoặc thông báo cho người dùng
      } catch (error) {
        console.error("Error resetting password:", error);
        alert("An error occurred while resetting the password.");
      }
    },
  },
};
</script>

<style>
/* Add your styles here */
</style>
