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

      <div class="mb-4" v-if="project.imagePreview">
        <img
          :src="project.imagePreview"
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
          >Tech Images</label
        >
        <input
          type="file"
          id="image_tech"
          @change="handleFileChange('image_tech', $event)"
          multiple
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
        <div
          v-if="project.image_techPreviews.length > 0"
          class="mt-2 flex overflow-x-auto space-x-2"
        >
          <div
            v-for="(preview, index) in project.image_techPreviews"
            :key="index"
            class="w-32"
          >
            <img
              :src="preview"
              alt="Tech Image Preview"
              class="w-28 h-20 object-cover rounded-md"
            />
          </div>
        </div>
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
  imagePreview: null,
  image_tech: [],
  image_techPreviews: [],
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

    // Set preview images
    if (data.image_project) {
      project.value.imagePreview = data.image_project;
    }
    if (Array.isArray(data.image_tech)) {
      project.value.image_techPreviews = data.image_tech;
    }
  } catch (err) {
    console.error("Error fetching project data:", err);
    error.value = "Unable to fetch project data.";
  }
};

const getImageUrl = (imagePath) => {
  const baseUrl = "http://localhost:8000";
  return baseUrl + imagePath;
};

const handleFileChange = (field, event) => {
  const files = event.target.files;
  if (files) {
    if (field === "image_tech") {
      project.value.image_tech = Array.from(files);
      project.value.image_techPreviews = [];

      Array.from(files).forEach((file) => {
        renderFile(file, "tech");
      });
    } else if (field === "image_project") {
      project.value.image_project = files[0];
      renderFile(files[0], "project");
    }
  }
};

const renderFile = (file, type) => {
  const reader = new FileReader();
  reader.onloadend = () => {
    if (type === "tech") {
      project.value.image_techPreviews.push(reader.result);
    } else if (type === "project") {
      project.value.imagePreview = reader.result;
    }
  };
  reader.readAsDataURL(file);
};

const handleSubmit = async () => {
  const formData = new FormData();
  formData.append("title", project.value.title);
  formData.append("description", project.value.description);
  formData.append("url", project.value.url);

  // Chỉ thêm `image_project` nếu người dùng thay đổi
  if (project.value.image_project instanceof File) {
    formData.append("image_project", project.value.image_project);
  }

  // Chỉ thêm `image_tech` nếu có sự thay đổi từ người dùng
  if (project.value.image_tech.length > 0) {
    const hasNewTechImages = project.value.image_tech.some(
      (file) => file instanceof File
    );
    if (hasNewTechImages) {
      project.value.image_tech.forEach((file) => {
        if (file instanceof File) {
          formData.append("image_tech[]", file);
        }
      });
    }
  }

  try {
    // Sử dụng PATCH thay vì POST
    await store.dispatch("project/updateInfo", {
      id: route.params.id,
      formData,
    });

    Toast.success("Project updated successfully!");
    setTimeout(() => {
      router.push("/admin/project");
    }, 2000);
  } catch (err) {
    Toast.error("Unable to update project. Please try again.");
    error.value = "An error occurred while updating the project.";
    console.error("Error updating project:", err);
  }
};

onMounted(fetchProject);
</script>

<style scoped>
/* Add any custom styles for this component if needed */
</style>
