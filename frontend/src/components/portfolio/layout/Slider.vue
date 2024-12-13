<template>
  <section class="relative slider lg:pt-0 pt-8 bg-gray-100 dark:bg-black px-2">
    <div
      class="mx-auto lg:w-[80%] lg:pt-10 pt-0 grid grid-cols-1 lg:grid-cols-12 lg:gap-4 items-center justify-center lg:h-screen dark:text-white text-center dark:bg-black bg-gray-100"
      v-for="slider in sliders"
      :key="slider.id"
    >
      <div class="lg:col-span-6 sm:col-span-6 text-start">
        <span
          class="inline-flex items-center justify-center w-[auto] px-2 h-6 dark:bg-sky-400 bg-black text-white text-xs font-bold rounded-full"
          v-html="slider.name"
        ></span>

        <h1 class="lg:py-7 py-2 sm:text-5xl 2xl:text-6xl font-medium">
          I'm a
          <span
            class="text-slide font-medium fade-in"
            v-html="slider.position"
          ></span>
        </h1>
        <p
          class="ms:text-base 2xl:text-base text-gray-400 text-wrap fade-in"
          v-html="slider.description"
        ></p>

        <div class="flex justify-start mt-7">
          <button
            class="me-5 bg-cyan-400 hover:bg-cyan-500 text-white font-bold py-2 px-4 rounded"
          >
            HIRE ME
          </button>
          <button
            class="bg-slate-200 dark:text-black hover:bg-slate-300 font-medium py-2 px-4 rounded flex align-center"
            @click="downloadCV(slider)"
          >
            Download CV
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-6 ms-1"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75"
              />
            </svg>
          </button>
        </div>

        <div class="pt-10">
          <ul
            class="lg:pt-5 flex justify-start space-x-10 align-center fade-in"
          >
            <li v-for="item in icons" :key="item.id" class="icon-shadow">
              <a
                :href="item.url"
                class="flex justify-center text-center items-center w-10 h-10 rounded-full ring-1 ring-sky-400 hover:bg-cyan-500"
              >
                <font-awesome-icon :icon="['fab', item.class_name]" />
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div
        class="lg:col-span-6 sm:col-span-6 flex lg:justify-end img-slide justify-end lg:mx-auto lg:w-[auto] lg:mt-0 mt-2"
      >
        <img
          rel="preload"
          loading="lazy"
          class="justify-center fade-in object-cover"
          :src="slider.image"
          alt="avatar"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import axios from "axios";
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

const getImageUrl = (imagePath) =>
  imagePath ? `http://localhost:8000${imagePath}` : "";

const downloadCV = async (slider) => {
  try {
    const { data } = await axios.get(
      `https://api.phongnguyen.io.vn/api/v1/downloadCV/${slider.id}`, // Sử dụng slider.id thay vì slider.id trực tiếp
      {
        responseType: "blob",
      }
    );

    // Tạo URL cho dữ liệu tải về
    const url = URL.createObjectURL(data);
    const link = document.createElement("a");
    link.href = url;
    link.download = `${slider.url_cv}`; // Sử dụng slider.url_cv từ đối tượng slider
    link.click();
    URL.revokeObjectURL(url);
  } catch (error) {
    console.error("Có lỗi khi tải CV:", error);
  }
};
</script>
