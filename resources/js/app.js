import './bootstrap.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../css/app.css';
import { createApp } from 'vue';
import ImagePreview from './components/ImagePreview.vue';
import TagSelector from './components/TagSelector.vue';

const app = createApp({});

app.component('image-preview', ImagePreview);
app.component('tag-selector', TagSelector);

app.mount('#app');