<template>
  <div>
    <Header :general="general" :sliders="sliders" :icons="icons" />
    <main class="relative">
      <About :aboutMe="aboutMe" :workEx="workEx" />
      <Skills :skills="skills" />
      <Projects :projects="projects" />
      <Contact :users="users" :icons="icons" />
    </main>
    <Footer :users="users" :general="general" :icons="icons" />
  </div>
</template>

<script setup>
import { revealElements } from "@/assets/js/scrollReveal";
import Header from "@/components/portfolio/layout/Header.vue";
import About from "@/components/portfolio/about/About.vue";
import Skills from "@/components/portfolio/skills/Skills.vue";
import Projects from "@/components/portfolio/projects/Projects.vue";
import Contact from "@/components/portfolio/contact/Contact.vue";
import Footer from "@/components/portfolio/layout/Footer.vue";
import { ref, nextTick, onMounted } from "vue";
import axios from "axios";

const general = ref([]);
const icons = ref([]);
const skills = ref([]);
const projects = ref([]);
const sliders = ref([]);
const aboutMe = ref([]);
const workEx = ref([]);
const users = ref([]);

// Hàm để fetch data từ API
const fetchData = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/v1/fetch-api");
    general.value = response.data.general;
    icons.value = response.data.icons;
    skills.value = response.data.skills;
    projects.value = response.data.projects;
    sliders.value = response.data.sliders;
    aboutMe.value = response.data.aboutMe;
    workEx.value = response.data.workEx;
    users.value = response.data.users;

    // Đảm bảo rằng DOM đã được cập nhật trước khi gọi `revealElements()`
    await nextTick();
    revealElements();
  } catch (error) {
    console.error("There was an error fetching the data:", error);
  }
};

onMounted(() => {
  fetchData();
});
</script>

<style scoped>
main {
  flex: 1 0 auto;
}
</style>
