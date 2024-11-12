<template>
  <div class="container mx-auto py-5">
    <h2 class="text-2xl leading-4 tracking-wider mb-4">Edit Skill</h2>
    <form @submit.prevent="handleSubmit">
      <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700"
          >Skill Title</label
        >
        <input
          v-model="skill.title"
          type="text"
          id="title"
          maxlength="150"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="process" class="block text-sm font-medium text-gray-700"
          >Proficiency (0-100)</label
        >
        <input
          v-model="skill.process"
          type="number"
          id="process"
          min="0"
          max="100"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="level" class="block text-sm font-medium text-gray-700"
          >Skill Level</label
        >
        <select
          v-model="skill.level"
          id="level"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        >
          <option value="basic">Basic</option>
          <option value="medium">Medium</option>
          <option value="advanced">Advanced</option>
        </select>
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

const skill = ref({});

const fetchSkill = async () => {
  const id = route.params.id;
  const info = await store.dispatch("skill/getInfoById", id);
  if (info) {
    skill.value = { ...info };
  } else {
    Toast.error("Failed to load skill data");
  }
};

const handleSubmit = async () => {
  try {
    await store.dispatch("skill/updateInfo", {
      id: route.params.id,
      ...skill.value,
    });
    Toast.success("Skill updated successfully!");
    setTimeout(() => {
      router.push("/admin/skill"); // Redirect after delay
    }, 4000);
  } catch (error) {
    console.error("Error updating Skill:", error);
    Toast.error("Failed to update Skill.");
  }
};

onMounted(fetchSkill);
</script>

<style scoped>
/* Add your custom styles here */
</style>
