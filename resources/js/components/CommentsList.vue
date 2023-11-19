<template>
  <div class="comment-form-container mb-4">
    <comment-form :post-id="postId" @comment-posted="fetchComments"></comment-form>
  </div>

  <div class="comments">
    <div v-for="comment in comments" :key="comment.id" class="comment mb-3" >
      <div class="card" v-if="comment.parent_id === null">
        <div class="card-body" @click="showReplyForm(comment.id)">
          <p class="card-text">{{ comment.body }}</p>
          

          <!-- 返信フォームの表示 -->
          <div v-if="state.replyFormVisible === comment.id" class="mt-3">
            <reply-form :comment-id="comment.id" @replyPosted="fetchComments"></reply-form>
          </div>

          <!-- 返信コメントのネストされた表示 -->
          <div v-for="reply in comments" :key="reply.id"  class="reply mt-2">
            <div class="card" v-if="reply.parent_id === comment.id">
              <div class="card-body">
                <p class="card-text">{{ reply.body }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import { ref, reactive, onMounted } from 'vue';
import CommentForm from './CommentForm.vue';
import ReplyForm from './ReplyForm.vue';
import axios from 'axios';

export default {
  components: {
    ReplyForm,
    CommentForm,
  },
  props: {
    postId: Number,
  },
  setup(props) {
    const comments = ref([]);
    const state = reactive({
      replyFormVisible: null,
    });

    const fetchComments = async () => {
      try {
        const response = await axios.get(`/api/posts/${props.postId}/comments`);
        comments.value = response.data;
      } catch (error) {
        console.error('Error fetching comments:', error);
      }
    };

    onMounted(fetchComments);

    const showReplyForm = (commentId) => {
      state.replyFormVisible = commentId;
    };


    return { comments, state, showReplyForm, fetchComments,  };
  },
};
</script>
