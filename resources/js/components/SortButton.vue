<template>

            <div class="col-md-8">
                <form @submit.prevent="sortPosts">
                    <a href="#" @click.prevent="sort_new_Posts">新着順</a>
                    <a href="#" @click.prevent="sort_like_Posts">いいね順</a>
                </form>
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
