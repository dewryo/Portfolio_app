<template>
  <div>
    <!-- 画像ギャラリー -->
    <div class="row mt-4 mb-3">
     
    <div v-for="image in images" :key="image.id" class="col-6 col-md-4 col-lg-3 mb-3">
      <img :src="image.url" :alt="image.name || 'Post Image'" class="img-fluid" @click="openModal(image)" />
    </div>
    </div>

    <!-- 画像モーダルウィンドウ -->
    <image-modal
      v-if="isModalOpen"
      :image="selectedImage"
      :isModalOpen="isModalOpen"
      @close-modal="isModalOpen = false"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ImageModal from './ImageModal.vue';

const props = defineProps({
  images: Array
});
const selectedImage = ref(null);
const isModalOpen = ref(false);

const openModal = (image) => {
  selectedImage.value = image;
  isModalOpen.value = true;
};
</script>
