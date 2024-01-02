<template>
  
    <div class="row justify-content-end">

      <div class="col-md-6">
        <div style="height: 20px;"></div>
        <div>
          <h6 class="mb-3">タグ</h6>
          <div class="d-flex flex-column mb-4">
          <!-- 年度のプルダウンメニュー -->
          <div class="dropdown flex-grow-1">
            <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              学年
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">
              <li v-for="grade in grades" :key="grade">
                <a class="dropdown-item" href="#" @click="toggleTagSelection(grade)">{{ grade }}</a>
              </li>
            </ul>
          </div>

          <!-- 教科のプルダウンメニュー -->
          <div class="dropdown flex-grow-1">
            <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
              教科
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton2">
              <li v-for="subject in subjects" :key="'subject-' + subject">
                <a class="dropdown-item" href="#" @click="toggleTagSelection(subject)">{{ subject }}</a>
              </li>
            </ul>
          </div>

          <!-- 選択済みタグ -->

        </div>
            <div class="selected-tags">
            
              <div v-for="tag in selectedTags" :key="tag" class="d-flex justify-content-between align-items-center tag">
                <span>{{ tag }}</span>
                <button @click="removeTag(tag)">×</button>
              </div>
            </div>
            
        </div>
      </div>
            
    </div>
      
   

</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  selectedTags: Array
});
const emit = defineEmits();
const grades = ['1年', '2年', '3年', '4年', '5年', '6年'];
const subjects = ['国語', '算数', '理科', '社会', '音楽', '図工', '体育', '家庭科', '総合', '道徳', '学級活動'];

function toggleTagSelection(tag) {
  if (props.selectedTags.includes(tag)) {
    emit('tag-deselected', tag);
  } else {
    emit('tag-selected', tag);
  }
}

function removeTag(tag) {
  emit('tag-deselected', tag);
}

onMounted(() => {
  console.log(props);
});
</script>

<style>
.selected-tags {
  margin-top: 10px;
}

.tag {
  
  background-color: #e1e1e1;
  padding: 5px;
  margin-right: 5px;
  border-radius: 5px;
  margin-top: 5px
}

.tag button {
  color:black;
  background: none;
  border: none;
  cursor: pointer;
}
</style>