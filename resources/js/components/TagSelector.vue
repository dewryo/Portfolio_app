<template>
  <div>
    <div class="mb-3">
      <p class="mb-2">学年</p>
      <div class="btn-group" role="group">
        <button type="button"
                v-for="grade in grades"
                :key="grade"
                @click="toggleTag('grade', grade)"
                :class="['custom-button', selectedGrades.includes(grade) ? 'active' : '']">
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
                :class="['custom-button', selectedGrades.includes(grade) ? 'active' : '']">
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
.custom-button {
  background-color: #f8f9fa; /* ライトグレー */
  color: #212529; /* ダークテキスト */
  border: 1px solid #ddd; /* 細いグレーの枠線 */
  padding: 8px 16px; /* ボタン内のパディング */
  margin-right: 8px; /* 右のマージン */
  margin-bottom: 8px; /* 下のマージン */
  border-radius: 4px; /* 角丸 */
  font-size: 16px; /* フォントサイズ */
  transition: background-color 0.3s, color 0.3s; /* スムーズな色の変更 */
}

.custom-button:hover {
  background-color: #e2e6ea; /* ホバー時の背景色 */
}

.active {
  background-color: #007bff; /* アクティブなボタンの背景色（ブルー） */
  color: #fff; /* ホワイトテキスト */
  border-color: #007bff; /* ブルーの枠線 */
}
</style>