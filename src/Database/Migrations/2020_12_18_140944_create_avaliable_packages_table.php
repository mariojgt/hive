<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliablePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliable_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('version')->nullable();
            $table->string('zip_path')->nullable();
            $table->string('github_author')->nullable();
            $table->string('github_repo')->nullable();
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
        Schema::dropIfExists('avaliable_packages');
    }
}
