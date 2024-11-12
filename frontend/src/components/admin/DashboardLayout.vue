<template>
  <div class="flex h-screen font-roboto">
    <SidebarAdmin />
    <div class="flex-1 flex flex-col overflow-hidden">
      <HeaderAdmin />
      <main class="flex-1 overflow-x-hidden overflow-y-auto">
        <div class="container mx-auto px-6 py-8">
          <router-view :user="user" />
          <!-- Truyền user xuống router-view -->
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import SidebarAdmin from "./SidebarAdmin.vue";
import HeaderAdmin from "./HeaderAdmin.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    SidebarAdmin,
    HeaderAdmin,
  },
  computed: {
    ...mapGetters("auth", ["getUser"]),
    user() {
      return this.getUser;
    },
  },
};
</script>
