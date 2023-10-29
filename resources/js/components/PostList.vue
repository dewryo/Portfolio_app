<template>
  <div class="container">
    <PostTagSelector :selectedTags="selectedTags" @tag-selected="addTag"/>
    <PostCard v-for="post in posts" :key="post.id" :post="post" />
  </div>
</template>

<script>
import axios from 'axios';
import PostCard from './PostCard.vue';
import PostTagSelector from './PostTagSelector.vue';

export default {
  components: {
    PostCard,
    PostTagSelector
  },
  data() {
    return {
      posts: [],
      nextPageUrl: null,
      selectedTags: []
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
      let base_url = '/api/posts';
      if(this.selectedTags.length > 0){
        const tagsQuery = this.selectedTags.map(tag => `tag[]=${tag}`).join('&');
        base_url += `?${tagsQuery}`;
      }
      let url = this.nextPageUrl || base_url;
      console.log(url);
      axios.get(url)
        .then(response => {
          this.posts = [...this.posts, ...response.data.posts];
          console.log(this.posts);
          this.nextPageUrl = response.data.next_page_url;
          console.log(this.nextPageUrl);
        })
        .catch(error => {
          console.error('An error occurred while fetching data: ', error);
        });
    },
    handleScroll() {
      if (!this.nextPageUrl) return;
        
      const totalHeight = document.documentElement.scrollHeight;
      const scrolledHeight = window.scrollY + window.innerHeight;
      const Threshold = 200;

      if (scrolledHeight >= totalHeight - Threshold) {
        this.fetchPosts();
      }
    },
    addTag(tag) {
      if (!this.selectedTags.includes(tag)) {
        this.posts = [];
        this.nextPageUrl = null;
        this.selectedTags.push(tag);
        this.updateURL(); 
        this.fetchPosts();  // タグが追加されたら再度フェッチ
      }
    },
    updateURL() {
      const newQuery = this.selectedTags.join(',');
      const currentPath = window.location.pathname;
      const newURL = `${currentPath}?tags=${newQuery}`;
      window.history.pushState({}, '', newURL);
},
  }
}
</script>
