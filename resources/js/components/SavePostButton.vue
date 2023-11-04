<template>
  <button @click="savePost" :disabled="saving">
    {{ saving ? '保存中...' : '保存する' }}
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
    }
  },
  setup(props) {
    const saving = ref(false);
    const message = ref("");

    const savePost = async () => {
      saving.value = true;
      try {
        // 保存のAPIエンドポイントにPOSTリクエストを送信
        await axios.post(`/api/posts/${props.postId}/save`)
        .then(response => {
                message.value = response.data.message;
            })
        alert(message.value);
        // 追加の処理...
      } catch (error) {
        let message = '保存に失敗しました。';
        if (error.response && error.response.data && error.response.data.message) {
             message = error.response.data.message;
         }
    alert(message);
      } finally {
        saving.value = false;
      }
    };

    // setup関数から返されたプロパティは、テンプレート内で使用可能
    return {
      saving,
      savePost
    };
  },
};
</script>
