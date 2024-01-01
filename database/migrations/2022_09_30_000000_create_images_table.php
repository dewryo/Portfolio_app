<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();  // 主キー
            $table->unsignedBigInteger('user_id');  // ユーザーID
            $table->unsignedBigInteger('post_id')->nullable();  // 投稿ID、NULLを許可
            $table->string('file_name');  // ファイル名
            $table->string('file_path');  // ファイルパス
            $table->timestamp('created_at')->useCurrent();  // 作成日時
<<<<<<< HEAD
            $table->timestamp('update_at')->useCurrent()->useCurrentOnUpdate();  // 更新日時
=======
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();  // 更新日時
>>>>>>> 58c4b07c1bc5b18e6af06add9acaeee59732b069

            // 外部キー制約（オプション）
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
