<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();  // 主キー
            $table->unsignedBigInteger('user_id');  // ユーザーID
            $table->text('title');  // タイトル
            $table->text('content');  // コンテンツ
            $table->timestamp('created_at')->useCurrent();  // 作成日時
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();  // 更新日時

            // 外部キー制約（オプション）
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
