<template>
  <nav
    v-show="isNavVisible"
    class="flex items-center ms:text-base 2xl:text-xl justify-between dark:bg-black lg:py-4 lg:px-36"
  >
    <!-- Logo -->
    <div class="flex-shrink-0">
      <img rel="preload" src="@/assets/img/logo.png" alt="Logo" class="w-40" />
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
          <a :href="link.link" class="">
            {{ link.name }}
          </a>
        </li>
      </ul>
    </div>

    <!-- Toggle Dark Mode & Login -->
    <div class="flex items-center lg:space-x-4 space-x-2">
      <button @click="toggleDarkMode" class="focus:outline-none">
        <svg
          v-if="!isDarkMode"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="h-6 w-6 transition-transform duration-300"
          @click="toggleAnimation"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
          />
        </svg>
        <svg
          v-if="isDarkMode"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="h-6 w-6 transition-transform duration-300 text-width"
          @click="toggleAnimation"
        >
          <path
            stroke-linecap="round"
            class="text-white"
            stroke-linejoin="round"
            d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"
          />
        </svg>
      </button>

      <!-- Login -->
      <div class="login align-middle hidden lg:flex">
        <button v-if="!user" @click="showLoginPopup" class="dark:text-gray-200">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
            />
          </svg>
        </button>
        <span class="dark:text-white" v-else>{{ user.name }}</span>
        <LoginPopup
          v-if="isLoginPopupVisible"
          @close="isLoginPopupVisible = false"
        />
      </div>

      <!-- Menu Mobile -->
      <div class="lg:hidden">
        <svg
          @click="toggleNavVisibility"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="h-6 w-6 cursor-pointer dark:text-white"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5"
          />
        </svg>
      </div>
    </div>
  </nav>
  <div
    :class="{
      'transform -translate-x-full': !isMobileNavVisible,
      'transform translate-x-0 transition-transform duration-300':
        isMobileNavVisible,
    }"
    class="lg:hidden bg-white dark:bg-black fixed top-0 left-0 h-full w-2/3 z-50 p-4 menu-mobile"
  >
    <ul class="flex flex-col space-y-2 relative">
      <div class="absolute right-0 top-3 cursor-pointer">
        <svg
          @click="toggleNavVisibility"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="size-6 dark:text-white"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M6 18 18 6M6 6l12 12"
          />
        </svg>
      </div>
      <li v-for="link in links" :key="link.name">
        <a
          @click="scrollTo(link.toLowerCase())"
          class="block dark:text-gray-200 hover:text-sky-300 dark:hover:text-sky-400"
          :href="link.link"
        >
          {{ link.name }}
        </a>
      </li>
      <li>
        <!-- Login -->
        <div class="login align-middle flex">
          <button
            v-if="!user"
            @click="showLoginPopup"
            class="dark:text-gray-200"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
              />
            </svg>
          </button>
          <!-- <span class="dark:text-white" v-else>{{ user.name }}</span> -->
        </div>
      </li>
    </ul>
    <LoginPopup
      v-if="isLoginPopupVisible"
      @close="isLoginPopupVisible = false"
    />
  </div>
</template>

<script>
import LoginPopup from "@/components/portfolio/layout/Login.vue";
export default {
  components: {
    LoginPopup,
  },
  computed: {
    isAuthenticated() {
      return this.$store.getters.isAuthenticated;
    },
    user() {
      return this.$store.getters["auth/getUser"];
    },
  },
  name: "NavBar",
  data() {
    return {
      isLoginPopupVisible: false,
      lastScrollY: 0,
      isNavVisible: true,
      isDarkMode: false,
      isMobileNavVisible: false,
      activeLink: "", // Track the current section
      links: [
        { name: "Home", link: "#home" },
        { name: "About", link: "#about" },
        { name: "Skills", link: "#skills" },
        { name: "Projects", link: "#projects" },
        { name: "Contact", link: "#contact" },
      ],
    };
  },
  methods: {
    toggleDarkMode() {
      this.isDarkMode = !this.isDarkMode;
      const isDark = document.documentElement.classList.toggle("dark");
      localStorage.setItem("dark-mode", isDark);
    },
    toggleAnimation() {
      const button = event.currentTarget;
      button.classList.add("animate-[toggle-dark-mode_0.5s_ease-in-out]");
      setTimeout(() => {
        button.classList.remove("animate-[toggle-dark-mode_0.5s_ease-in-out]");
      }, 500);
    },
    scrollTo(sectionId) {
      const section = document.getElementById(sectionId);
      if (section) {
        section.scrollIntoView({ behavior: "smooth" });
      }
      this.isMobileNavVisible = false;
    },
    toggleNavVisibility() {
      this.isMobileNavVisible = !this.isMobileNavVisible;
    },
    handleScroll() {
      const scrollY = window.scrollY;
      if (scrollY < this.lastScrollY) {
        this.isNavVisible = true;
      } else {
        this.isNavVisible = false;
      }
      this.lastScrollY = scrollY;
      this.updateActiveLink();
    },
    updateActiveLink() {
      const sections = this.links.map((link) =>
        document.querySelector(link.link)
      );
      sections.forEach((section, index) => {
        if (section) {
          // Check if the section exists
          const rect = section.getBoundingClientRect();
          if (rect.top >= 0 && rect.top <= window.innerHeight / 2) {
            this.activeLink = this.links[index].name;
          }
        }
      });
    },

    showLoginPopup() {
      this.isLoginPopupVisible = true;
    },
  },
  mounted() {
    if (localStorage.getItem("dark-mode") === "true") {
      this.isDarkMode = true;
      document.documentElement.classList.add("dark");
    }
    window.addEventListener("scroll", this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll);
  },
};
</script>

<style scoped>
img {
  display: block;
}
.menu-mobile {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 66.67%; /* Chiếm 2/3 chiều rộng */
  background-color: white; /* Hoặc màu tối nếu cần */
  z-index: 50;
  transition: transform 0.3s ease; /* Thêm transition */
}
</style>
