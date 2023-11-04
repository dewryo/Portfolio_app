<template>
    <button @click="toggleLike" >
        <span :class="{ 'is-liked' : isLiked}">♥</span>{{ likesCount }}
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
.is-liked {
  color: red;
}
</style>