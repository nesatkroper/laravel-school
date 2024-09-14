import axios from "axios";
import { ref } from "vue";
import type { Student } from "../types/Student";
import { useApiStore } from "../stores/api";

const apiStore = useApiStore();
const api = apiStore.api.apiUrl;

// FOR GET ALL API DATA AND GET ONLY DATA
export const getData = async (uri: string, id?: number) => {
  try {
    const data = ref([]);
    const url = ref();

    id != undefined
      ? (url.value = `${api}/${uri}/${id}`)
      : (url.value = `${api}/${uri}`);

    await axios
      .get(url.value)
      .then((response) => {
        const res = response?.data ?? [];

        res.status == true ? res.data : [];
        data.value = res.data;
      })
      .catch((error) => {
        return error;
      });

    return data.value;
  } catch (error) {
    return error;
  }
};

//  FOR POST ONLY
export const createData = async (uri: string, req: Student) => {
  try {
    await axios({
      method: "POST",
      url: `${api}/${uri}`,
      withCredentials: false,
      headers: {
        "Content-Type": "multipart/form-data",
      },
      data: {
        fname: req.fname,
        lname: req.lname,
        gender: req.gender,
        dob: req.dob,
        email: req.email,
        phone: req.phone,
        address: req.address,
        enrollment: req.enrollment,
        cou_id: req.cou_id,
        status: req.status,
        isDelete: req.isDelete,
        photo: req.photo,
      },
    });
  } catch (error) {
    return error;
  }
};

// FOR DELETE ONLY RECODE
export const deleteData = async (uri: string, id: number) => {
  try {
    await axios({
      method: "delete",
      url: `${api}/${uri}/${id}`,
    }).catch((error) => {
      return error;
    });
  } catch (err) {
    return err;
  }
};
