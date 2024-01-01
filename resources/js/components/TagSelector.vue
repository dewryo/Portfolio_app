<template>
  <div>
    <div class="mb-3">
      <p class="mb-2">学年</p>
      <div class="btn-group" role="group">
        <button type="button"
                v-for="grade in grades"
                :key="grade"
                @click="toggleTag('grade', grade)"
                :class="['btn', 'btn-spacing', selectedGrades.includes(grade) ? 'btn-secondary' : 'btn-light']">
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
                :class="['btn', 'btn-spacing', selectedSubjects.includes(subject) ? 'btn-secondary' : 'btn-light']">
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
.selected, .btn-secondary {
  background-color: #6c757d; /* 選択されたときの背景色（ダークグレー） */
  color: white; /* テキストの色 */
  border-color: #6c757d; /* 枠線の色 */
}

.btn-light {
  background-color: #f8f9fa; /* 背景色（ライトグレー） */
  color: #212529; /* テキストの色（ダーク） */
  border-color: #f8f9fa; /* 枠線の色 */
}

.btn-spacing {
  margin-right: 8px; /* 右のマージン */
  margin-bottom: 8px; /* 下のマージン */
}

.btn:hover, .btn-secondary:hover, .btn-light:hover {
  /* ホバー時のスタイルを削除または無効化 */
  background-color: inherit; /* 現在の背景色を保持 */
  color: inherit; /* 現在のテキスト色を保持 */
  border-color: inherit; /* 現在の枠線色を保持 */
}
</style>
