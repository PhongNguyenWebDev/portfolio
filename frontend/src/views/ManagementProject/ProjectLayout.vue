<template>
  <div>
    <div class="flex items-center justify-between py-5">
      <h2 class="text-2xl leading-4 tracking-wider">Project List</h2>
      <router-link
        to="/admin/project/create"
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
            Project Image
          </th>
          <th
            class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Tech Image
          </th>
          <th
            class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Description
          </th>
          <th
            class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            URL
          </th>
          <th
            class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Actions
          </th>
        </tr>
      </thead>
      <tbody class="bg-white">
        <tr v-for="project in projects" :key="project.id">
          <td class="px-6 py-4 border-b border-gray-200">
            {{ project.title }}
          </td>
          <td class="px-6 py-4 border-b border-gray-200">
            <img
              :src="project.image_project"
              alt="Project Image"
              class="w-16 h-16 object-cover"
            />
          </td>
          <td class="px-6 py-4 border-b border-gray-200">
            <div class="flex space-x-2 overflow-x-auto">
              <!-- Iterate through the tech images and display each one -->
              <img
                v-for="(techImage, index) in project.image_tech"
                :key="index"
                :src="techImage"
                alt="Tech Image"
                class="w-16 h-16 object-cover"
              />
            </div>
          </td>
          <td class="px-6 py-4 border-b border-gray-200">
            {{ project.description }}
          </td>
          <td class="px-6 py-4 border-b border-gray-200">
            <a
              :href="project.url"
              target="_blank"
              class="text-cyan-600 hover:underline"
              >{{ project.url }}</a
            >
          </td>
          <td class="px-6 py-4 border-b border-gray-200 text-right space-x-2">
            <BaseButton color="teal" @click="handleEdit(project.id)">
              Edit
            </BaseButton>
            <BaseButton color="red" @click="confirmDelete(project.id)">
              Delete
            </BaseButton>
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

const projects = ref([]);
const error = ref(null);

const fetchProjects = async () => {
  error.value = null;
  try {
    await store.dispatch("project/fetchInfo");
    projects.value = store.getters["project/info"];
  } catch (err) {
    console.error("Error fetching projects:", err);
    error.value = "Failed to load projects.";
    Toast.error(error.value);
  }
};

// Cập nhật hàm getImageUrl để phù hợp với đường dẫn hình ảnh
const getImageUrl = (imagePath) => {
  const baseUrl = "http://localhost:8000"; // URL cơ bản cho hình ảnh
  return baseUrl + imagePath; // Nối đường dẫn cơ bản với đường dẫn hình ảnh từ DB
};

const handleEdit = (id) => {
  router.push({ name: "EditProject", params: { id } });
};

const confirmDelete = (id) => {
  if (confirm("Are you sure you want to delete this project?")) {
    handleDelete(id);
  }
};

const handleDelete = async (id) => {
  try {
    await store.dispatch("project/deleteInfo", id);
    await fetchProjects();
    Toast.success("Project deleted successfully.");
  } catch (err) {
    console.error("Error deleting project:", err);
    error.value = "Failed to delete project.";
    Toast.error(error.value);
  }
};

onMounted(fetchProjects);
</script>

<style scoped>
/* Add custom styles here if needed */
</style>
