<template>
  <div>
    <div class="mb-3">
      <p class="mb-2">学年</p>
      <div class="btn-group" role="group">
        <button type="button" v-for="grade in grades" :key="grade" @click="toggleTag('grade', grade)" :class="['btn', selectedGrades.includes(grade) ? 'btn-primary' : 'btn-outline-primary']">
          {{ grade }}
        </button>
      </div>
      <input type="hidden" name="grades[]" v-for="grade in selectedGrades" :key="'grade-' + grade" :value="grade">
    </div>

    <div class="mb-3">
      <p class="mb-2">教科</p>
      <div class="btn-group" role="group">
        <button type="button" v-for="subject in subjects" :key="subject" @click="toggleTag('subject', subject)" :class="['btn', selectedSubjects.includes(subject) ? 'btn-primary' : 'btn-outline-primary']">
          {{ subject }}
        </button>
      </div>
      <input type="hidden" name="subjects[]" v-for="subject in selectedSubjects" :key="'subject-' + subject" :value="subject">
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      grades: ['1年', '2年', '3年', '4年', '5年', '6年'],
      subjects: ['国語', '算数', '理科', '社会', '音楽', '図工', '体育', '家庭科', '総合', '道徳', '学級活動'],
      selectedGrades: [],
      selectedSubjects: []
    }
  },
  methods: {
    toggleTag(type, tag) {
      if (type === 'grade') {
        this.selectedGrades.includes(tag) ? this.selectedGrades.splice(this.selectedGrades.indexOf(tag), 1) : this.selectedGrades.push(tag);
      } else if (type === 'subject') {
        this.selectedSubjects.includes(tag) ? this.selectedSubjects.splice(this.selectedSubjects.indexOf(tag), 1) : this.selectedSubjects.push(tag);
      }
    }
  }
}
</script>

<style>
.selected {
  background-color: blue;
  color: white;
}
</style>