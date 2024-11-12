<template>
  <div>
    <div class="flex items-center justify-between py-5">
      <h2 class="text-2xl leading-4 tracking-wider">Work Experience List</h2>
      <router-link
        to="/admin/work-experience/create"
        class="text-base px-2 py-1 lg:mr-6 bg-cyan-400 text-white transition-all duration-300 hover:bg-cyan-500 cursor-pointer rounded-md"
      >
        Create New
      </router-link>
    </div>

    <table class="min-w-full">
      <thead>
        <tr>
          <th
            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Title
          </th>
          <th
            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Start Date
          </th>
          <th
            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            End Date
          </th>
          <th
            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            GPA
          </th>
          <th
            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            GPA Scale
          </th>
          <th
            class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
          >
            Position
          </th>
          <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
        </tr>
      </thead>

      <tbody class="bg-white">
        <tr v-for="item in listWorkEx" :key="item.id">
          <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
            <div class="text-sm font-medium leading-5 text-gray-900">
              {{ item.title }}
            </div>
          </td>
          <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
            <div class="text-sm leading-5 text-gray-900">
              {{ formatDate(item.start_date) }}
            </div>
          </td>
          <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
            <div class="text-sm leading-5 text-gray-900">
              {{ formatDate(item.end_date) || "Ongoing" }}
            </div>
          </td>
          <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
            <div class="text-sm leading-5 text-gray-900">{{ item.gpa }}</div>
          </td>
          <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
            <div class="text-sm leading-5 text-gray-900">
              {{ item.gpa_scale }}
            </div>
          </td>
          <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
            <div class="text-sm leading-5 text-gray-900">
              {{ item.position }}
            </div>
          </td>
          <td
            class="px-6 py-4 border-b border-gray-200 whitespace-nowrap text-right space-x-2"
          >
            <BaseButton color="teal" @click="handleEdit(item.id)"
              >Edit</BaseButton
            >
            <BaseButton color="red" @click="confirmDelete(item.id)"
              >Delete</BaseButton
            >
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted, getCurrentInstance } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import BaseButton from "@/components/BaseButton.vue"; // Adjust the path as needed

const instance = getCurrentInstance();
const Toast = instance.appContext.config.globalProperties.$toast;
const store = useStore();
const router = useRouter();
const listWorkEx = ref([]);
const error = ref(null);

// Fetch work experience data from the store
const fetchWorkEx = async () => {
  error.value = null;
  try {
    await store.dispatch("work-ex/fetchWorkEx");
    listWorkEx.value = store.getters["work-ex/info"];
  } catch (err) {
    console.error("Error fetching info:", err);
    error.value = "Failed to load information.";
    Toast.error(error.value); // Use toast from props
  }
};

// Format date to dd/mm/yyyy
const formatDate = (dateString) => {
  if (!dateString) return "";
  const date = new Date(dateString);
  const day = String(date.getDate()).padStart(2, "0");
  const month = String(date.getMonth() + 1).padStart(2, "0"); // Month is 0-based
  const year = date.getFullYear();
  return `${day}/${month}/${year}`;
};

// Handle editing a work experience entry
const handleEdit = (id) => {
  router.push({ name: "EditWorkEx", params: { id } });
};

// Confirm delete action
const confirmDelete = (id) => {
  if (confirm("Are you sure you want to delete this item?")) {
    handleDelete(id);
  }
};

// Handle deletion of a work experience entry
const handleDelete = async (id) => {
  try {
    await store.dispatch("work-ex/deleteWorkEx", id);
    Toast.success("Item deleted successfully!"); // Use toast from props
    await fetchWorkEx();
  } catch (err) {
    console.error("Error deleting item:", err);
    Toast.error("Failed to delete item."); // Use toast from props
  }
};

// Fetch work experience data on component mount
onMounted(fetchWorkEx);
</script>

<style scoped>
/* You can add your custom styles here */
</style>
