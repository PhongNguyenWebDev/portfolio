<template>
  <div class="mx-auto py-5">
    <h2 class="text-2xl leading-4 tracking-wider mb-4">
      Change slider information
    </h2>
    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700"
          >Name:</label
        >
        <input
          v-model="slider.name"
          type="text"
          id="name"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>

      <div class="mb-4">
        <label for="position" class="block text-sm font-medium text-gray-700"
          >Position:</label
        >
        <input
          v-model="slider.position"
          type="text"
          id="position"
          required
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>

      <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700"
          >Description:</label
        >
        <ckeditor
          :editor="editor"
          v-model="slider.description"
          :config="editorConfig"
        ></ckeditor>
      </div>

      <div class="mb-4">
        <label for="url_cv" class="block text-sm font-medium text-gray-700"
          >Upload CV (PDF):</label
        >
        <input
          type="file"
          @change="handleFileChange('url_cv', $event)"
          id="url_cv"
          accept=".pdf"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>

      <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-700"
          >Upload Image:</label
        >
        <input
          type="file"
          @change="handleFileChange('image', $event)"
          id="image"
          accept="image/*"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
        <img
          class="max-w-32 mt-2"
          :src="getImageUrl(slider.image)"
          alt="Error Image"
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const editor = ClassicEditor;
const editorConfig = ref({
  toolbar: {
    items: [
      "undo",
      "redo",
      "|",
      "heading",
      "|",
      "bold",
      "italic",
      "|",
      "link",
      "uploadImage",
      "blockQuote",

      "|",
      "bulletedList",
      "numberedList",

      "outdent",
      "indent",
    ],
    shouldNotGroupWhenFull: false,
  },
});

const instance = getCurrentInstance();
const Toast = instance.appContext.config.globalProperties.$toast;
const store = useStore();

const slider = ref({
  name: "",
  position: "",
  description: "",
  url_cv: null,
  image: null,
});

const error = ref(null);

const fetchInfo = async () => {
  try {
    const data = await store.dispatch("slider/getInfoById", 1);
    slider.value = {
      ...data,
    };
  } catch (err) {
    console.error("Error fetching slider data:", err);
    error.value = "Unable to fetch slider data.";
  }
};

const handleFileChange = (field, event) => {
  const file = event.target.files[0];
  if (file) {
    slider.value[field] = file;
  }
};
const getImageUrl = (imagePath) => {
  // URL cơ bản cho hình ảnh
  const baseUrl = "http://localhost:8000/storage/";
  return baseUrl + imagePath; // Nối đường dẫn cơ bản với đường dẫn hình ảnh từ DB
};

const handleSubmit = async () => {
  const formData = new FormData();
  const fields = ["id", "name", "position", "description", "url_cv", "image"];

  // Always append ID 1 to formData
  formData.append("id", 1); // Assuming you're always updating ID 1

  fields.forEach((field) => {
    if (field === "id") {
      formData.append(field, 1); // Always append ID
    } else if (field === "url_cv") {
      // Handle file upload for 'url_cv'
      if (slider.value[field] && slider.value[field] instanceof Blob) {
        // Append the CV file (PDF)
        const fileExtension = slider.value[field].type.split("/").pop();
        if (["pdf"].includes(fileExtension)) {
          // Check if it is a PDF
          formData.append(
            field,
            slider.value[field],
            `${field}.${fileExtension}`
          );
        } else {
          console.warn(`${field} must be a PDF file:`, slider.value[field]);
        }
      }
    } else if (field === "image") {
      // Handle image upload
      if (slider.value[field] && slider.value[field] instanceof Blob) {
        const imageExtension = slider.value[field].type.split("/").pop();
        if (["jpeg", "png", "jpg", "gif"].includes(imageExtension)) {
          // Check for valid image types
          formData.append(
            field,
            slider.value[field],
            `${field}.${imageExtension}`
          );
        } else {
          console.warn(
            `${field} must be an image file (jpeg, png, jpg, gif):`,
            slider.value[field]
          );
        }
      } else {
        console.warn(`${field} is required and must be an image file.`);
      }
    } else {
      // Append other fields directly
      formData.append(field, slider.value[field]);
    }
  });

  try {
    await store.dispatch("slider/updateInfo", {
      id: 1, // Always update ID 1
      formData,
    });
    Toast.success("Slider updated successfully!");
  } catch (err) {
    Toast.error(
      "Unable to update slider. Please make sure all fields are filled correctly and try again."
    );
    console.error("Error updating slider:", err);
    error.value = "An error occurred while updating the slider.";
  }
};

onMounted(fetchInfo);
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: auto;
}
.error {
  color: red;
}
</style>
