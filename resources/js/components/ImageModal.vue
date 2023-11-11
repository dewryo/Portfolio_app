<template>
  <div class="modal fade" tabindex="-1" :class="{'show': isModalOpen}" style="display: var(--bs-display);" aria-hidden="!isModalOpen">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          

        </div>
        <div class="modal-body">
          <img :src="image.url" :alt="image.name || 'Post Image'" class="img-fluid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  image: Object,
  isModalOpen: Boolean
});

const emit = defineEmits(['close-modal']);

const closeModal = () => {
  emit('close-modal');
};
</script>

<style scoped>
/* スタイルの表示/非表示を制御するCSS変数 */
:root {
  --bs-display: none;
}
.show {
  --bs-display: block !important; /* モーダルを表示するときにブロック要素にする */
}

/* モーダル表示時の背景 */
.modal.fade.show {
  display: flex !important; /* flexボックスを使用して要素を中央に配置 */
  justify-content: center; /* 横方向の中央揃え */
  align-items: center; /* 縦方向の中央揃え */
  background-color: rgba(0, 0, 0, 0.5); /* 背景を黒の半透明に設定 */
}

/* z-indexを使用してモーダルを前面に表示 */
.modal-dialog {
  z-index: 1050;
}

/* モーダル本体のスタイル */
.modal-content {
  margin: auto; /* 自動マージンで中央揃え */
  width: auto; /* 幅を自動で調整 */
  max-width: 100%; /* 最大幅をビューポートの幅に制限 */
}

/* 画像のスタイル：サイズ変更なしで中央に表示 */
.modal-body img {
  display: block; /* ブロックレベル要素として表示 */
  margin: auto; /* 画像を中央に配置 */
  width: auto; /* 元の画像の幅を維持 */
  height: auto; /* 元の画像の高さを維持 */
  max-width: 100%; /* コンテナが小さい場合は幅を調整 */
  max-height: calc(100vh - 60px); /* 画面の高さに合わせて高さを調整 */
}

/* モーダルコンテンツの背景とボーダーを透明に */
.modal-content {
  background: transparent;
  border: none;
}

/* モーダルヘッダーとフッターの背景を透明に */
.modal-header,
.modal-footer {
  background: transparent;
  border: none;
}

/* クローズボタンとフッターのボタンの文字色を白色に */
.modal-header .btn-close,
.modal-footer .btn {
  color: #fff;
}

/* クローズボタンの背景を透明に */
.modal-header .btn-close {
  background: transparent;
}

/* オプショナル: クローズボタンのホバースタイル */
.modal-header .btn-close:hover {
  color: #aaa; /* ホバー時の色を指定 */
  background: transparent;
}
</style>
