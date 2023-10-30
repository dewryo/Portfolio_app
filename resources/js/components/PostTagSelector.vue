<template>
  <div class="container  sticky ">
    <div class="row justify-content-end">
      <!-- Search Form Column -->
    <SearchForm></SearchForm>
    <div style="height: 20px;"></div>
      <!-- Tag Selector Column -->
      <div class="col-md-9">
        <div>
          <h5 class="mb-3">学年</h5>
          <div class="d-flex flex-column mb-4">
            <button 
              v-for="grade in grades" 
              :key="grade"
              :class="['btn', selectedTags.includes(grade) ? 'btn-primary' : 'btn-outline-primary', 'btn-sm']"
              @click="toggleTagSelection(grade)">
              {{ grade }}
            </button>
          </div>

          <h5 class="mb-3">教科</h5>
          <div class="d-flex flex-column">
            <button 
              v-for="subject in subjects" 
              :key="'subject-' + subject"
              :class="['btn', selectedTags.includes(subject) ? 'btn-primary' : 'btn-outline-primary', 'btn-sm']"
              @click="toggleTagSelection(subject)">
              {{ subject }}
            </button>
          </div>
        </div>
      </div>

      <!-- Content Column -->
      <div class="col-md-9">
        <!-- Your content goes here -->
      </div>
    </div>
  </div>
</template>

<script>
import SearchForm from './SearchForm.vue';

export default {
  components: {
    SearchForm,
  },
  props: {
    selectedTags: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      grades: ['1年', '2年', '3年', '4年', '5年', '6年'],
      subjects: ['国語', '算数', '理科', '社会', '音楽', '図工', '体育', '家庭科', '総合', '道徳', '学級活動'],
    };
  },
  methods: {
    toggleTagSelection(tag) {
      if (this.selectedTags.includes(tag)) {
        this.$emit('tag-deselected', tag);
      } else {
        this.$emit('tag-selected', tag);
      }
    },
  },
};
</script>

