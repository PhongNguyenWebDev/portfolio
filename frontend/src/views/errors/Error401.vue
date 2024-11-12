<template>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-4xl font-bold text-red-500">404</h1>
    <p class="mt-4 text-lg">
      Bạn cần phải đăng nhập trước khi vào trang admin.
    </p>
    <router-link to="/" class="mt-6 text-blue-500 hover:underline"
      >Trở về trang chính</router-link
    >
  </div>
</template>

<script>
export default {
  name: "Error404",
};
</script>
