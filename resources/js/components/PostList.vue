<template>
<div class="container-fluid">
    <div class="row">

      <!-- Tag Selector Column -->
      <div class="col-3 col-md-3">
        <PostTagSelector :selectedTags="selectedTags" @tag-selected="addTag" @tag-deselected="removeTag"/>
      </div>

      <!-- Content Column -->
      <div class="col-9 col-md-9">
        <PostCard v-for="post in posts" :key="post.id" :post="post" />
      </div>

    </div>
</div>
</template>

<script>
import axios from 'axios';
import PostCard from './PostCard.vue';
import PostTagSelector from './PostTagSelector.vue';
import _ from 'lodash';

export default {
  components: {
    PostCard,
    PostTagSelector
  },
  data() {
    return {
      posts: [],
      nextPageUrl: null,
      selectedTags: [],
      isLoading: false,
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
      if (this.isLoading) return;
      this.isLoading = true;
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
          this.isLoading = false;
        })
        .catch(error => {
          console.error('An error occurred while fetching data: ', error);
          this.isLoading = false;
        });
    },

    fetchPostsDebounced: _.debounce(function() {
         this.fetchPosts();
       }, 300),  // 300ミリ秒の遅延を持たせる

    handleScroll() {
      if (!this.nextPageUrl) return;
        
      const totalHeight = document.documentElement.scrollHeight;
      const scrolledHeight = window.scrollY + window.innerHeight;
      const Threshold = 400;

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
        this.fetchPostsDebounced();  // タグが追加されたら再度フェッチ
      }
    },
    removeTag(tag) {
      const index = this.selectedTags.indexOf(tag);
      if (index !== -1) {
        this.posts = [];
        this.nextPageUrl = null;
        this.selectedTags.splice(index, 1);  // ここを修正
        this.updateURL();
        this.fetchPostsDebounced();  // タグが削除されたら再度フェッチ
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
