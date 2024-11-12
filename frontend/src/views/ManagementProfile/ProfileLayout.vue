<template>
  <div class="mx-auto py-5">
    <h2 class="text-2xl leading-4 tracking-wider mb-4">Profile</h2>
    <form @submit.prevent="updateProfile">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700"
          >Name</label
        >
        <input
          type="text"
          id="name"
          v-model="user.name"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>

      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700"
          >Email</label
        >
        <input
          type="email"
          id="email"
          v-model="user.email"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>

      <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700"
          >Phone Number</label
        >
        <input
          type="tel"
          id="phone"
          v-model="user.phone"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>

      <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700"
          >Address</label
        >
        <input
          type="text"
          id="address"
          v-model="user.address"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700"
          >Password Current</label
        >
        <input
          type="password"
          id="password"
          v-model="user.password"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>
      <div class="mb-4">
        <label
          for="confirmpassword"
          class="block text-sm font-medium text-gray-700"
          >Confirmation Password</label
        >
        <input
          type="password"
          id="confirmpassword"
          v-model="user.password_confirmation"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>

      <BaseButton
        type="submit"
        class="w-full py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-500 transition duration-300"
      >
        Save
      </BaseButton>
      <div v-if="error" class="text-red-500 mt-4">{{ error }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, getCurrentInstance } from "vue";
import { useStore } from "vuex";
import BaseButton from "@/components/BaseButton.vue";

const store = useStore();
const user = ref({
  name: "",
  email: "",
  phone: "",
  address: "",
  password: "",
  password_confirmation: "",
});

const error = ref(null);
const instance = getCurrentInstance();
const Toast = instance.appContext.config.globalProperties.$toast;

const validatePasswords = () => {
  const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@]).{8,}$/;

  if (user.value.password && !passwordPattern.test(user.value.password)) {
    error.value =
      "Password must start with a capital letter, contain a number, and include '@'.";
    return false;
  }

  if (
    user.value.password &&
    user.value.password !== user.value.password_confirmation
  ) {
    error.value = "Passwords do not match.";
    return false;
  }
  return true;
};

const fetchInfo = async () => {
  try {
    await store.dispatch("profile/fetchInfo");
    user.value = store.getters["profile/info"];
  } catch (err) {
    console.error("Error fetching info:", err);
    error.value = "Failed to load information.";
    Toast.error(error.value); // Use toast from props
  }
};

const updateProfile = async () => {
  if (!validatePasswords()) return;

  try {
    await store.dispatch("profile/updateInfo", user.value);
    Toast.success("Profile updated successfully.");
    error.value = null; // Clear any existing errors on success
  } catch (err) {
    console.error("Error updating profile:", err);
    error.value = "Failed to update profile.";
    Toast.error(error.value);
  }
};

// Gọi fetchUser khi component được tạo
onMounted(fetchInfo);
</script>

<style scoped></style>
