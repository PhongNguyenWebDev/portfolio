<template>
  <div class="container">
    <div class="flex items-center justify-between py-5">
      <h1 class="text-2xl font-semibold">Create New Work Experience</h1>
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
          >Company</label
        >
        <input
          v-model="workExperience.title"
          type="text"
          id="title"
          required
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
        />
      </div>
      <div>
        <label for="startDate" class="block text-sm font-medium text-gray-700"
          >Start Date</label
        >
        <input
          v-model="workExperience.start_date"
          type="date"
          placeholder="dd/MM/yyyy"
          id="startDate"
          required
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
        />
      </div>
      <div>
        <label for="endDate" class="block text-sm font-medium text-gray-700"
          >End Date</label
        >
        <input
          v-model="workExperience.end_date"
          type="date"
          placeholder="dd/MM/yyyy"
          id="endDate"
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
        />
      </div>
      <div>
        <label for="position" class="block text-sm font-medium text-gray-700"
          >Position</label
        >
        <input
          v-model="workExperience.position"
          type="text"
          id="position"
          required
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
        />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">GPA</label>
        <input
          v-model="workExperience.gpa"
          type="number"
          step="0.01"
          min="0"
          max="4.00"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">GPA Scale</label>
        <input
          v-model="workExperience.gpa_scale"
          type="number"
          step="0.1"
          min="0"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
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
const workExperience = ref({});

function handleSubmit() {
  store.dispatch("work-ex/createWorkEx", workExperience.value).then(() => {
    Toast.success("Created successfully!");
    setTimeout(() => {
      router.push("/admin/about-me"); // Redirect to the list after successful creation
    }, 3000);
  });
}
</script>

<style scoped>
/* Add your styles here */
</style>
