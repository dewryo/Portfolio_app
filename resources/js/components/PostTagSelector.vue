<template>
  <div>
    <h3>Select Tags:</h3>
    <button 
      v-for="tag in availableTags" 
      :key="tag" 
      :class="{ 'selected': selectedTags.includes(tag) }"
      @click="toggleTagSelection(tag)">
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
      availableTags: ['算数', '国語', '理科', '社会'],
    };
  },
  methods: {
    toggleTagSelection(tag) {
      if (this.selectedTags.includes(tag)) {
        // タグがすでに選択されている場合は削除
        this.$emit('tag-deselected', tag);
      } else {
        // タグがまだ選択されていない場合は追加
        this.$emit('tag-selected', tag);
      }
    },
  },
};
</script>

<style>
.selected {
  background-color: blue;
  color: white;
}
</style>
