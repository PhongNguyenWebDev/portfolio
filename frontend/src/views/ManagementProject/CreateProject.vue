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
          >Tech Image</label
        >
        <input
          type="file"
          id="image_tech"
          @change="handleFileChange('image_tech', $event)"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
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
        />
      </div>

      <BaseButton
        class="w-full py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-500 transition duration-300"
        type="submit"
      >
        Create Project
      </BaseButton>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import BaseButton from "@/components/BaseButton.vue";

const store = useStore();
const router = useRouter();

const project = ref({
  title: "",
  image_project: null,
  description: "",
  image_tech: null,
  url: "",
});

const handleFileChange = (field, event) => {
  const file = event.target.files[0];
  if (file) {
    project.value[field] = file; // Gán file vào dự án
  }
};

const handleSubmit = async () => {
  const formData = new FormData();
  for (const key in project.value) {
    formData.append(key, project.value[key]);
  }

  try {
    await store.dispatch("project/createInfo", formData);
    router.push("/admin/project");
  } catch (error) {
    console.error("Error creating project:", error);
  }
};
</script>
