<template>
  <div class="container mx-auto py-5">
    <h2 class="text-2xl leading-4 tracking-wider mb-4">Edit About Me</h2>
    <form @submit.prevent="handleSubmit">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input
          v-model="aboutMe.title"
          type="text"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        />
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700"
          >Description</label
        >
        <textarea
          v-model="aboutMe.description"
          class="mt-1 block w-full border border-gray-300 rounded-md p-2"
          required
        ></textarea>
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

const aboutMe = ref({ title: "", description: "" });

const fetchAboutMe = async () => {
  const id = route.params.id;
  const info = await store.dispatch("about-me/getAboutMeById", id);
  if (info) {
    aboutMe.value = { ...info };
  }
};

const handleSubmit = async () => {
  try {
    await store.dispatch("about-me/updateAboutMe", {
      id: route.params.id,
      ...aboutMe.value,
    });
    Toast.success("About Me updated successfully!"); // Show success toast
    setTimeout(() => {
      router.push("/admin/about-me"); // Redirect after delay
    }, 4000);
  } catch (error) {
    console.error("Error updating About Me:", error);
    Toast.error("Failed to update About Me."); // Show error toast
  }
};

onMounted(fetchAboutMe);
</script>

<style scoped>
/* Add your custom styles here */
</style>
