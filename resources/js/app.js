import './bootstrap.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '../css/app.css';
import { createApp } from 'vue';
import ImagePreview from './components/ImagePreview.vue';
import TagSelector from './components/TagSelector.vue';
import PostList from './components/PostList.vue'
import ImageGallery from './components/ImageGallery.vue'
import '@fortawesome/fontawesome-free/css/all.css';

import CommentsList from './components/CommentsList.vue';
import SavePostButton from './components/SavePostButton.vue';

import router from './router'; // Router設定をインポート
const app = createApp({});

app.component('image-preview', ImagePreview);
app.component('tag-selector', TagSelector);
app.component('post-list', PostList);
app.component('image-gallery', ImageGallery);

app.component('comments-list', CommentsList);
app.component('save-postbutton', SavePostButton);

app.use(router); // Routerをアプリケーションに適用
app.mount('#app');