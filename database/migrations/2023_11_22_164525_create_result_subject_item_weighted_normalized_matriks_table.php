<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('result_subject_item_weighted_normalized_matriks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('title');
            $table->string('descriptions', 1000)->nullable();
            $table->double('star')->nullable();
            $table->double('facility')->nullable();
            $table->double('price')->nullable();
            $table->double('rating')->nullable();
            $table->double('si_plus')->nullable();
            $table->double('si_min')->nullable();
            $table->double('pi')->nullable();

            $table->bigInteger('result_id')->unsigned()->index();

            $table->bigInteger("created_by")->nullable()->unsigned()->index();
            $table->bigInteger("updated_by")->nullable()->unsigned()->index();
            $table->bigInteger("deleted_by")->nullable()->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_subject_item_weighted_normalized_matriks');
    }
};
