<script setup lang="ts">
import { ref, onMounted } from "vue";
// import axios from "axios";
import type { Student } from "../../types/Student";
import {
  getData,
  createData,
  updateData,
  destroyData,
} from "../../services/student.controller";

// COMPONENT
// @ts-ignore
import Pagination from "./Pagination.vue";
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
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "../../components/ui/dialog";
import { Input } from "../../components/ui/input";
import { Search } from "lucide-vue-next";
import { Label } from "../../components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "../../components/ui/select";
import { Textarea } from "../../components/ui/textarea";
import {
  DateFormatter,
  type DateValue,
  getLocalTimeZone,
} from "@internationalized/date";
import { Calendar as CalendarIcon } from "lucide-vue-next";
import { Calendar } from "../..//components/ui/calendar";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "../../components/ui/popover";
import { cn } from "../../lib/utils";
import { resolve } from "path";

const df = new DateFormatter("en-US", {
  dateStyle: "long",
});

// FIELDS
const student: any = ref<Student[]>([]);
const create: any = ref<Student[]>([]);
const update: any = ref<Student[]>([]);
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

const handleCreate = (uri: string) => {
  const promise = new Promise((resolve) =>
    resolve(createData(uri, create.value))
  );
  promise.then(() => {
    handleGet("student");
    create.value = [];
  });
};

const handleUpdate = (uri: string, id: number) => {
  const promise = new Promise((resolve) =>
    resolve(updateData(uri, update.value, id))
  );
  promise.then(() => handleGet("student"));
};

const handleDelete = (uri: string, stu_id: number) => {
  const promise = new Promise((resolve) => resolve(destroyData(uri, stu_id)));
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
        <DialogContent class="sm:max-w-[575px]">
          <form @submit.prevent="handleCreate('student')">
            <DialogHeader>
              <DialogTitle>Add Student</DialogTitle>
            </DialogHeader>
            <div class="flex gap-3 my-3">
              <div class="grid w-full max-w-sm items-center gap-1.5">
                <Label for="email">First Name</Label>
                <Input
                  v-model="create.fname"
                  type="text"
                  placeholder="First Name"
                />
              </div>
              <div class="grid w-full max-w-sm items-center gap-1.5">
                <Label for="email">Last Name</Label>
                <Input
                  v-model="create.lname"
                  type="text"
                  placeholder="Last Name"
                />
              </div>
            </div>
            <div class="flex gap-3 my-3">
              <div class="grid w-full max-w-sm items-center gap-1.5">
                <Label for="email">Gender</Label>
                <Select v-model="create.gender">
                  <SelectTrigger>
                    <SelectValue placeholder="Select Gender" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="male"> Male </SelectItem>
                      <SelectItem value="female"> Female </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>
              <div class="grid w-full max-w-sm items-center gap-1.5">
                <Label for="email">Course</Label>
                <Select v-model="create.cou_id">
                  <SelectTrigger>
                    <SelectValue placeholder="Select Course" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="1"> Web Application </SelectItem>
                      <SelectItem value="2"> Mobile Application </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>
            </div>
            <div class="flex gap-3 my-3">
              <div class="grid w-full max-w-sm items-center gap-1.5">
                <Label for="email">Date of Birth</Label>
                <Popover>
                  <PopoverTrigger as-child>
                    <Button
                      variant="outline"
                      :class="
                        cn(
                          ' justify-start text-left font-normal',
                          !create.dob && 'text-muted-foreground'
                        )
                      "
                    >
                      <CalendarIcon class="mr-2 h-4 w-4" />
                      {{
                        create.dob
                          ? df.format(create.dob.toDate(getLocalTimeZone()))
                          : "Pick a date"
                      }}
                    </Button>
                  </PopoverTrigger>
                  <PopoverContent class="w-auto p-0">
                    <Calendar v-model="create.dob" initial-focus />
                  </PopoverContent>
                </Popover>
              </div>
              <div class="grid w-full max-w-sm items-center gap-1.5">
                <Label for="email">Enrollment</Label>
                <Popover>
                  <PopoverTrigger as-child>
                    <Button
                      variant="outline"
                      :class="
                        cn(
                          ' justify-start text-left font-normal',
                          !create.enrollment && 'text-muted-foreground'
                        )
                      "
                    >
                      <CalendarIcon class="mr-2 h-4 w-4" />
                      {{
                        create.enrollment
                          ? df.format(
                              create.enrollment.toDate(getLocalTimeZone())
                            )
                          : "Pick a date"
                      }}
                    </Button>
                  </PopoverTrigger>
                  <PopoverContent class="w-auto p-0">
                    <Calendar v-model="create.enrollment" initial-focus />
                  </PopoverContent>
                </Popover>
              </div>
            </div>
            <div class="flex gap-3 my-3">
              <div class="grid w-full max-w-sm items-center gap-1.5">
                <Label for="email">Phone Number</Label>
                <Input
                  v-model="create.phone"
                  type="text"
                  placeholder="Phone Number"
                />
              </div>
              <div class="grid w-full max-w-sm items-center gap-1.5">
                <Label for="email">Email</Label>
                <Input
                  v-model="create.email"
                  type="email"
                  placeholder="Email"
                />
              </div>
            </div>
            <div class="flex gap-3 flex-col my-3">
              <Label for="email">Address</Label>
              <Textarea
                v-model="create.address"
                class="w-full"
                placeholder="Type your address here."
              />
            </div>
            <Button type="submit"> Save changes </Button>
          </form>
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
      <Table v-else class="">
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

    <!-- <CardFooter>
      <Pagination />
    </CardFooter> -->
  </Card>
</template>
