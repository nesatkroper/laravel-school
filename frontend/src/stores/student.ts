// stores/userStore.js
import { defineStore } from "pinia";
import { useApiStore } from "./api";

const apiStore = useApiStore();
//@ts-ignore
const { apiUrl, domain } = apiStore.api;

export const useStudentStore = defineStore("userStore", {
  state: () => ({
    student: [],
    isLoading: false,
    error: null,
  }),

  getters: {
    totalStudent(state) {
      return state.student.length;
    },
  },

  actions: {
    async GetList() {
      this.isLoading = true;
      this.error = null;

      try {
        const response = await fetch("http://localhost:8000/api/student");
        if (!response.ok) {
          throw new Error("Failed to fetch users");
        }
        const data = (await response?.json()) ?? [];
        this.student = data; // Set the fetched data to state
      } catch (error) {
        this.error = error.message;
      } finally {
        this.isLoading = false;
      }
    },
  },
});
