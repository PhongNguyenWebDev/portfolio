<template>
  <Header />
  <main class="relative">
    <About />
    <Skills />
    <Projects />
    <Contact />
  </main>
  <Footer />
</template>

<script>
import { revealElements } from "@/assets/js/scrollReveal";
import Header from "@/components/portfolio/layout/Header.vue";
import About from "@/components/portfolio/about/About.vue";
import Skills from "@/components/portfolio/skills/Skills.vue";
import Projects from "@/components/portfolio/projects/Projects.vue";
import Contact from "@/components/portfolio/contact/Contact.vue";
import Footer from "@/components/portfolio/layout/Footer.vue";
import { nextTick } from "vue";

export default {
  name: "Portfolio",
  components: {
    Header,
    About,
    Skills,
    Projects,
    Contact,
    Footer,
  },
  mounted() {
    nextTick(() => {
      revealElements();
    });
  },
};
</script>

<style scoped>
main {
  flex: 1 0 auto;
}
</style>
