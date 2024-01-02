<template>
          <div class="row justify-content-end">
            <div class="col-md-6">
              <div style="height: 10x;"></div>
                <button @click="navigateToPostForm" class="new-post-button">
                    <font-awesome-icon :icon="['far', 'square-plus']" /> 投稿
                </button>
            </div>
        </div>
    
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
  background: #f0f0f0; /* 薄い灰色の背景色 */
  border: none; /* 枠線を消去 */
  color: inherit; /* 親要素から色を継承 */
  padding: 10px 20px; /* 内側の余白 */
  margin: 0; /* 外側の余白をなくす */
  font: inherit; /* 親要素からフォント設定を継承 */
  cursor: pointer; /* カーソルをポインターに */
  outline: inherit; /* フォーカス時の枠線を親要素から継承 */
  border-radius: 20px; /* 角を丸くする */
  transition: background-color 0.3s; /* 背景色の変化にアニメーションを追加 */
}

.new-post-button:hover {
  background-color: #e0e0e0; /* ホバー時の背景色を少し濃い灰色に */
}

</style>
