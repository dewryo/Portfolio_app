<template>
  <button @click="navigateToPostForm" class="new-post-button">
    <i class="fas fa-plus"></i> 新規投稿
  </button>
</template>

<script>
export default {
  methods: {
    navigateToPostForm() {
      this.$router.push({ name: 'post' });
    }
  }
};
</script>

<style>
.new-post-button {
  /* ボタンのスタイル設定 */
}
</style>
