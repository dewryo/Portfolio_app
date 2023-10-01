<template>
  <div>
    <label for="image">画像:</label>
    <input type="file" id="image" name="image" accept="image/*" required @change="previewImage" />
    <img v-if="imageData" :src="imageData" alt="Image Preview" />
  </div>
</template>

<script setup>
import { ref } from 'vue';

const imageData = ref(null);

const previewImage = (event) => {
  const input = event.target;
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = (e) => {
      imageData.value = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
};
</script>