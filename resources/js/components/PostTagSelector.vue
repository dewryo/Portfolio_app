<template>
  <div>
    <h3>Select Tags:</h3>
    <button v-for="tag in availableTags" :key="tag" @click="selectTag(tag)">
      {{ tag }}
    </button>
  </div>
</template>

<script>
export default {
  props: {
    selectedTags: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      // 仮のタグデータ。本番ではAPIから取得するなどしてください。
      availableTags: ['算数', '国語', '理科', '社会'],
    };
  },
  methods: {
    selectTag(tag) {
        console.log("selectTag is called with: ", tag);
      if (!this.selectedTags.includes(tag)) {
        this.$emit('tag-selected', tag);
      }
    },
  },
};
</script>