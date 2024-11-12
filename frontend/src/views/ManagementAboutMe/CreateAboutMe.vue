<!-- src/views/CreateNew.vue -->
<template>
  <div class="container">
    <div class="flex items-center justify-between py-5">
      <h1 class="text-2xl font-semibold mb-4">Create New About Me</h1>
      <router-link
        to="/admin/about-me"
        class="text-base px-2 py-1 lg:mr-6 bg-cyan-400 text-white transition-all duration-300 hover:bg-cyan-500 cursor-pointer rounded-md"
      >
        Back to List
      </router-link>
    </div>
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div>
        <label for="title" class="block text-sm font-medium text-gray-700"
          >Title</label
        >
        <input
          v-model="aboutMe.title"
          type="text"
          id="title"
          required
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
        />
      </div>
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700"
          >Description</label
        >
        <textarea
          v-model="aboutMe.description"
          id="description"
          rows="4"
          class="mt-1 block w-full border hover:border-cyan-300 border-gray-300 rounded-md p-2"
        ></textarea>
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
const aboutMe = ref({ title: "", description: "" });

function handleSubmit() {
  store.dispatch("about-me/createAboutMe", aboutMe.value).then(() => {
    Toast.success("Created successfully!");
    setTimeout(() => {
      router.push("/admin/about-me"); // Clear the form after successful creation
    }, 3000);
  });
}
</script>

<style scoped>
/* Add your styles here */
</style>
