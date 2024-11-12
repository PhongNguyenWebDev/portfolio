// AboutMeLayout
<script setup>
import AboutMe from "./AboutMeList.vue";
import WorkEx from "./WorkExList.vue";
</script>

<template>
  <div>
    <h3
      class="leading-4 tracking-wider lg:text-4xl text-2xl font-medium text-gray-700"
    >
      Manage About Me
    </h3>
    <!-- List components -->
    <div>
      <AboutMe />
      <WorkEx />
    </div>
  </div>
</template>

<style scoped>
/* You can add custom styles here if needed */
</style>
