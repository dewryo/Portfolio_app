<template>
<div class="row">
    <div class="col-md-8 offset-md-5">
        <form @submit.prevent="sortPosts" class="text-right">
            <span class="sort-label">並べ替え：</span>
            <a href="#" class="sort-link" @click.prevent="sort_new_Posts">新着順</a>
            <a href="#" class="sort-link" @click.prevent="sort_like_Posts">いいね順</a>
        </form>
    </div>
</div>
<div class="col-md-8">
<div class="card-body">
  <hr>
</div>
</div>
</template>


<script setup>
import { ref } from 'vue';
import axios from 'axios';

const keyword = ref('');
const emit = defineEmits(); 




const sort_new_Posts = async () => {
  const response = await axios.get('/api/posts', {
    params: { orderBy: 'new' }
    
  });
  //親コンポーネントへデータを送る
  emit('update-posts',response.data);
};


const sort_like_Posts = async () => {
  const response = await axios.get('/api/posts', {
    params: { orderBy: 'like' }
    
  });
  //親コンポーネントへデータを送る
  emit('update-posts',response.data);
};
</script>

<style>
.sort-label {
    font-weight: bold;
    margin-right: 10px;
}

.sort-link {
    color: inherit; /* リンクの色を親要素と同じにする */
    text-decoration: none; /* 下線を消す */
    margin-right: 10px; /* 右のマージンを設定 */
    transition: color 0.3s; /* 色の変化にアニメーションを追加 */
}

.sort-link:hover {
    color: #007bff; /* ホバー時の色を変更 */
}
</style>