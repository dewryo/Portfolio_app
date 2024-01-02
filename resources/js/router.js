// router.js
import { createRouter, createWebHistory } from 'vue-router';
import PostList from './components/PostList.vue';

const routes = [
  { path: '/', component: PostList },
  {
    path: '/posts/form',
    name: 'PostForm',
    component: PostForm,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
