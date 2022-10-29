<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('title')->nullable();
            $table->string('slug');
            $table->uuid('uuid')->nullable();
            $table->string('password')->nullable();
            $table->char('lang');
            $table->unsignedInteger('collection_id')->nullable();
            $table->unsignedInteger('author_id');
            $table->smallInteger('status_id')->default(1);
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('survey_id');
            $table->string('title')->nullable();
            $table->unsignedInteger('position');
        });

        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('survey_id');
            $table->string('title')->nullable();
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('position');
            $table->boolean('is_question')->default(false);
            $table->longText('content')->nullable();
            $table->json('options')->nullable();
        });

        // Schema::create('options', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->unsignedBigInteger('block_id');
        //     $table->string('title');
        //     $table->string('text');
        // });

        // Schema::create('types', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        //     $table->string('name');
        //     $table->text('svg_icon')->nullable();
        // });

        // Artisan::call('db:seed', [
        //     '--class' => 'TypeSeeder',
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('blocks');
        //Schema::dropIfExists('options');
        //Schema::dropIfExists('types');
    }
};
