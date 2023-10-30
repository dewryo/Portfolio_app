<template>
<div class="col-md-9">
  <form @submit.prevent="searchPosts">
    <input type="search" v-model="keyword" class="form-control" placeholder="検索...">
  </form>
</div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const keyword = ref('');

const searchPosts = async () => {
  const response = await axios.get('/api/posts', {
    params: { keyword: keyword.value }
    
  });
  console.log(response);

};
</script>
