import { defineStore } from "pinia";
import { ref } from "vue";

export const useApiStore = defineStore("api", () => {
  const api = ref({
    domain: "http://localhost:8000",
    apiUrl: "http://localhost:8000/api",
  });

  return {
    api,
  };
});
