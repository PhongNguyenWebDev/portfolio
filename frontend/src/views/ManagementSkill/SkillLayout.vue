<template>
  <div>
    <div class="flex items-center justify-between py-5">
      <h2 class="text-2xl leading-4 tracking-wider">Skill List</h2>
      <router-link
        to="/admin/skill/create"
        class="text-base px-2 py-1 bg-cyan-400 text-white transition-all duration-300 hover:bg-cyan-500 cursor-pointer rounded-md"
      >
        Create New
      </router-link>
    </div>

    <table class="min-w-full">
      <thead>
        <tr>
          <th
            class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Title
          </th>
          <th
            class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Proficiency (%)
          </th>
          <th
            class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Level
          </th>
          <th
            class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Actions
          </th>
        </tr>
      </thead>

      <tbody class="bg-white">
        <tr v-for="item in skills" :key="item.id">
          <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">
              {{ item.title }}
            </div>
          </td>
          <td class="px-6 py-4 border-b border-gray-200">
            <div class="text-sm text-gray-900">{{ item.process }}%</div>
          </td>
          <td class="px-6 py-4 border-b border-gray-200">
            <div class="text-sm text-gray-900">{{ item.level }}</div>
          </td>
          <td
            class="px-6 py-4 border-b border-gray-200 whitespace-nowrap text-right space-x-2"
          >
            <BaseButton color="teal" @click="handleEdit(item.id)"
              >Edit</BaseButton
            >
            <BaseButton color="red" @click="confirmDelete(item.id)"
              >Delete</BaseButton
            >
          </td>
        </tr>
      </tbody>
    </table>

    <div v-if="error" class="py-4 text-center text-red-500">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref, onMounted, getCurrentInstance } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import BaseButton from "@/components/BaseButton.vue";

const instance = getCurrentInstance();
const Toast = instance.appContext.config.globalProperties.$toast;
const store = useStore();
const router = useRouter();

const skills = ref([]);
const error = ref(null);

const fetchSkills = async () => {
  error.value = null;
  try {
    await store.dispatch("skill/fetchInfo");
    skills.value = store.getters["skill/info"];
  } catch (err) {
    console.error("Error fetching skills:", err);
    error.value = "Failed to load skills.";
    Toast.error(error.value);
  }
};

const handleEdit = (id) => {
  router.push({ name: "EditSkill", params: { id } });
};

const confirmDelete = (id) => {
  if (confirm("Are you sure you want to delete this skill?")) {
    handleDelete(id);
  }
};

const handleDelete = async (id) => {
  try {
    await store.dispatch("skill/deleteInfo", id);
    await fetchSkills(); // Refresh list after deletion
    Toast.success("Skill deleted successfully.");
  } catch (err) {
    console.error("Error deleting skill:", err);
    error.value = "Failed to delete skill.";
    Toast.error(error.value);
  }
};

onMounted(fetchSkills);
</script>

<style scoped>
/* Custom styles if needed */
</style>
