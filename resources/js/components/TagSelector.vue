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

<script setup>
import { ref } from 'vue';

const grades = ['1年', '2年', '3年', '4年', '5年', '6年'];
const subjects = ['国語', '算数', '理科', '社会', '音楽', '図工', '体育', '家庭科', '総合', '道徳', '学級活動'];
const selectedGrades = ref([]);
const selectedSubjects = ref([]);

const toggleTag = (type, tag) => {
  if (type === 'grade') {
    selectedGrades.value.includes(tag) ? selectedGrades.value.splice(selectedGrades.value.indexOf(tag), 1) : selectedGrades.value.push(tag);
  } else if (type === 'subject') {
    selectedSubjects.value.includes(tag) ? selectedSubjects.value.splice(selectedSubjects.value.indexOf(tag), 1) : selectedSubjects.value.push(tag);
  }
}
</script>

<style>
.selected {
  background-color: blue;
  color: white;
}
</style>