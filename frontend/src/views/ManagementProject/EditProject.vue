<template>
  <div class="container mx-auto py-5">
    <h2 class="text-2xl font-semibold leading-4 tracking-wider mb-4">
      Edit Project
    </h2>
    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700"
          >Title</label
        >
        <input
          v-model="project.title"
          type="text"
          id="title"
          maxlength="200"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        />
      </div>

      <div class="mb-4">
        <label
          for="image_project"
          class="block text-sm font-medium text-gray-700"
          >Project Image</label
        >
        <input
          type="file"
          id="image_project"
          @change="handleFileChange('image_project', $event)"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>

      <div class="mb-4" v-if="project.image_project">
        <img
          :src="getImageUrl(project.image_project)"
          alt="Current Project Image"
          class="max-w-32 mt-2"
        />
      </div>

      <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700"
          >Description</label
        >
        <textarea
          v-model="project.description"
          id="description"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          rows="3"
          required
        ></textarea>
      </div>

      <div class="mb-4">
        <label for="image_tech" class="block text-sm font-medium text-gray-700"
          >Tech Image</label
        >
        <input
          type="file"
          id="image_tech"
          @change="handleFileChange('image_tech', $event)"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>

      <div class="mb-4" v-if="project.image_tech">
        <img
          :src="getImageUrl(project.image_tech)"
          alt="Current Tech Image"
          class="max-w-32 mt-2"
        />
      </div>

      <div class="mb-4">
        <label for="url" class="block text-sm font-medium text-gray-700"
          >Project URL</label
        >
        <input
          v-model="project.url"
          type="url"
          id="url"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        />
      </div>

      <BaseButton
        type="submit"
        class="w-full py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-500 transition duration-300"
      >
        Save Changes
      </BaseButton>

      <div v-if="error" class="text-red-500 mt-4">{{ error }}</div>
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

const project = ref({
  title: "",
  description: "",
  url: "",
  image_project: null,
  image_tech: null,
});

const error = ref(null);

const fetchProject = async () => {
  try {
    const id = route.params.id;
    const data = await store.dispatch("project/getInfoById", id);
    project.value = {
      ...project.value,
      ...data,
    };
  } catch (err) {
    console.error("Error fetching project data:", err);
    error.value = "Unable to fetch project data.";
  }
};

const getImageUrl = (imagePath) => {
  // URL cơ bản cho hình ảnh
  const baseUrl = "http://localhost:8000/storage/";
  return baseUrl + imagePath; // Nối đường dẫn cơ bản với đường dẫn hình ảnh từ DB
};

const handleFileChange = (field, event) => {
  const file = event.target.files[0];
  if (file) {
    project.value[field] = file;
  }
};
const handleSubmit = async () => {
  const formData = new FormData();
  // Thêm các trường thông tin vào formData
  const fields = [
    "id",
    "title",
    "description",
    "url",
    "image_project",
    "image_tech",
  ];

  fields.forEach((field) => {
    if (field === "id") {
      formData.append(field, route.params.id); // Lấy id từ params
    } else if (field !== "image_project" && field !== "image_tech") {
      formData.append(field, project.value[field]);
    } else {
      if (project.value[field] && project.value[field] instanceof Blob) {
        formData.append(field, project.value[field], `${field}.png`);
      } else {
        console.warn(`${field} is not valid:`, project.value[field]);
      }
    }
  });

  try {
    await store.dispatch("project/updateInfo", {
      id: route.params.id,
      formData,
    });

    Toast.success("Icon updated successfully!");
    setTimeout(() => {
      router.push("/admin/project"); // Redirect after delay
    }, 4000);
  } catch (error) {
    error.value = "An error occurred while updating the project.";
  }
};

onMounted(fetchProject);
</script>

<style scoped>
/* Add any custom styles for this component if needed */
</style>
