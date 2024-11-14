<template>
  <div class="mx-auto py-5">
    <h2 class="text-2xl leading-4 tracking-wider mb-4">
      Change General Information
    </h2>
    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="logo" class="block text-sm font-medium text-gray-700">
          Upload Logo:
        </label>
        <input
          type="file"
          @change="handleFileChange('logo', $event)"
          id="logo"
          accept="image/*"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
        <img
          v-if="general.imagePreview"
          class="max-w-32 mt-2"
          :src="general.imagePreview"
          alt="Selected Image"
        />
      </div>

      <div class="mb-4">
        <label for="des_footer" class="block text-sm font-medium text-gray-700">
          Footer Description:
        </label>
        <ckeditor
          :editor="editor"
          v-model="general.des_footer"
          :config="editorConfig"
        ></ckeditor>
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

const general = ref({
  logo: null,
  des_footer: "",
});

const error = ref(null);

const fetchInfo = async () => {
  try {
    const data = await store.dispatch("general/getInfoById", 1);
    general.value = {
      ...data,
    };
  } catch (err) {
    console.error("Error fetching general data:", err);
    error.value = "Unable to fetch general data.";
  }
};

const handleFileChange = (field, event) => {
  const file = event.target.files[0];
  if (file && file.type.startsWith("image/")) {
    // Kiểm tra nếu là tệp hình ảnh
    general.value[field] = file;
    renderFile(file); // Hiển thị ảnh xem trước nếu là tệp ảnh
  } else {
    error.value = "Vui lòng chọn tệp hình ảnh hợp lệ!";
  }
};
const renderFile = (file) => {
  const reader = new FileReader();
  reader.onloadend = () => {
    general.value.imagePreview = reader.result; // Set image preview
  };
  reader.readAsDataURL(file); // Read file as Data URL
};
const handleSubmit = async () => {
  const formData = new FormData();
  formData.append("id", 1);

  if (general.value.logo && general.value.logo instanceof Blob) {
    const logoExtension = general.value.logo.type.split("/").pop();
    if (["jpeg", "png", "jpg", "gif"].includes(logoExtension)) {
      formData.append("logo", general.value.logo, `logo.${logoExtension}`);
    } else {
      console.warn(
        "Logo must be an image file (jpeg, png, jpg, gif):",
        general.value.logo
      );
    }
  }

  formData.append("des_footer", general.value.des_footer);

  try {
    await store.dispatch("general/updateInfo", {
      id: 1,
      formData,
    });
    Toast.success("General information updated successfully!");
  } catch (err) {
    Toast.error("Unable to update general information. Please try again.");
    console.error("Error updating general information:", err);
    error.value = "An error occurred while updating the information.";
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
