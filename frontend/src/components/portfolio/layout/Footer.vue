<template>
  <footer
    class="mx-auto text-center px-4 lg:py-20 py-10 bg-gray-100 dark:bg-gray-900 dark:border-gray-900 shadow-top block"
  >
    <div class="lg:mx-28 lg:grid lg:grid-cols-12 grid-cols-1 gap-x-10 mb-5">
      <div
        class="lg:col-span-6 col-span-12 transition-opacity duration-700 ease-in-out opacity-0 animate-fade-in"
      >
        <!-- Logo -->
        <div class="flex-shrink-0" v-for="item in general" :key="item.logo">
          <img
            rel="preload"
            :src="item.logo"
            alt="Logo"
            class="w-40"
            loading="lazy"
          />
          <p
            class="text-wrap text-start space-y-3 dark:text-gray-200"
            v-html="item.des_footer"
          ></p>
        </div>
        <!-- Intro -->
      </div>
      <div
        class="lg:col-span-6 col-span-12 lg:pt-0 pt-10 text-start flex transition-opacity duration-700 ease-in-out opacity-0 animate-fade-in delay-200"
      >
        <!-- Short Link -->
        <div>
          <h2 class="text-2xl font-semibold mb-5 text-cyan-300">Short Link</h2>
          <ul class="lg:ps-5 text-base space-y-1">
            <li v-for="link in shortLinks" :key="link.text">
              <a
                :href="link.href"
                class="hover:text-cyan-300 dark:text-gray-300 dark:hover:text-cyan-300 transition-colors duration-300"
                >{{ link.text }}</a
              >
            </li>
          </ul>
        </div>
        <!-- Contact -->
        <div class="lg:ps-32">
          <h2 class="text-2xl font-medium mb-5 text-cyan-300">Contact</h2>
          <div
            class="space-y-2 text-gray-600 dark:text-gray-300"
            v-for="item in users"
            :key="item.id"
          >
            <div>
              <font-awesome-icon
                :icon="['far', 'envelope']"
                size="lg"
                class="pr-2 dark:text-cyan-300"
              />
              {{ item.email }}
            </div>
            <div>
              <font-awesome-icon
                :icon="['fas', 'phone']"
                size="lg"
                class="pr-2 dark:text-cyan-300"
              />
              {{ item.phone }}
            </div>
            <div>
              <font-awesome-icon
                :icon="['fas', 'location-dot']"
                size="lg"
                class="pr-2 dark:text-cyan-300"
              />
              {{ item.address }}
            </div>
          </div>
          <div class="space-y-3 mt-4">
            <ul class="flex space-x-5">
              <li v-for="item in icons" :key="item.id">
                <a
                  :href="item.url"
                  class="flex items-center justify-center w-10 h-10 rounded-full ring-1 dark:text-white ring-sky-400 hover:bg-cyan-500 transition-transform duration-300 transform hover:scale-110"
                >
                  <font-awesome-icon :icon="['fab', item.class_name]" />
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>
<script setup>
import { ref, defineProps } from "vue";
const props = defineProps({
  general: {
    type: Array,
    required: true,
  },
  users: {
    type: Array,
    required: true,
  },
  icons: {
    type: Array,
    required: true,
  },
});
const getImageUrl = (imagePath) =>
  imagePath ? `http://localhost:8000${imagePath}` : "";
</script>
<script>
export default {
  name: "Footer",
  data() {
    return {
      shortLinks: [
        { text: "Home", href: "#home" },
        { text: "About", href: "#about" },
        { text: "Skills", href: "#skills" },
        { text: "Projects", href: "#projects" },
        { text: "Contact", href: "#contact" },
      ],
    };
  },
};
</script>

<style scoped>
.shadow-top {
  box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.8);
}
</style>
