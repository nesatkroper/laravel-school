import axios from "axios";
import { useApiStore } from "../stores/api";

const apiStore = useApiStore();
const api = apiStore.api.apiUrl;

export function getData(uri: string) {
  try {
    axios
      .get(`${api}/${uri}`)
      .then((response) => {
        const res = response?.data ?? [];
        res.status == true ? res.data : [];
        return res.data;
      })
      .catch((error) => {
        return error;
      });
  } catch (error) {
    return error;
  }
}

// function fetchDataFromAPI(apiUrl) {
//   return fetch(apiUrl)
//     .then((response) => {
//       // Check if the response is OK (status code 200-299)
//       if (!response.ok) {
//         throw new Error(`HTTP error! status: ${response.status}`);
//       }
//       // Parse and return the JSON data
//       return response.json();
//     })
//     .catch((error) => {
//       // Handle any errors
//       console.error("Error fetching data:", error);
//       throw error; // Re-throw error so it can be handled elsewhere
//     });
// }
