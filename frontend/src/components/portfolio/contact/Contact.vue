<template>
  <section id="contact" class="mx-auto lg:w-[80%] lg:px-0 px-4 lg:pb-40 py-10">
    <!-- Title -->
    <div class="lg:mb-10 lg:pb-10 pb-10 relative text-center contact">
      <h1
        id="heading-main"
        class="lg:text-3xl text-2xl text-center font-semibold dark:text-cyan-100"
      >
        Contact Me
      </h1>
      <h1
        class="uppercase w-full lg:text-7xl text-5xl tracking-tight absolute top-0 z-10 opacity-10 dark:-z-10 dark:text-gray-400 dark:opacity-20"
      >
        Contact Me
      </h1>
    </div>
    <!-- Content -->
    <div class="lg:grid lg:grid-cols-12 grid-cols-12 gap-x-20">
      <!-- Contact Form -->
      <div class="lg:col-span-6 col-span-12 contact_left">
        <h3 class="lg:text-2xl text-xl font-medium mb-4 dark:text-white">
          Send Me a Message
        </h3>
        <form @submit.prevent="submitForm" class="space-y-4">
          <div>
            <label
              for="name"
              class="block text-sm font-medium text-gray-700 dark:text-gray-200"
              >Your Name</label
            >
            <input
              type="text"
              id="name"
              v-model="form.name"
              class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500"
              placeholder="Phong Nguyen"
            />
          </div>
          <div>
            <label
              for="email"
              class="block text-sm font-medium text-gray-700 dark:text-gray-200"
              >Your Email</label
            >
            <input
              type="email"
              id="email"
              v-model="form.email"
              class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500"
              placeholder="phong302.work@mail.com"
            />
          </div>
          <div>
            <label
              for="message"
              class="block text-sm font-medium text-gray-700 dark:text-gray-200"
              >Message</label
            >
            <textarea
              id="message"
              v-model="form.message"
              rows="4"
              class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500"
              placeholder="Your message..."
            ></textarea>
          </div>
          <button
            type="submit"
            class="w-full px-4 py-2 bg-cyan-500 text-white font-bold rounded-md shadow hover:bg-cyan-600 focus:ring-4 focus:ring-cyan-300 transition-all"
          >
            Send Message
          </button>
        </form>
      </div>

      <!-- Find Me Section -->
      <div class="lg:col-span-6 col-span-12 mt-10 lg:mt-0 contact_right">
        <h3 class="lg:text-2xl text-xl font-medium mb-4 dark:text-white">
          Find Me
        </h3>
        <!-- Infomation -->
        <div v-for="item in users" :key="item.id" class="pb-4">
          <h4 class="text-xl font-medium mb-4 dark:text-white">Information</h4>
          <div class="text-gray-600 dark:text-gray-300">
            <font-awesome-icon
              :icon="['far', 'envelope']"
              size="lg"
              class="pr-2 dark:text-cyan-300"
            />
            {{ item.email }}
          </div>
          <div class="text-gray-600 py-2 dark:text-gray-300">
            <font-awesome-icon
              :icon="['fas', 'phone']"
              size="lg"
              class="pr-2 dark:text-cyan-300"
            />{{ item.phone }}
          </div>
          <div class="text-gray-600 dark:text-gray-300">
            <font-awesome-icon
              :icon="['fas', 'location-dot']"
              size="lg"
              class="pr-2 dark:text-cyan-300"
            />
            Address: {{ item.address }}.
          </div>
        </div>
        <div class="space-y-3">
          <p class="text-gray-600 dark:text-gray-300">
            You can find me on these platforms:
          </p>
          <ul
            class="flex justify-start space-x-5 align-center text-black dark:text-white"
          >
            <li v-for="item in icons" :key="item.id" class="icon-shadow">
              <a
                :href="item.link"
                class="flex justify-center text-center items-center w-10 h-10 rounded-full ring-1 ring-sky-400 hover:bg-cyan-500"
              >
                <font-awesome-icon :icon="['fab', item.class_name]" />
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, defineProps } from "vue";
import axios from "axios";
// Data
const form = ref({
  name: "",
  email: "",
  message: "",
});
// const icons = ref([
//   { name: "facebook-f", link: "https://facebook.com" },
//   { name: "linkedin-in", link: "https://linkedin.com" },
//   { name: "github", link: "https://github.com" },
// ]);
const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
  icons: {
    type: Array,
    required: true,
  },
});
// Methods
const submitForm = async () => {
  try {
    const response = await axios.post("v1/contact", form.value);
    // Hiển thị thông báo thành công
    alert(response.data.message || "Message sent successfully!");
    form.value = { name: "", email: "", message: "" }; // Reset form
  } catch (error) {
    console.error(error);
    alert("There was an error sending the message.");
  }
};
</script>

<style scoped></style>
