<template>
  <form @submit.prevent="submitReply" class="mb-3">
    <div class="form-group">
      <textarea v-model="replyBody" class="form-control" placeholder="返信を入力" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">返信する</button>
  </form>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  props: {
    commentId: Number,
  },
  setup(props, { emit }) {
    const replyBody = ref('');

    const submitReply = async () => {
      try {
        await axios.post(`/api/posts/comments/${props.commentId}/replies`, {
          body: replyBody.value,
        });
        replyBody.value = '';
        emit('replyPosted');
      } catch (error) {
        console.error('Error posting reply:', error);
      }
    };

    return { replyBody, submitReply };
  },
};
</script>
