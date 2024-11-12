<template>
  <div class="container mx-auto py-5">
    <h2 class="text-2xl leading-4 tracking-wider mb-4">Edit Work Experience</h2>
    <form @submit.prevent="handleSubmit">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Company</label>
        <input
          v-model="workExperience.title"
          type="text"
          maxlength="150"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700"
          >Start Date</label
        >
        <input
          v-model="workExperience.start_date"
          type="date"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">End Date</label>
        <input
          v-model="workExperience.end_date"
          type="date"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Position</label>
        <input
          v-model="workExperience.position"
          type="text"
          maxlength="100"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
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
      <BaseButton
        class="w-full py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-500 transition duration-300"
        type="submit"
        color="teal"
      >
        Save Changes
      </BaseButton>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, getCurrentInstance } from "vue";
import { useStore } from "vuex";
import { useRoute, useRouter } from "vue-router";
import BaseButton from "@/components/BaseButton.vue";

const instance = getCurrentInstance();
const Toast = instance.appContext.config.globalProperties.$toast;

const store = useStore();
const route = useRoute();
const router = useRouter();

const workExperience = ref({});

const fetchWorkExperience = async () => {
  const id = route.params.id;
  const info = await store.dispatch("work-ex/getWorkExById", id);
  if (info) {
    workExperience.value = { ...info };
  } else {
    Toast.error("Failed to load work experience data");
  }
};

const handleSubmit = async () => {
  try {
    await store.dispatch("work-ex/updateWorkEx", {
      id: route.params.id,
      ...workExperience.value,
    });
    Toast.success("Work Experience updated successfully!"); // Show success toast
    setTimeout(() => {
      router.push("/admin/about-me"); // Redirect after delay
    }, 4000);
  } catch (error) {
    console.error("Error updating Work Experience:", error);
    Toast.error("Failed to update Work Experience."); // Show error toast
  }
};

onMounted(fetchWorkExperience);
</script>

<style scoped>
/* Add your custom styles here */
</style>
