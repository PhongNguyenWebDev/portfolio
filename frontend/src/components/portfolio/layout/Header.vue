<template>
  <div>
    <section id="home">
      <header
        class="lg:fixed top-0 lg:left-0 px-2 lg:right-0 z-10 transition-transform dark:bg-black w-full shadow-lg"
      >
        <NavBar />
      </header>
    </section>
    <Slider :sliders="sliders" :icons="icons" />
  </div>
</template>

<script setup>
import NavBar from "../layout/Navbar.vue";
import Slider from "../layout/Slider.vue";
import { defineProps } from "vue";

const props = defineProps({
  sliders: {
    type: Array,
    required: true,
  },
  icons: {
    type: Array,
    required: true,
  },
});
</script>

<style scoped></style>
