<template>
  <button @click="toggleSavePost" :class="{ 'is-saving': saving, 'is-saved': saved }" class="bookmark-button">
    <i v-if="saved" class="fas fa-bookmark"></i> <!-- 保存済みの場合のアイコン -->
    <i v-else class="far fa-bookmark"></i> <!-- 保存していない場合のアイコン -->
  </button>
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
    // この情報はおそらく親コンポーネントまたはAPIから取得することになるでしょう
    isSaved: {
      type: Boolean,
      default: false
    }
  },
  setup(props) {
    const saving = ref(false);
    const saved = ref(props.isSaved); // 初期値としてpropsのisSavedを使用

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
        alert(error.response?.data?.message || 'エラーが発生しました。');
      } finally {
        saving.value = false;
      }
    };

    return {
      saving,
      saved,
      toggleSavePost
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
</style>
