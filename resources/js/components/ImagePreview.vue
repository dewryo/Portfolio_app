<template>
<div>
  <label for="image">画像:</label>
  <input type="file" id="image" name="image[]" accept="image/*" required @change="previewImages" multiple/>
  <div v-for="(imageData, index) in imageDatas" :key="index">
    <img :src="imageData" alt="Image Preview" />
  </div>
</div>
</template>

<script setup>
import { ref } from 'vue';

const imageDatas = ref([]); // 複数の画像を格納するための配列

const previewImages = (event) => {
  const input = event.target;
  

  if (input.files) {
    imageDatas.value = [];
    for (let i = 0; i < input.files.length; i++) {
      const reader = new FileReader();
      reader.onload = (e) => {
        imageDatas.value.push(e.target.result); // 画像データを配列に追加
      };
      reader.readAsDataURL(input.files[i]);
    }
  }
  
};


</script>