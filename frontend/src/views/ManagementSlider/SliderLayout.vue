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
          v-if="slider.imagePreview"
          class="max-w-32 mt-2"
          :src="slider.imagePreview"
          alt="Selected Image"
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

    // Render the file (image) preview if it's an image
    if (field === "image" && file.type.startsWith("image/")) {
      renderFile(file);
    }
  }
};
const renderFile = (file) => {
  const reader = new FileReader();
  reader.onloadend = () => {
    slider.value.imagePreview = reader.result; // Set image preview
  };
  reader.readAsDataURL(file); // Read file as Data URL
};

const handleSubmit = async () => {
  const formData = new FormData();
  const fields = ["id", "name", "position", "description", "url_cv", "image"];

  // Append ID only once
  formData.append("id", 1); // Assuming you're always updating ID 1

  // Helper function to handle file appending
  const handleFileUpload = (field, allowedTypes) => {
    if (slider.value[field] && slider.value[field] instanceof Blob) {
      const file = slider.value[field];
      const fileName = file.name; // Get original file name
      const fileExtension = file.type.split("/").pop(); // Get file extension

      // Check if the file type is valid
      if (allowedTypes.includes(fileExtension)) {
        formData.append(field, file, fileName); // Append the file with its original name
      } else {
        console.warn(`${field} must be a valid file type:`, file);
      }
    }
  };

  // Loop over each field
  fields.forEach((field) => {
    if (field === "url_cv") {
      // Handle PDF upload
      handleFileUpload(field, ["pdf"]);
    } else if (field === "image") {
      // Handle image upload
      handleFileUpload(field, ["jpeg", "png", "jpg", "gif"]);
    } else if (field === "id") {
      // Skip ID field as it is already appended
      return;
    } else {
      // Append other fields directly
      if (slider.value[field]) {
        formData.append(field, slider.value[field]);
      }
    }
  });

  try {
    // Dispatch the form data to the store action for updating slider
    await store.dispatch("slider/updateInfo", {
      id: 1, // Always update ID 1
      formData,
    });

    Toast.success("Slider updated successfully!");
  } catch (err) {
    // Handle error
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
