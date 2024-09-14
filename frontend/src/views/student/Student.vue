<script setup lang="ts">
import { ref, onMounted } from "vue";
// import axios from "axios";
import type { Student } from "../../types/Student";
import { getData, deleteData } from "../../services/method";

// COMPONENT
import {
  Card,
  CardContent,
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
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "../../components/ui/dialog";
import { Input } from "../../components/ui/input";
import { Search } from "lucide-vue-next";
import { Label } from "../../components/ui/label";
import {
  Pagination,
  PaginationEllipsis,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev,
} from "../../components/ui/pagination";

// FIELDS
const student: any = ref<Student[]>([]);
const stu_load = ref(true);

// METHODS
const handleGet = (uri: string, stu_id?: number) => {
  const promise = new Promise((resolve) => {
    stu_id != undefined ? resolve(getData(uri, stu_id)) : resolve(getData(uri));
  });

  promise.then((data) => {
    student.value = data;
    stu_load.value = false;
  });
};

const handleDelete = (uri: string, stu_id: number) => {
  const promise = new Promise((resolve) => resolve(deleteData(uri, stu_id)));
  promise.then(() => handleGet("student"));
};

onMounted(() => {
  handleGet("student");
});
</script>

<template>
  <Card class="p-4 m-4 shadow-xl">
    <CardHeader>
      <CardTitle>Student</CardTitle>
      <Dialog>
        <div class="flex w-full justify-between">
          <DialogTrigger as-child>
            <Button class="w-[200px]">Add Student</Button>
          </DialogTrigger>
          <div class="relative w-full max-w-sm items-center">
            <Input
              id="search"
              type="text"
              placeholder="Search..."
              class="pl-10"
            />
            <span
              class="absolute start-0 inset-y-0 flex items-center justify-center px-2"
            >
              <Search class="size-6 text-muted-foreground" />
            </span>
          </div>
        </div>
        <DialogContent class="sm:max-w-[425px]">
          <DialogHeader>
            <DialogTitle>Add Student</DialogTitle>
          </DialogHeader>
          <div class="flex gap-3">
            <div class="grid w-full max-w-sm items-center gap-1.5">
              <Label for="email">Email</Label>
              <Input id="email" type="email" placeholder="Email" />
            </div>
            <div class="grid w-full max-w-sm items-center gap-1.5">
              <Label for="email">Email</Label>
              <Input id="email" type="email" placeholder="Email" />
            </div>
          </div>
          <DialogFooter>
            <Button type="submit"> Save changes </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
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
              <Button @click="handleDelete('student', row.stu_id)"
                >Delete</Button
              >
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </CardContent>
    <CardFooter>
      <Pagination
        v-slot="{ page }"
        :total="100"
        :sibling-count="1"
        show-edges
        :default-page="2"
      >
        <PaginationList v-slot="{ items }" class="flex items-center gap-1">
          <PaginationFirst />
          <PaginationPrev />

          <template v-for="(item, index) in items">
            <PaginationListItem
              v-if="item.type === 'page'"
              :key="index"
              :value="item.value"
              as-child
            >
              <Button
                class="w-10 h-10 p-0"
                :variant="item.value === page ? 'default' : 'outline'"
              >
                {{ item.value }}
              </Button>
            </PaginationListItem>
            <PaginationEllipsis v-else :key="item.type" :index="index" />
          </template>

          <PaginationNext />
          <PaginationLast />
        </PaginationList>
      </Pagination>
    </CardFooter>
  </Card>
</template>
