<template>
  <div>
    <!-- Navigation Bar -->
    <nav
      v-show="isNavVisible"
      class="flex items-center ms:text-base 2xl:text-xl justify-between dark:bg-black lg:py-4 lg:px-36"
    >
      <!-- Logo -->
      <div class="flex-shrink-0" v-for="item in general" :key="item.logo">
        <img rel="preload" :src="item.logo" alt="Logo" class="w-40" />
      </div>

      <!-- Navigation Links -->
      <div class="flex-grow lg:flex hidden justify-center">
        <ul class="flex space-x-16 mb-0">
          <li
            v-for="link in links"
            :key="link.name"
            :class="{
              'text-cyan-300': activeLink === link.name,
              'dark:text-gray-200 hover:text-sky-300 dark:hover:text-sky-400 transition-all hover:animate-bounce ':
                activeLink !== link.name,
            }"
          >
            <a :href="link.link">{{ link.name }}</a>
          </li>
        </ul>
      </div>

      <!-- Dark Mode Toggle & User/Login -->
      <div class="flex items-center lg:space-x-4 space-x-2">
        <!-- Dark Mode Toggle -->
        <button
          @click="toggleDarkMode"
          class="focus:outline-none dark:text-gray-200"
        >
          <svg
            v-if="!isDarkMode"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6 transition-transform duration-300"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
            />
          </svg>
          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6 transition-transform duration-300"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"
            />
          </svg>
        </button>

        <!-- Login Button or User Info -->
        <div class="lg:flex hidden">
          <div
            v-if="!user"
            @click="showLoginPopup"
            class="cursor-pointer dark:text-gray-200"
          >
            <span class="dark:text-gray-200">Login</span>
          </div>
          <span v-else class="dark:text-white">{{ user.name }}</span>
        </div>
      </div>

      <!-- Hamburger Icon for Mobile -->
      <button @click="toggleNavVisibility" class="lg:hidden block text-3xl">
        <span :class="isMobileNavVisible ? 'text-gray-400' : 'text-gray-700'"
          >☰</span
        >
      </button>
    </nav>

    <!-- Mobile Navigation Menu -->
    <div
      v-show="isMobileNavVisible"
      class="fixed top-0 left-0 h-full w-2/3 bg-white dark:bg-black z-50 p-4 transition-transform duration-300 ease-linear"
    >
      <ul>
        <li v-for="link in links" :key="link.name" class="mb-2">
          <a
            @click="scrollTo(link.link)"
            class="block dark:text-gray-200 hover:text-sky-300"
          >
            {{ link.name }}
          </a>
        </li>

        <!-- Login Link or User Info in Mobile -->
        <li class="mb-2">
          <div
            v-if="!user"
            @click="showLoginPopup"
            class="cursor-pointer dark:text-gray-200 hover:text-sky-300"
          >
            Login
          </div>
          <span v-else class="block dark:text-white">
            {{ user.name }}
          </span>
        </li>
      </ul>
    </div>

    <!-- Login Popup -->
    <LoginPopup
      v-if="isLoginPopupVisible"
      @close="isLoginPopupVisible = false"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount, defineProps } from "vue";
import { useStore } from "vuex";
import LoginPopup from "@/components/portfolio/layout/Login.vue";

const store = useStore();

const isNavVisible = ref(true);
const isDarkMode = ref(false);
const isMobileNavVisible = ref(false);
const isLoginPopupVisible = ref(false);
const activeLink = ref("");
const lastScrollY = ref(0);

// Props
const props = defineProps({
  general: {
    type: Array,
    required: true,
  },
});

// Getters
const user = computed(() => store.getters["auth/getUser"]);

// Navigation Links
const links = [
  { name: "Home", link: "#home" },
  { name: "About", link: "#about" },
  { name: "Skills", link: "#skills" },
  { name: "Projects", link: "#projects" },
  { name: "Contact", link: "#contact" },
];

// Methods
const getImageUrl = (imagePath) =>
  imagePath ? `http://localhost:8000${imagePath}` : "";

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  const isDark = document.documentElement.classList.toggle("dark");
  localStorage.setItem("dark-mode", isDark);
};

const scrollTo = (sectionId) => {
  const section = document.querySelector(sectionId);
  if (section) section.scrollIntoView({ behavior: "smooth" });
  isMobileNavVisible.value = false;
};

const toggleNavVisibility = () => {
  isMobileNavVisible.value = !isMobileNavVisible.value;
};

// Handle Scroll
const handleScroll = () => {
  const scrollY = window.scrollY;
  isNavVisible.value = scrollY < lastScrollY.value;
  lastScrollY.value = scrollY;
};

onMounted(() => {
  if (localStorage.getItem("dark-mode") === "true") {
    isDarkMode.value = true;
    document.documentElement.classList.add("dark");
  }
  window.addEventListener("scroll", handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener("scroll", handleScroll);
});

const showLoginPopup = () => {
  isLoginPopupVisible.value = true;
};
</script>
