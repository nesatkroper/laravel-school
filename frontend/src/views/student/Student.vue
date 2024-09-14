<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import type { Student } from "../../types/Student";
import { useApiStore } from "../../stores/api";

// COMPONENT
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "../../components/ui/card";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "../../components/ui/table";
import { Skeleton } from "../../components/ui/skeleton";
import { Button } from "../../components/ui/button";

// FIELDS
const apiStore = useApiStore();

//@ts-ignore
const { apiUrl, domain } = apiStore.api;

const student: any = ref<Student[]>([]);
const stu_load = ref(true);

// METHODS
const handleGetData = async (uri: string, id: number = 0) => {
  let endPoint = ref();
  id != 0
    ? (endPoint.value = `${apiUrl}/${uri}/${id}`)
    : (endPoint.value = `${apiUrl}/${uri}`);

  await axios
    .get(endPoint.value)
    .then((response) => {
      const res = response?.data ?? [];

      if (res.status == true) {
        student.value = res.data;
        stu_load.value = false;
        //
        console.log(student.value);
        console.log(stu_load.value);
      } else {
        stu_load.value = true;
        console.log("Error");
      }
    })
    .catch((error) => {
      console.error(error);
    });
};

onMounted(() => {
  handleGetData("student");
});
</script>

<template>
  <Card class="p-4 m-4 shadow-xl">
    <CardHeader>
      <CardTitle>Student</CardTitle>
      <Button class="w-[25%]">Add Student</Button>
    </CardHeader>
    <CardContent>
      <Table v-if="stu_load">
        <TableBody>
          <TableRow>
            <TableCell>
              <div class="flex items-center space-x-4">
                <Skeleton class="h-12 w-12 rounded-full" />
                <div class="space-y-2">
                  <Skeleton class="h-4 w-[250px]" />
                  <Skeleton class="h-4 w-[200px]" />
                </div>
              </div>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
      <Table v-else>
        <TableCaption>A list of your student.</TableCaption>
        <TableHeader>
          <TableRow>
            <TableHead> No </TableHead>
            <TableHead> Photo </TableHead>
            <TableHead>First Name</TableHead>
            <TableHead>Last Name</TableHead>
            <TableHead>Gender</TableHead>
            <TableHead>DOB</TableHead>
            <TableHead>Enrollment</TableHead>
            <TableHead>Phone</TableHead>
            <TableHead>Email</TableHead>
            <TableHead>Address</TableHead>
            <TableHead> Action </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="(row, index) in student" :key="index">
            <TableCell> {{ index + 1 }} </TableCell>
            <TableCell> {{ index + 1 }} </TableCell>
            <TableCell>{{ row.fname }}</TableCell>
            <TableCell>{{ row.lname }} </TableCell>
            <TableCell> {{ row.gender }} </TableCell>
            <TableCell> {{ row.dob }} </TableCell>
            <TableCell> {{ row.enrollment }} </TableCell>
            <TableCell> {{ row.phone }} </TableCell>
            <TableCell> {{ row.email }} </TableCell>
            <TableCell> {{ row.address }} </TableCell>
            <TableCell class="flex flex-row gap-2 w-[100px]">
              <Button>Edit</Button>
              <Button>Delete</Button>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </CardContent>
    <CardFooter> Card Footer </CardFooter>
  </Card>
</template>
