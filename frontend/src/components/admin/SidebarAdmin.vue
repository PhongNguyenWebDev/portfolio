<script setup lang="ts">
import { ref } from "vue";
import { useSidebar } from "../../composerable/useSidebar";
import { useRoute } from "vue-router";

const { isOpen } = useSidebar();
const route = useRoute();
const activeClass = "bg-gray-600 bg-opacity-25 text-gray-100 border-gray-100";
const inactiveClass =
  "border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100";

const items = [
  { label: "Profile", to: "/admin/profile", routeName: "Profile" },
  { label: "About Me", to: "/admin/about-me", routeName: "AboutMe" },
  { label: "Icon", to: "/admin/icon", routeName: "Icon" },
  { label: "Project", to: "/admin/project", routeName: "Project" },
  { label: "Skill", to: "/admin/skill", routeName: "Skill" },
  { label: "Slider", to: "/admin/slider", routeName: "Slider" },
  { label: "General", to: "/admin/general", routeName: "general" },
];
</script>

<template>
  <div class="flex">
    <div
      :class="isOpen ? 'block' : 'hidden'"
      class="fixed inset-0 z-20 bg-black opacity-50 lg:hidden"
      @click="isOpen = false"
    />

    <div
      :class="isOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
      class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0"
    >
      <div class="flex items-center justify-center mt-8">
        <router-link to="/">
          <img src="@/assets/img/logo.png" class="scale-75" alt="" />
        </router-link>
      </div>

      <nav class="mt-10">
        <router-link
          v-for="item in items"
          :key="item.routeName"
          :to="item.to"
          class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4"
          :class="[route.name === item.routeName ? activeClass : inactiveClass]"
        >
          <i class="fa-solid fa-chart-pie"></i>
          <span class="mx-4">{{ item.label }}</span>
        </router-link>
      </nav>
    </div>
  </div>
</template>
