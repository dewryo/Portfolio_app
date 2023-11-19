<template>
  <div class="col-md-8">
    <div class="card-body">
      <div @click="navigateToPost(post.id)" class="post-item">
        <h5 class="card-title">{{ truncate(post.title, 30) }}</h5>
        <div v-if="post.tags.length">
          <span v-for="tag in post.tags" :key="tag.id" class="badge badge-primary" style="background-color: rgb(92, 122, 255); color: white; margin-right: 8px;">
            {{ tag.name }}
          </span>
        </div>
        <div v-else>
          <p>No tag available</p>
        </div>
        <div style="height: 10px;"></div>
        <div v-if="post.images.length">
          
        <div style="width: 632px; height: 474px; overflow: hidden;">
          <img :src="post.images[0].file_path" 
              :alt="post.images[0].file_name" 
              class="img-fluid"
              style="min-width: 632px; min-height: 474px; object-fit: cover; object-position: center;">
        </div>

        </div>
        <div v-else>
          <p>No image available</p>
        </div>
        <p class="card-text">{{ truncate(post.content, 60) }}</p>
       </div>
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <LikeButton :post="post"/>
          <SavePostButton :postId="post.id" :is-saved="post.is_saved_by_user" />
        </div>
        <div class="d-flex align-items-center">
          <img :src="`/storage/profile_images/${post.user.profile_image || 'default.png'}`" alt="プロフィール画像" class="profile-image mx-3">
          <span>{{ post.user.name}}</span>
        </div>
      </div>
      <hr>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps } from 'vue';
import LikeButton from './LikeButton.vue';
import SavePostButton from './SavePostButton.vue';

// propsを定義
const props = defineProps({
  post: {
    type: Object,
    default: () => ({ tags: [], images: [], likes: [], is_liked_by_user: false, user:Object})
  }
});

function navigateToPost(postId) {
  window.location.href = `/posts/${postId}`;
}

const truncate = (text, maxLength) => {
  return text.length > maxLength ? text.substring(0, maxLength) + '…' : text;
};

</script>

<style scoped>
.post-item {
  /* 通常時のスタイル */
  transition: background-color 0.3s ease;
}

.post-item:hover {
  /* ホバー時のスタイル */
  background-color: #f5f5f5; /* 例: 薄い灰色に変更 */
  cursor: pointer; /* マウスカーソルを指の形に変更 */
}
</style>