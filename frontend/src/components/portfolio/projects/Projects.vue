<template>
  <section id="projects" class="mx-auto lg:w-[80%] lg:px-0 px-4 lg:pb-40 py-10">
    <!-- title -->
    <div class="lg:mb-10 lg:pb-10 pb-10 relative text-center projects">
      <h1
        id="heading-main"
        class="lg:text-3xl text-2xl text-center font-semibold dark:text-cyan-100"
      >
        My Projects
      </h1>
      <h1
        class="uppercase w-full lg:text-7xl text-5xl tracking-tight absolute top-0 z-10 opacity-10 dark:-z-10 dark:text-gray-400 dark:opacity-20"
      >
        My Projects
      </h1>
    </div>

    <!-- Projects -->
    <div class="grid lg:grid-cols-12 grid-cols-1 gap-x-5">
      <div
        v-for="item in projects"
        :key="item.id"
        class="col-span-4 dark:bg-slate-900 w-full shadow-lg rounded-lg relative project_item"
      >
        <img
          class="object-cover transition-transform duration-500 ease-in-out hover:scale-105 rounded-t-lg lg:h-[200px] h-[200px] w-full dark:ring-1 dark:ring-cyan-200"
          :src="item.image_project"
          alt="Errors image"
          rel="preload"
          loading="lazy"
        />

        <div class="p-3">
          <!-- project name -->
          <h3
            class="text-xl font-bold dark:text-gray-200"
            v-html="item.title"
          ></h3>

          <!-- role -->

          <p class="text-sm text-gray-500" v-html="item.description"></p>
          <div class="w-full text-sm flex text-gray-500 gap-x-3">
            <img
              v-for="(tech, index) in item.image_tech"
              :key="index"
              class="h-8 w-8 object-cover"
              :src="tech"
              loading="lazy"
              alt="Tech icon"
            />
          </div>
          <a :href="item.url">
            <span
              class="mt-2 inline-flex items-center text-base justify-center dark:text-sky-600 hover:text-cyan-400 font-medium"
            >
              See website
            </span></a
          >
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import axios from "axios";
import { defineProps } from "vue";
const props = defineProps({
  projects: {
    type: Array,
    required: true,
  },
});
const getImageUrl = (imagePath) =>
  imagePath ? `http://localhost:8000${imagePath}` : "";
</script>
<style scoped></style>
