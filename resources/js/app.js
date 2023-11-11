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

const app = createApp({});

app.component('image-preview', ImagePreview);
app.component('tag-selector', TagSelector);
app.component('post-list', PostList);
app.component('image-gallery', ImageGallery);

app.mount('#app');