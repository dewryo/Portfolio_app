<template>
  <div>
    <div class="mb-3">
      <p class="mb-2">学年</p>
      <div class="btn-group" role="group">
        <button type="button"
                v-for="grade in grades"
                :key="grade"
                @click="toggleTag('grade', grade)"
                :class="['btn', 'btn-spacing', selectedGrades.includes(grade) ? 'btn-primary' : 'btn-outline-primary']">
          {{ grade }}
        </button>
      </div>
      <input type="hidden" name="grades[]" v-for="grade in selectedGrades" :key="'grade-' + grade" :value="grade">
    </div>

    <div class="mb-3">
      <p class="mb-2">教科</p>
      <div class="btn-group flex-wrap" role="group">
        <button type="button"
                v-for="subject in subjects"
                :key="subject"
                @click="toggleTag('subject', subject)"
                :class="['btn', 'btn-spacing', selectedSubjects.includes(subject) ? 'btn-primary' : 'btn-outline-primary']">
         {{ subject }}
       </button>
      </div>
      <input type="hidden" name="subjects[]" v-for="subject in selectedSubjects" :key="'subject-' + subject" :value="subject">
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
 initialGrades: {
    type: Array,
    default: () => ([]), // 配列のデフォルト値は、関数で空配列を返すようにします。
  },
  initialSubjects: {
    type: Array,
    default: () => ([]), // 同様に空配列を返します。
}});


const grades = ['1年', '2年', '3年', '4年', '5年', '6年'];
const subjects = ['国語', '算数', '理科', '社会', '音楽', '図工', '体育', '家庭科', '総合', '道徳', '学級活動'];
const selectedGrades = ref(props.initialGrades ||[]);
const selectedSubjects = ref(props.initialSubjects || []);


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

.btn-spacing {
  margin-right: 8px; /* 右のマージン */
  margin-bottom: 8px; /* 下のマージン */
}

/* ボタンが選択されているときのスタイル */
.btn-primary:not(:hover) {
  background-color: #007bff; /* ここに選択されているときの色を指定 */
  border-color: #007bff; /* 枠線の色も同様に */
}

/* ボタンが選択されていないときのスタイル */
.btn-outline-primary {
  background-color: transparent; /* 背景色は透明に */
  border-color: #007bff; /* 枠線の色 */
  color: #007bff; /* テキストの色 */
}

/* カーソルを合わせたときの色変化を無くす */
.btn:not(:hover) {
  background-color: inherit; /* 親要素から背景色を継承 */
  border-color: inherit; /* 親要素から枠線の色を継承 */
  color: inherit; /* 親要素からテキストの色を継承 */
}
</style>
