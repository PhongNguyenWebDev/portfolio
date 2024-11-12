<template>
  <button
    :class="[
      'text-sm cursor-pointer rounded-md font-medium transition-colors duration-300',
      colorClasses,
    ]"
    @click="onClick"
  >
    <slot />
  </button>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, computed } from "vue";

const props = defineProps({
  color: {
    type: String,
    default: "cyan", // Default color
  },
});

const emits = defineEmits(["click"]);

const colorClasses = computed(() => {
  switch (props.color) {
    case "teal":
      return "text-teal-400 hover:text-teal-600";
    case "red":
      return "text-red-400 hover:text-red-600";
    case "blue":
      return "text-blue-400 hover:text-blue-600";
    case "green":
      return "text-green-400 hover:text-green-600";
    case "yellow":
      return "text-yellow-400 hover:text-yellow-600";
    case "purple":
      return "text-purple-400 hover:text-purple-600";
    default:
      return "text-cyan-400 hover:text-cyan-600"; // Default color
  }
});

const onClick = () => {
  emits("click");
};
</script>

<style scoped>
/* Add any additional styling if necessary */
</style>
