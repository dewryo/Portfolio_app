<template>
  <form @submit.prevent="submitComment" class="mb-3">
    <div class="form-group">
      <textarea v-model="commentBody" class="form-control" placeholder="コメントを入力" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">コメントする</button>
  </form>
          <!-- Bootstrap モーダル -->
    <div v-if="errorMessage" class="modal d-block" tabindex="-1" role="dialog" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body d-flex flex-column align-items-center justify-content-center">
                    <p>{{ errorMessage }}</p>
                    <div class="d-flex flex-column align-items-stretch">
                        <a :class="['btn', 'btn-outline-primary', 'btn-sm', 'mb-2', 'w-200']" href="/guest-login">ゲストでログイン</a>
                        <a :class="['btn', 'btn-outline-primary', 'btn-sm', 'mb-2', 'w-200']" href="/login">ログイン</a>
                         <a :class="['btn', 'btn-outline-primary', 'btn-sm', 'w-200']" href="/register">新規登録</a>
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

export default {
  props: {
    postId: Number,
  },
  emits: ['comment-posted'],
  setup(props, { emit }) {
    const commentBody = ref('');
    const errorMessage = ref('');//ログインしていないときに保存ボタンを押したときようのエラー

    const submitComment = async () => {
      try {
        await axios.post(`/api/posts/${props.postId}/comments`, {
          body: commentBody.value,
        });
        commentBody.value = '';
        emit('comment-posted');
      } catch (error) {
        console.error('Error posting comment:', error);
                // エラーレスポンスからエラーメッセージを取得して設定
        errorMessage.value = error.response && error.response.data.message ? error.response.data.message : 'ログインするとコメントすることができます';
      }
    };

    
    const clearError = () => {
      errorMessage.value = '';
    };

    return { commentBody, submitComment,errorMessage, clearError  };
  },
};
</script>
