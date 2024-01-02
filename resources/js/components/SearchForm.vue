<template>
    
        <div class="row justify-content-end">
            <div class="col-md-6">
              <div style="height: 20px;"></div>
              <h6 class="mb-3">キーワード</h6>
                <form @submit.prevent="searchPosts">
                    <input type="search" v-model="keyword" class="form-control" placeholder="検索...">
                </form>
            </div>
        </div>
    
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const keyword = ref('');
const emit = defineEmits(); 

const searchPosts = async () => {
  const response = await axios.get('/api/posts', {
    params: { keyword: keyword.value }
    
  });
  //親コンポーネントへデータを送る
  emit('update-keyword', keyword.value);
  emit('update-posts',response.data);
  
};
</script>
