import { toast } from "vue3-toastify";

// Create a simple toast wrapper to export
export const Toast = {
  success: (message) => toast.success(message),
  error: (message) => toast.error(message),
};
