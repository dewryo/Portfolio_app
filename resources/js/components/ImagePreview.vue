<template>
<div class="mb-3">
  <label for="image" class="form-label">画像</label>
  <input type="file" id="image" name="image[]" accept="image/*"  @change="previewImages" multiple class="form-control"/>
  <div class="mt-3 d-flex flex-wrap">
    <div v-for="(imageData, index) in imageDatas" :key="index" class="me-2 mb-2">
      <img :src="imageData" alt="Image Preview" class="image-preview rounded" />
    </div>
  </div>
</div>
</template>

<script setup>
import { ref } from 'vue';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
 initialImage: {
    type: Array,
    default: () => ([]), // 配列のデフォルト値は、関数で空配列を返すようにします。
  }
  });

// `url`プロパティだけを取り出して新しい配列を作成します。
const imageDatas = ref(props.initialImage.map(image => image.url));


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


<style>
.image-preview {
  max-width: 200px;
  max-height: 200px;
  object-fit: contain;
  border: 1px solid #ccc;
}
</style>