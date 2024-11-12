<template>
  <div class="container max-w-2xl mx-auto p-6">
    <div class="flex items-center justify-between py-5">
      <h1 class="text-2xl font-semibold">Create New Icon</h1>
      <router-link
        to="/admin/icon"
        class="text-base px-4 py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-500 transition-all duration-300"
      >
        Back to List
      </router-link>
    </div>
    <form
      @submit.prevent="handleSubmit"
      class="space-y-6 bg-white p-6 rounded-lg shadow-md"
    >
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700"
          >Icon Name</label
        >
        <input
          v-model="icon.name"
          type="text"
          id="name"
          placeholder="Enter icon name"
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
        />
      </div>
      <div>
        <label for="url" class="block text-sm font-medium text-gray-700"
          >URL</label
        >
        <input
          v-model="icon.url"
          type="url"
          id="url"
          placeholder="Enter URL"
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
        />
      </div>
      <div>
        <label for="class_name" class="block text-sm font-medium text-gray-700"
          >CSS Class Name</label
        >
        <input
          v-model="icon.class_name"
          type="text"
          id="class_name"
          placeholder="Enter CSS class name"
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
        />
      </div>
      <button
        type="submit"
        class="w-full py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-500 transition duration-300"
      >
        Create
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, getCurrentInstance } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const instance = getCurrentInstance();
const Toast = instance.appContext.config.globalProperties.$toast;
const store = useStore();
const router = useRouter();
const icon = ref({
  name: "",
  url: "",
  class_name: "",
});

function handleSubmit() {
  store
    .dispatch("icon/createInfo", icon.value)
    .then(() => {
      Toast.success("Icon created successfully!");
      router.push("/admin/icon");
    })
    .catch((error) => {
      Toast.error("Failed to create icon. Please try again.");
      console.error("Error creating icon:", error);
    });
}
</script>

<style scoped>
/* Add custom styles here */
</style>
