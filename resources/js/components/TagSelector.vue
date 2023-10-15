<template>
  <div>
    <div>
      <h4>学年</h4>
      <button type="button" v-for="grade in grades" :key="grade" @click="toggleTag('grade', grade)" :class="{ selected: selectedGrades.includes(grade) }">{{ grade }}</button>
      <input type="hidden" name="grades[]" v-for="grade in selectedGrades" :key="'grade-' + grade" :value="grade">
    </div>

    <div>
      <h4>教科</h4>
      <button type="button" v-for="subject in subjects" :key="subject" @click="toggleTag('subject', subject)" :class="{ selected: selectedSubjects.includes(subject) }">{{ subject }}</button>
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