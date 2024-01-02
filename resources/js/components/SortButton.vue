<template>
<div class="row">
    <div class="col-md-7 offset-md-4">
        <form  class="text-right">
            
            <a href="#" class="sort-link" @click.prevent="sort_new_Posts">新着順</a>
            <a href="#" class="sort-link" @click.prevent="sort_old_Posts">古い順</a>
            <a href="#" class="sort-link" @click.prevent="sort_like_Posts">いいね順</a>
        </form>
    </div>
</div>
<div class="col-md-7">
<div class="card-body">
  <hr>
</div>
</div>
</template>


<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  selectedTags: Array,
  searchKeyword: String
});

const emit = defineEmits(['update-posts']);




const sort_new_Posts = async () => {
  const response = await axios.get('/api/posts', {
    params: { orderBy: 'new' ,
              tag: props.selectedTags,
              keyword: props.searchKeyword
              }
    
  });
  //親コンポーネントへデータを送る
  emit('update-posts',response.data);
};

const sort_old_Posts = async () => {
  const response = await axios.get('/api/posts', {
    params: { orderBy: 'old' ,
              tag: props.selectedTags,
              keyword: props.searchKeyword
              }
    
  });
  //親コンポーネントへデータを送る
  emit('update-posts',response.data);
};


const sort_like_Posts = async () => {
  const response = await axios.get('/api/posts', {
    params: { orderBy: 'like',
              tag: props.selectedTags,
              keyword: props.searchKeyword
              }
    
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