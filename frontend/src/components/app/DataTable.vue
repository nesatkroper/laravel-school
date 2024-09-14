<script>
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";

export default {
  props: {
    rows: Array,
    columns: Array,
    pageSize: {
      type: Number,
      default: 10,
    },
  },
  data() {
    return {
      searchQuery: "",
      currentPage: 1,
      sortKey: "",
      sortOrder: "asc",
    };
  },
  computed: {
    filteredRows() {
      const lowerCaseQuery = this.searchQuery.toLowerCase();
      return this.rows.filter((row) =>
        Object.values(row).some((val) =>
          val.toString().toLowerCase().includes(lowerCaseQuery)
        )
      );
    },
    sortedRows() {
      if (!this.sortKey) return this.filteredRows;

      return [...this.filteredRows].sort((a, b) => {
        const result = a[this.sortKey] > b[this.sortKey] ? 1 : -1;
        return this.sortOrder === "asc" ? result : -result;
      });
    },
    paginatedRows() {
      const start = (this.currentPage - 1) * this.pageSize;
      return this.sortedRows.slice(start, start + this.pageSize);
    },
    totalPages() {
      return Math.ceil(this.filteredRows.length / this.pageSize);
    },
  },
  methods: {
    sortColumn(column) {
      if (this.sortKey === column.key) {
        this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
      } else {
        this.sortKey = column.key;
        this.sortOrder = "asc";
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
  },
};
</script>

<template>
  <div>
    <div class="flex justify-between items-center py-4">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search..."
        class="border rounded-md px-4 py-2"
      />
    </div>
    <Table>
      <TableCaption>A list of your recent invoices.</TableCaption>
      <TableHeader>
        <TableRow>
          <TableHead class="w-[100px]"> Invoice </TableHead>
          <TableHead>Status</TableHead>
          <TableHead>Method</TableHead>
          <TableHead class="text-right"> Amount </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow>
          <TableCell class="font-medium"> INV001 </TableCell>
          <TableCell>Paid</TableCell>
          <TableCell>Credit Card</TableCell>
          <TableCell class="text-right"> .00 </TableCell>
        </TableRow>
      </TableBody>
    </Table>

    <Table>
      <TableHeader>
        <TableRow>
          <TableHead
            v-for="(column, index) in columns"
            :key="index"
            @click="sortColumn(column)"
          >
            {{ column.label }}
            <span v-if="sortKey === column.key">
              {{ sortOrder === "asc" ? "↑" : "↓" }}
            </span>
          </TableHead>
        </TableRow>
      </TableHeader>

      <TableBody>
        <TableRow
          v-for="(row, index) in paginatedRows"
          :key="index"
          class="text-center"
        >
          <TableCell v-for="column in columns" :key="column.key">
            {{ row[column.key] }}
          </TableCell>
        </TableRow>
        <TableRow v-if="filteredRows.length === 0">
          <TableCell colspan="100%" class="text-center py-4"
            >No data found</TableCell
          >
        </TableRow>
      </TableBody>
    </Table>

    <!-- Pagination Controls -->
    <div class="flex justify-between items-center mt-4">
      <button
        @click="previousPage"
        :disabled="currentPage === 1"
        class="bg-gray-500 text-white px-4 py-2 rounded-md"
      >
        Previous
      </button>

      <span>Page {{ currentPage }} of {{ totalPages }}</span>

      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="bg-gray-500 text-white px-4 py-2 rounded-md"
      >
        Next
      </button>
    </div>
  </div>
</template>
