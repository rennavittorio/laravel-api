<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('title', 150)->unique();
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->string('website_link')->nullable();
            $table->string('source_code_link')->nullable();
            $table->string('proj_category', 100);
            $table->string('client', 100);
            $table->string('client_category', 100);
            $table->softDeletes();

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
        Schema::dropIfExists('projects');
    }
};
