<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScriptTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('script_tags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('script_tag_id');
            $table->integer('user_id');
            $table->string('src')->nullable();
            $table->string('event')->nullable();
            $table->string('cache')->nullable();
            $table->string('display_scope')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('script_tags');
    }
}
