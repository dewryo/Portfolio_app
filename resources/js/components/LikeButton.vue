<template>
    <button @click="toggleLike" class="like-button btn">
        <i :class="['fa-heart', isLiked ? 'fas' : 'far', 'fa-lg']"></i>
        <span class="likes-count">{{ likesCount }}</span>
    </button>
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
        const isLiked = ref(false);
        const likesCount = ref(props.post.likes_count || 0);

        const toggleLike = () =>{
            axios.post(`/api/posts/${props.post.id}/likes`)
            .then(response => {
                isLiked.value = response.data.isLiked;
                likesCount.value = response.data.likesCount;
            })
            .catch(error =>{
                console.error(error);
            });
        };

        return{
            isLiked,
            likesCount,
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