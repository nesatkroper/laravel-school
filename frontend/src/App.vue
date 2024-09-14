<script setup lang="ts">
// @ts-ignore
import Header from "./components/app/Header.vue";
// @ts-ignore
import Footer from "./components/app/Footer.vue";
// @ts-ignore
import Sidebar from "./components/app/Sidebar.vue";
</script>

<template>
  <div class="overflow-auto no-scrollbar">
    <Header />
    <div class="flex flex-col">
      <Sidebar />
      <div class="my-16 xl:ms-64 ms-0">
        <router-view />
      </div>
    </div>
    <Footer />
  </div>
</template>
