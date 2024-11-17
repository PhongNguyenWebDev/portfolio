<template>
  <section
    id="about"
    class="text-center lg:py-40 py-10 lg:px-0 px-4 mx-auto lg:w-[80%]"
  >
    <div class="lg:mb-10 lg:pb-10 pb-10 relative text-center about">
      <h1
        id="heading-main"
        class="lg:text-3xl text-xl font-semibold dark:text-cyan-100"
      >
        About Me
      </h1>
      <h1
        class="uppercase lg:text-7xl text-5xl absolute w-full z-10 top-0 opacity-10 dark:-z-10 dark:text-gray-400 dark:opacity-20"
      >
        About me
      </h1>
    </div>

    <div class="grid grid-cols-12 gap-3">
      <!-- Accordion Section -->
      <div class="lg:col-span-6 col-span-12 w-full mx-auto">
        <div
          v-for="item in aboutMe"
          :key="item.title"
          class="border-gray-200 rounded mb-2 about_item"
        >
          <div class="flex justify-between items-center">
            <h1
              class="w-full dark:text-white text-left text-base py-3 px-4 font-medium"
              @click="toggleAccordion(item.title)"
            >
              {{ item.title }}
            </h1>
            <svg
              :class="[
                'w-6 h-6 cursor-pointer dark:text-white transition-all',
                { 'rotate-180': activeAccordion === item.title },
              ]"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              @click="toggleAccordion(item.title)"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                :d="
                  activeAccordion === item.title
                    ? 'M5 12h14'
                    : 'M12 4.5v15m7.5-7.5h-15'
                "
              />
            </svg>
          </div>
          <div
            :style="{
              maxHeight: activeAccordion === item.title ? '300px' : '0px',
            }"
            class="overflow-hidden text-start toggle"
          >
            <div
              class="p-4 text-gray-700 dark:text-gray-400"
              v-html="item.description"
            ></div>
          </div>
        </div>
      </div>

      <!-- Work Experience Section -->
      <div class="lg:col-span-6 col-span-12">
        <div
          class="grid lg:grid-cols-12 gap-3 grid-cols-1 dark:text-white about_ex"
        >
          <div
            class="col-span-6 lg:py-4 py-2 px-2 lg:px-2 flex items-center hover:ring-2 dark:ring-cyan-300 ring-cyan-100 rounded-lg border hover:skew-y-3 duration-300"
            v-for="item in workEx"
            :key="item.id"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-16 cursor-pointer text-cyan-600 dark:text-cyan-300"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"
              />
            </svg>
            <div class="lg:ps-10 ps-5 text-start">
              <h3 class="text-base font-medium" v-html="item.title"></h3>
              <span
                class="inline-flex items-center justify-center w-28 h-6 dark:bg-sky-400 bg-black text-white text-xs rounded-full"
              >
                {{ formatDate(item.start_date) }} -
                {{ formatDate(item.end_date) }}
              </span>
              <p class="text-sm font-medium">{{ item.position }}</p>
              <p v-if="item.gpa_scale > 0" class="text-xs py-1">
                GPA: {{ item.gpa }}/{{ item.gpa_scale }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import { format } from "date-fns";
const props = defineProps({
  aboutMe: {
    type: Array,
    required: true,
  },
  workEx: {
    type: Array,
    required: true,
  },
});
// Khai báo activeAccordion dưới dạng ref để có thể thay đổi
const activeAccordion = ref(null);

// Hàm toggle accordion
const toggleAccordion = (title) => {
  activeAccordion.value = activeAccordion.value === title ? null : title;
};
// // Hàm format ngày tháng
const formatDate = (date) => {
  return date ? format(new Date(date), "M/yyyy") : "";
};
</script>

<style scoped>
.toggle {
  transition: max-height 1s cubic-bezier(0.5, 0.02, 0.2, 0.53);
  overflow: hidden; /* Đảm bảo không hiển thị nội dung ra ngoài */
}
</style>
