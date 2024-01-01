<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('images', function (Blueprint $table) {
        $table->renameColumn('update_at', 'updated_at');
        // 他のカラムの変更もここで行う
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
