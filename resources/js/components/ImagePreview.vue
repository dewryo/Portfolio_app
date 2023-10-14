<template>
<div>
  <label for="image">画像:</label>
  <input type="file" id="image" name="image[]" accept="image/*" required @change="previewImages" multiple/>
  <div v-for="(imageData, index) in imageDatas" :key="index">
    <img :src="imageData" alt="Image Preview" />
    <button @click="removeImage(index)">削除</button>
  </div>
</div>
</template>

<script setup>
import { ref } from 'vue';

const imageDatas = ref([]); // 複数の画像を格納するための配列

const previewImages = (event) => {
  const input = event.target;
  

  if (input.files) {
    for (let i = 0; i < input.files.length; i++) {
      const reader = new FileReader();
      reader.onload = (e) => {
        imageDatas.value.push(e.target.result); // 画像データを配列に追加
      };
      reader.readAsDataURL(input.files[i]);
    }
  }
  
};

const removeImage = (index) => {
  // インデックスを指定して配列から画像を削除
  imageDatas.value.splice(index, 1);
};

</script>