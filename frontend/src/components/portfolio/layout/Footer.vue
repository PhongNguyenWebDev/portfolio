<template>
  <footer
    class="mx-auto text-center px-4 py-20 bg-gray-100 dark:bg-gray-900 dark:border-gray-900 shadow-top block"
  >
    <div class="lg:mx-28 lg:grid lg:grid-cols-12 grid-cols-1 gap-x-10 mb-5">
      <div
        class="lg:col-span-6 col-span-12 transition-opacity duration-700 ease-in-out opacity-0 animate-fade-in"
      >
        <!-- Logo -->
        <div class="flex-shrink-0">
          <img src="@/assets/img/logo.png" alt="Logo" class="w-40" />
        </div>
        <!-- Intro -->
        <div class="text-start text-gray-400 lg:w-full w-80">
          <p class="text-wrap">
            Welcome to my portfolio, where I showcase the projects and skills
            I’ve developed in web development. I focus on creating dynamic,
            user-friendly websites and applications, highlighting both front-end
            and back-end expertise.
          </p>
          <p class="my-4">
            Explore my work to see how I bring ideas to life through intuitive,
            responsive design and efficient coding. Thank you for visiting, and
            I look forward to connecting with you!
          </p>
          <p class="z-20">Copyright©2024 My Portfolio. All rights reserved.</p>
        </div>
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
          <div class="space-y-2 text-gray-600 dark:text-gray-300">
            <div>
              <font-awesome-icon
                :icon="['far', 'envelope']"
                size="lg"
                class="pr-2 dark:text-cyan-300"
              />
              {{ email }}
            </div>
            <div>
              <font-awesome-icon
                :icon="['fas', 'phone']"
                size="lg"
                class="pr-2 dark:text-cyan-300"
              />
              {{ phone }}
            </div>
            <div>
              <font-awesome-icon
                :icon="['fas', 'location-dot']"
                size="lg"
                class="pr-2 dark:text-cyan-300"
              />
              {{ address }}
            </div>
          </div>
          <div class="space-y-3 mt-4">
            <ul class="flex space-x-5">
              <li v-for="icon in icons" :key="icon.name">
                <a
                  :href="icon.link"
                  class="flex items-center justify-center w-10 h-10 rounded-full ring-1 dark:text-white ring-sky-400 hover:bg-cyan-500 transition-transform duration-300 transform hover:scale-110"
                >
                  <font-awesome-icon :icon="['fab', icon.name]" />
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

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
      icons: [
        { name: "facebook-f", link: "https://facebook.com" },
        { name: "linkedin-in", link: "https://linkedin.com" },
        { name: "github", link: "https://github.com" },
      ],
      email: "phong302.work@gmail.com",
      phone: "+84 328 414 771",
      address: "Ho Chi Minh City, VietNam",
    };
  },
};
</script>

<style scoped>
.shadow-top {
  box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.8);
}
</style>
