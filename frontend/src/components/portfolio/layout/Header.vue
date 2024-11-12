<template>
  <section id="home">
    <header
      class="fixed top-0 left-0 right-0 z-10 transition-transform dark:bg-black w-full shadow-lg px-2 lg:px-0"
    >
      <NavBar />
    </header>
  </section>
  <Slider />
</template>

<script>
import NavBar from "../layout/Navbar.vue";
import Slider from "../layout/Slider.vue";
export default {
  name: "Header",
  components: {
    NavBar,
    Slider,
  },
};
</script>

<style scoped></style>
