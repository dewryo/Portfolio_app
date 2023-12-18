<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class RenamePostTagTable extends Migration
{
    public function up()
    {
        Schema::rename('post_tag', 'post_tags');
    }

    public function down()
    {
        Schema::rename('post_tags', 'post_tag');
    }
}
