<template>
  <button @click="toggleSavePost" :class="{ 'is-saving': saving, 'is-saved': saved }" class="bookmark-button">
    <i v-if="saved" class="fas fa-bookmark"></i> <!-- 保存済みの場合のアイコン -->
    <i v-else class="far fa-bookmark"></i> <!-- 保存していない場合のアイコン -->
  </button>
      <!-- Bootstrap モーダル -->
    <div v-if="errorMessage" class="modal d-block" tabindex="-1" role="dialog" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" :class="['like-button','close']" @click="clearError">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center justify-content-center">
                    <p>{{ errorMessage }}</p>
                    <div class="d-flex flex-column align-items-stretch">
                        <a :class="['btn', 'btn-outline-primary', 'btn-sm', 'mb-2', 'w-100']" href="/login">ログイン</a>
                         <a :class="['btn', 'btn-outline-primary', 'btn-sm', 'w-100']" href="/register">新規登録</a>
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
  name: 'SavePostButton',
  props: {
    postId: {
      type: Number,
      required: true,
    },
    // 初期状態でこの投稿が保存されているかどうかを表す
    isSaved: {
      type: Boolean,
      default: false
    }
  },
  setup(props) {
    const saving = ref(false);
    const saved = ref(props.isSaved); // 初期値としてpropsのisSavedを使用
    const errorMessage = ref('');//ログインしていないときに保存ボタンを押したときようのエラー

    const toggleSavePost = async () => {
      if (saving.value) {
        return; // すでに処理中の場合は何もしない
      }
      saving.value = true;
      try {
        if (saved.value) {
          // 保存済みの場合は解除する
          await axios.delete(`/api/posts/${props.postId}/save`);
          saved.value = false;
        } else {
          // 未保存の場合は保存する
          await axios.post(`/api/posts/${props.postId}/save`);
          saved.value = true;
        }
      } catch (error) {
        console.error('操作に失敗しました。', error);
        // エラーレスポンスからエラーメッセージを取得して設定
        errorMessage.value = error.response && error.response.data.message ? error.response.data.message : 'ログインすると「保存」することができます';
      } finally {
        saving.value = false;
      }
    };

    const clearError = () => {
      errorMessage.value = '';
    };

    return {
      saving,
      saved,
      toggleSavePost,
      errorMessage,
      clearError
    };
  },
};
</script>

<style scoped>
.bookmark-button {
  border: none;
  background: transparent;
  cursor: pointer;
}

/* ボタンが無効化されている時のスタイル */
.bookmark-button:disabled,
.bookmark-button.is-saving {
  cursor: default;
  opacity: 0.5;
}

/* 保存済みのスタイル */
.bookmark-button.is-saved {
  color: gold; /* 保存済みを示す色、適宜変更してください */
}
.like-button {
  border: none; /* 枠線を取り除く */
  background-color: transparent; /* ボタンの背景を透明にする */
  padding: 0.375rem 0.75rem; /* Bootstrapの標準パディング */
}

.like-button .fa-heart {
  color: #d63384; /* Bootstrapのテーマカラーを使う */
  margin-right: 0.375rem; /* アイコンと数字の間隔 */
}

.like-button .fa-heart.fas {
  color: #d63384; /* いいね済みのときの色 */
}

.like-button .fa-heart.far {
  color: #adb5bd; /* いいねしていないときの色 */
}

.likes-count {
  vertical-align: middle; /* 数字をアイコンと同じ高さに揃える */
}
</style>
