<template>
  <div class="col-md-7">
    <!-- 以下のコンテンツは変更なし -->
    <div class="card-body">
      <div @click="navigateToPost(post.id)" class="post-item">
        <h5 class="card-title">{{ truncate(post.title, 30) }}</h5>
        <!-- タグの表示部分 -->
        <div v-if="post.tags.length">
          <span v-for="tag in post.tags" :key="tag.id" class="badge badge-primary" style="background-color: rgb(92, 122, 255); color: white; margin-right: 8px;">
            {{ tag.name }}
          </span>
        </div>
        <div v-else>
          <p>No tag available</p>
        </div>

        <!-- 画像表示部分をS3のバケット名に合わせて更新 -->
        <div v-if="post.images.length" style="display: flex; justify-content: center; align-items: center; height: 200px;">
          <img :src="post.images[0].file_path" :alt="post.images[0].file_name" class="img-fluid" style="max-height: 100%; max-width: 100%;">
          
        </div>
        <div v-else>
          <p>No image available</p>
        </div>

        <p class="card-text">{{ truncate(post.content, 60) }}</p>
      </div>

      <!-- ユーザーと関連する部分は変更なし -->
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <LikeButton :post="post"/>
          <SavePostButton :postId="post.id" :is-saved="post.is_saved_by_user" />
        </div>
        <div @click="navigateToUser(post.user.id)" class="post-item">
          <div class="d-flex align-items-center">
            <div>
              <img v-if="post.user.profile_image" 
                  :src="`/storage/profile_images/${post.user.profile_image}`" 
                  alt="プロフィール画像" 
                  class="profile-image mx-3">
              <i v-else 
                class="fas fa-user-circle fa-2x mx-3"></i>
            </div>
            <span>{{ post.user.name}}</span>
          </div>
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

// propsと関数を定義
const props = defineProps({
  post: {
    type: Object,
    default: () => ({ tags: [], images: [], likes: [], is_liked_by_user: false, user: {} })
  }
});

function navigateToPost(postId) {
  window.location.href = `/posts/${postId}`;
}

function navigateToUser(userId) {
  window.location.href = `posts/users/${userId}`;
}

const truncate = (text, maxLength) => {
  return text.length > maxLength ? text.substring(0, maxLength) + '…' : text;
};

// S3の画像URLを生成する関数を追加
function getS3ImageUrl(filePath) {
  const baseUrl = 'https://eduforum-bucket.s3.ap-northeast-1.amazonaws.com/';
  // ファイルパスからファイル名のみを抽出し、エンコードする
  const parts = filePath.split('/');
  const fileName = parts.pop();
  const encodedFileName = encodeURIComponent(fileName);
  const fullPath = parts.join('/') + '/' + encodedFileName;
  return baseUrl + fullPath;
}


</script>

<style scoped>
.post-item {
  transition: background-color 0.3s ease;
}

.post-item:hover {
  background-color: #f5f5f5;
  cursor: pointer;
}
</style>
