<template>
  <div class="container mx-auto py-5">
    <h2 class="text-2xl leading-4 tracking-wider mb-4">Create New Project</h2>
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
        <div v-if="project.imagePreview" class="mt-2">
          <img
            :src="project.imagePreview"
            alt="Project Image Preview"
            class="w-52 h-auto max-w-xs rounded-md"
          />
        </div>
      </div>

      <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700"
          >Description</label
        >
        <textarea
          v-model="project.description"
          id="description"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
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
        />
      </div>

      <BaseButton
        class="w-full py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-500 transition duration-300"
        type="submit"
        :disabled="isSubmitting"
      >
        <span v-if="isSubmitting">Creating...</span>
        <span v-else>Create Project</span>
      </BaseButton>
    </form>
  </div>
</template>

<script setup>
import { ref, getCurrentInstance } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import BaseButton from "@/components/BaseButton.vue";

const instance = getCurrentInstance();
const Toast = instance.appContext.config.globalProperties.$toast;
const store = useStore();
const router = useRouter();

const project = ref({
  title: "",
  image_project: null,
  description: "",
  image_tech: [],
  image_techPreviews: [], // To store previews of tech images
  url: "",
  imagePreview: null, // To store the main image preview URL
});

const isSubmitting = ref(false); // Track form submission status

const handleFileChange = (field, event) => {
  const files = event.target.files;
  if (files) {
    if (field === "image_tech") {
      project.value[field] = Array.from(files); // Save multiple files for tech images
      project.value.image_techPreviews = []; // Reset previews

      // Generate previews for each file
      Array.from(files).forEach((file) => {
        if (file.type.startsWith("image/")) {
          renderFile(file, "tech");
        }
      });
    } else {
      project.value[field] = files[0]; // Only one file for project image
      if (field === "image_project" && files[0].type.startsWith("image/")) {
        renderFile(files[0], "project");
      }
    }
  }
};

// Function to render file preview
const renderFile = (file, type) => {
  const reader = new FileReader();
  reader.onloadend = () => {
    if (type === "tech") {
      project.value.image_techPreviews.push(reader.result); // Store tech image preview
    } else if (type === "project") {
      project.value.imagePreview = reader.result; // Set project image preview
    }
  };
  reader.readAsDataURL(file); // Read file as Data URL
};

const handleSubmit = async () => {
  isSubmitting.value = true; // Show loading state
  const formData = new FormData();

  // Append project data to FormData
  for (const key in project.value) {
    if (Array.isArray(project.value[key])) {
      project.value[key].forEach((file) => formData.append(key + "[]", file)); // For multiple files
    } else {
      formData.append(key, project.value[key]);
    }
  }

  try {
    // Gửi request đến API qua Vuex action
    await store.dispatch("project/createInfo", formData);

    // Hiển thị thông báo thành công
    Toast.success("Project created successfully!");

    // Chờ 1.5 giây trước khi chuyển hướng
    setTimeout(() => {
      router.push("/admin/project");
    }, 1500);
  } catch (error) {
    console.error("Error creating project:", error);

    // Hiển thị thông báo lỗi nếu có vấn đề xảy ra
    Toast.error("Failed to create project. Please try again.");
  } finally {
    // Reset trạng thái isSubmitting
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
/* Optional styling */
</style>
