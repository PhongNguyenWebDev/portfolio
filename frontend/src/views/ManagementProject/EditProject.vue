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
  image_techPreviews: [],
  imagePreview: null,
  image_tech: [],
});

const error = ref(null);
const fetchProject = async () => {
  try {
    const id = route.params.id;
    const data = await store.dispatch("project/getInfoById", id);
    console.log("Fetched project data:", data); // Kiểm tra dữ liệu

    project.value = {
      ...project.value,
      ...data,
    };

    // Nếu image_tech là null, khởi tạo mảng rỗng
    if (!project.value.image_tech) {
      project.value.image_tech = [];
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

// Helper function for handling file rendering
const renderFile = (files) => {
  return Array.from(files).map((file) => URL.createObjectURL(file));
};

const handleFileChange = (field, event) => {
  if (event.target.files.length > 0) {
    const files = event.target.files;
    if (field === "image_project") {
      project.value.imagePreview = renderFile(files)[0];
    } else if (field === "image_tech") {
      project.value.image_techPreviews = renderFile(files);
      // Quyết định xem image có được thêm vào ko
      project.value.image_tech = Array.from(files);
    }
  }
};

const handleSubmit = async () => {
  const formData = new FormData();
  const fields = [
    "id",
    "title",
    "description",
    "url",
    "image_project",
    "image_tech",
  ];

  // Append ID only once
  formData.append("id", route.params.id);

  // Helper function to handle file appending
  const handleFileUpload = (field, allowedTypes) => {
    if (project.value[field] && project.value[field] instanceof Blob) {
      const file = project.value[field];
      const fileName = file.name;
      const fileExtension = file.type ? file.type.split("/").pop() : "";
      if (allowedTypes.includes(fileExtension)) {
        formData.append(field, file, fileName);
      } else {
        console.warn(`${field} must be a valid file type:`, file);
      }
    } else if (Array.isArray(project.value[field])) {
      project.value[field].forEach((file) => {
        if (file instanceof Blob) {
          const fileExtension = file.type ? file.type.split("/").pop() : "";
          if (allowedTypes.includes(fileExtension)) {
            formData.append(field + "[]", file, file.name);
          } else {
            console.warn(`${field} must be a valid file type:`, file);
          }
        }
      });
    }
  };

  fields.forEach((field) => {
    if (field === "image_project") {
      handleFileUpload(field, ["jpeg", "png", "jpg", "gif"]);
    } else if (field === "image_tech") {
      handleFileUpload(field, ["jpeg", "png", "jpg", "gif"]);
    } else {
      if (project.value[field]) {
        formData.append(field, project.value[field]);
      }
    }
  });

  try {
    await store.dispatch("project/updateInfo", {
      id: route.params.id,
      formData,
    });
    Toast.success("Project updated successfully!");
    setTimeout(() => {
      router.push("/admin/project");
    }, 4000);
  } catch (err) {
    Toast.error("Unable to update project. Please try again.");
    console.error("Error updating project:", err);
    error.value = "An error occurred while updating the project.";
  }
};

onMounted(fetchProject);
</script>

<style scoped>
/* Add any custom styles for this component if needed */
</style>
