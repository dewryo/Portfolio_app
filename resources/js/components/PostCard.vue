<template>
  <div class="card mb-4 mx-auto" style="max-width: 50%;">
    <div class="card-body">
      <h5 class="card-title">{{ post.title }}</h5>
      <div v-if="post.tags.length">
        <span v-for="tag in post.tags" :key="tag.id" class="badge badge-primary" style="background-color: rgb(92, 122, 255); color: white; margin-right: 8px;">
          {{ tag.name }}
        </span>
      </div>
      <div v-else>
        <p>No tag available</p>
      </div>
      <div v-if="post.images.length">
        <img :src="post.images[0].file_path" :alt="post.images[0].file_name" class="img-fluid" style="max-height: 500px; width: auto;">
      </div>
      <div v-else>
        <p>No image available</p>
      </div>
      <p class="card-text">{{ post.content }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    post: Object
  }
}
</script>
