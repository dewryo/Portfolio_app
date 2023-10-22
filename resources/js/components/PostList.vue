<template>
  <div class="container">
    <PostCard v-for="post in posts" :key="post.id" :post="post" />
  </div>
</template>

<script>
import axios from 'axios';
import PostCard from './PostCard.vue';

export default {
  components: {
    PostCard
  },
  data() {
    return {
      posts: [],
      nextPageUrl: null
    };
  },
  mounted() {
    this.fetchPosts();
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    fetchPosts() {
      let url = this.nextPageUrl || '/api/posts';
      axios.get(url)
        .then(response => {
          this.posts = [...this.posts, ...response.data.posts];
          this.nextPageUrl = response.data.next_page_url;
        })
        .catch(error => {
          console.error('An error occurred while fetching data: ', error);
        });
    },
    handleScroll() {
      const totalHeight = document.documentElement.scrollHeight;
      const scrolledHeight = window.scrollY + window.innerHeight;

      if (scrolledHeight >= totalHeight) {
        this.fetchPosts();
      }
    },
  }
}
</script>
