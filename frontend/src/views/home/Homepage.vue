<template>
  <div class="card flex justify-center">
    <ToggleSwitch v-model="checked" />
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";

const checked = ref(false);
</script>
