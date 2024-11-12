<template>
  <div class="container mx-auto py-5">
    <h2 class="text-2xl leading-4 tracking-wider mb-4">Edit Icon</h2>
    <form @submit.prevent="handleSubmit">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700"
          >Icon Name</label
        >
        <input
          v-model="icon.name"
          type="text"
          id="name"
          maxlength="150"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="url" class="block text-sm font-medium text-gray-700"
          >URL</label
        >
        <input
          v-model="icon.url"
          type="url"
          id="url"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        />
      </div>
      <div class="mb-4">
        <label for="class_name" class="block text-sm font-medium text-gray-700"
          >CSS Class Name</label
        >
        <input
          v-model="icon.class_name"
          type="text"
          id="class_name"
          maxlength="100"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
        />
      </div>
      <BaseButton
        class="w-full py-2 bg-cyan-400 text-white rounded-md hover:bg-cyan-500 transition duration-300"
        type="submit"
        color="teal"
      >
        Save Changes
      </BaseButton>
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

const icon = ref({});

const fetchIcon = async () => {
  const id = route.params.id;
  const info = await store.dispatch("icon/getIconById", id);
  if (info) {
    icon.value = { ...info };
  } else {
    Toast.error("Failed to load icon data");
  }
};

const handleSubmit = async () => {
  try {
    await store.dispatch("icon/updateInfo", {
      id: route.params.id,
      ...icon.value,
    });
    Toast.success("Icon updated successfully!");
    setTimeout(() => {
      router.push("/admin/icon"); // Redirect after delay
    }, 4000);
  } catch (error) {
    console.error("Error updating Icon:", error);
    Toast.error("Failed to update Icon.");
  }
};

onMounted(fetchIcon);
</script>

<style scoped>
/* Add your custom styles here */
</style>
