<template>
  <button @click="navigateToPostForm" class="new-post-button">
    <i class="fa-regular fa-square-plus"></i>新規投稿
  </button>

  <!-- 以下のBootstrap モーダルを追加 -->
  <div v-if="errorMessage" class="modal d-block" tabindex="-1" role="dialog" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" @click="clearError">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>{{ errorMessage }}</p>
          <div class="text-center">
            <a class="btn btn-primary" href="/login">ログイン</a>
            <a class="btn btn-secondary" href="/register">新規登録</a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="clearError">閉じる</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const errorMessage = ref('');
    const router = useRouter();

    const navigateToPostForm = async () => {
      try {
        // ログインチェックの仮実装、本番ではAPIを使用する
        const response = await axios.get('/api/check-login');
        if (response.data.loggedIn) {
          router.push({ name: 'post' });
        } else {
          throw new Error('ログインが必要です');
        }
      } catch (error) {
        console.error('操作に失敗しました。', error);
        // エラーレスポンスからエラーメッセージを取得して設定
        errorMessage.value = error.response && error.response.data.message ? error.response.data.message : 'ログインすると「新規投稿」することができます';
      }
    };

    const clearError = () => {
      errorMessage.value = '';
    };

    return {
      navigateToPostForm,
      errorMessage,
      clearError
    };
  },
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
