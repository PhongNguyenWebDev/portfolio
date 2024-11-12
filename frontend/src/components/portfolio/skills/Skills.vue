<template>
  <section
    id="skills"
    class="text-center lg:pb-40 pb-10 lg:px-0 px-4 mx-auto lg:w-[80%]"
  >
    <div class="lg:mb-10 lg:pb-10 pb-10 relative text-center skills">
      <h1
        id="heading-main"
        class="lg:text-3xl text-2xl text-center font-semibold dark:text-cyan-100"
      >
        My Skills
      </h1>
      <h1
        class="uppercase lg:text-7xl text-5xl absolute top-0 w-full z-10 opacity-10 dark:-z-10 dark:text-gray-400 dark:opacity-20"
      >
        My Skills
      </h1>
    </div>
    <div class="grid grid-cols-12 gap-y-5 lg:gap-x-10 md:gap-x-0">
      <div
        v-for="skill in skills"
        :key="skill"
        class="lg:col-span-6 col-span-12 skills_item"
      >
        <div class="flex justify-between">
          <h2
            class="lg:text-xl text-sm py-2 text-start font-semibold dark:text-white lg:mb-2"
          >
            {{ skill.name }}
          </h2>
          <span class="dark:text-cyan-400">
            {{ skill.percentage + "%" }}
          </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-1 mb-4">
          <div
            class="bg-cyan-400 h-1 rounded-full"
            :style="{ width: skill.percentage + '%' }"
          ></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "Skills",
  data() {
    return {
      skills: [
        { name: "Laravel", percentage: 85 },
        { name: "Vue.js", percentage: 50 },
        { name: "Tailwind CSS", percentage: 60 },
        { name: "Mysql", percentage: 70 },
        { name: "JavaScript", percentage: 50 },
      ],
    };
  },
};
</script>

<style scoped>
h1 {
  color: #333;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin: 10px 0;
}
</style>
