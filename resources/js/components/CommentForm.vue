<template>
  <form @submit.prevent="submitComment" class="mb-3">
    <div class="form-group">
      <textarea v-model="commentBody" class="form-control" placeholder="コメントを入力" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">コメントする</button>
  </form>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  props: {
    postId: Number,
  },
  setup(props, { emit }) {
    const commentBody = ref('');

    const submitComment = async () => {
      try {
        await axios.post(`/api/posts/${props.postId}/comments`, {
          body: commentBody.value,
        });
        commentBody.value = '';
        emit('comment-posted');
      } catch (error) {
        console.error('Error posting comment:', error);
      }
    };

    return { commentBody, submitComment };
  },
};
</script>
