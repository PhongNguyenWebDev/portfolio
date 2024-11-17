<template>
  <div class="container max-w-2xl mx-auto p-6">
    <div class="flex items-center justify-between py-5">
      <h1 class="text-2xl font-semibold">Create New Skill</h1>
      <router-link
        to="/admin/skill"
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
        <label for="title" class="block text-sm font-medium text-gray-700"
          >Skill Title</label
        >
        <input
          v-model="skill.title"
          type="text"
          id="title"
          placeholder="Enter skill title"
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
          maxlength="150"
        />
      </div>
      <div>
        <label for="process" class="block text-sm font-medium text-gray-700"
          >Proficiency (0-100)</label
        >
        <input
          v-model="skill.process"
          type="number"
          id="process"
          placeholder="Enter proficiency level"
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
          min="0"
          max="100"
        />
      </div>
      <div>
        <label for="level" class="block text-sm font-medium text-gray-700"
          >Skill Level</label
        >
        <select
          v-model="skill.level"
          id="level"
          class="mt-1 block w-full border border-gray-300 hover:border-cyan-300 rounded-md p-2"
        >
          <option value="basic">Basic</option>
          <option value="medium">Medium</option>
          <option value="advanced">Advanced</option>
        </select>
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
const skill = ref({
  title: "",
  process: 0,
  level: "basic",
});

function handleSubmit() {
  store
    .dispatch("skill/createSkill", skill.value)
    .then(() => {
      Toast.success("Skill created successfully!");
      router.push("/admin/skill");
    })
    .catch((error) => {
      Toast.error("Failed to create skill. Please try again.");
      console.error("Error creating skill:", error);
    });
}
</script>

<style scoped>
/* Add custom styles here */
</style>
