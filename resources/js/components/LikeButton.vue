<template>
    <button @click="toggleLike" class="like-button btn">
        <i :class="['fa-heart', isLiked ? 'fas' : 'far', 'fa-lg']"></i>
        <span class="likes-count">{{ likesCount }}</span>
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

export default{
    props:{
        post:{
            type:Object,
            required:true
        },
    },

    setup(props){
        const isLiked = ref(props.post.is_liked_by_user);
        console.log(props.post.is_liked_by_user);
        const likesCount = ref(props.post.likes.length || 0);
        const errorMessage = ref('');

        const toggleLike = () =>{
            axios.post(`/api/posts/${props.post.id}/likes`)
            .then(response => {
                isLiked.value = response.data.isLiked;
                likesCount.value = response.data.likesCount;
                 errorMessage.value = ''; // エラーがない場合はメッセージをクリア
            })
            .catch(error =>{
                console.error(error);
                // エラーレスポンスからエラーメッセージを取得して設定
                errorMessage.value = error.response && error.response.data.message ? error.response.data.message : 'ログインすると「いいね」を送ることができます';
            });
        };

        const clearError = () => {
            errorMessage.value = '';
        };

        return{
            isLiked,
            likesCount,
            errorMessage,
            clearError,
            toggleLike,
        };
    }
};
</script>

<style>
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