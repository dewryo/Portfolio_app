<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-4 col-md-4">
        <div class="container  sticky ">

        <!-- NewPostButton Component -->
        <NewPostButton />

        <!-- Search Form Column -->
         <SearchForm @update-keyword="searchKeyword = $event" @update-posts="handleUpdatePosts"/>
        
        <!-- Tag Selector Column -->
        <PostTagSelector :selectedTags="selectedTags" @tag-selected="addTag" @tag-deselected="removeTag"/>
        </div>
      </div>

      <!-- Content Column -->
      <div class="col-8 col-md-8">
        <SortButton :selectedTags="selectedTags" :searchKeyword="searchKeyword" @update-posts="handleUpdatePosts"/>
        <PostCard v-for="post in posts" :key="post.id" :post="post" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import axios from 'axios';
import PostCard from './PostCard.vue';
import PostTagSelector from './PostTagSelector.vue';
import SearchForm from './SearchForm.vue';
import SortButton from './SortButton.vue'
import NewPostButton from './NewPostButton.vue';
import _ from 'lodash';

const posts = ref([]);
const nextPageUrl = ref(null);
const selectedTags = ref([]);
const searchKeyword = ref('');
const isLoading = ref(false);

const fetchPosts = async () => {
  if (isLoading.value) return;
  isLoading.value = true;

  let base_url = '/api/posts';
  if (selectedTags.value.length > 0) {
    const tagsQuery = selectedTags.value.map(tag => `tag[]=${tag}`).join('&');
    base_url += `?${tagsQuery}`;
  }

  let url = nextPageUrl.value || base_url;

  try {
    const response = await axios.get(url);
    posts.value = [...posts.value, ...response.data.posts];
    nextPageUrl.value = response.data.next_page_url;
  } catch (error) {
    console.error('An error occurred while fetching data: ', error);
  } finally {
    isLoading.value = false;
  }
};

const fetchPostsDebounced = _.debounce(fetchPosts, 100);

const handleScroll = () => {
  if (!nextPageUrl.value) return;

  const totalHeight = document.documentElement.scrollHeight;
  const scrolledHeight = window.scrollY + window.innerHeight;
  const threshold = 400;

  if (scrolledHeight >= totalHeight - threshold) {
    fetchPosts();
  }
};

const handleUpdatePosts = (newData) => {
  
  posts.value = newData.posts;
  nextPageUrl.value = newData.next_page_url;
};

const addTag = (tag) => {
  if (!selectedTags.value.includes(tag)) {
    posts.value = [];
    nextPageUrl.value = null;
    selectedTags.value.push(tag);
    fetchPosts();
  }
};

const removeTag = (tag) => {
  const index = selectedTags.value.indexOf(tag);
  if (index !== -1) {
    posts.value = [];
    nextPageUrl.value = null;
    selectedTags.value.splice(index, 1);
    fetchPosts();
  }
};

onMounted(() => {
  fetchPosts();
  window.addEventListener('scroll', handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>
