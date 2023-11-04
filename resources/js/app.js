import './bootstrap.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../css/app.css';
import { createApp } from 'vue';
import ImagePreview from './components/ImagePreview.vue';
import TagSelector from './components/TagSelector.vue';
import PostList from './components/PostList.vue'
import '@fortawesome/fontawesome-free/css/all.css';

const app = createApp({});

app.component('image-preview', ImagePreview);
app.component('tag-selector', TagSelector);
app.component('post-list', PostList);


app.mount('#app');