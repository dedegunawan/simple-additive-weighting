<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('config', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->nullable();
            $table->string('nama')->nullable();
            $table->timestamps();
        });


        Schema::create('crips', function (Blueprint $table) {
            $table->id();
            $table->string('nama_crips')->nullable();
            $table->timestamps();
        });
        Schema::create('crips_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crips_id')->nullable();
            $table->string('deskripsi')->nullable();
            $table->unsignedBigInteger('kelompok')->nullable();
            $table->timestamps();

            $table->foreign('crips_id')
                ->on('crips')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade')
            ;
        });

        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kriteria')->nullable();
            $table->string('satuan')->nullable();
            $table->float('bobot', 5, 2)->nullable();
            $table->boolean('crips')->nullable();
            $table->unsignedBigInteger('crips_id')->nullable();
            $table->timestamps();

            $table->foreign('crips_id')
                ->on('crips')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade')
            ;
        });

        Schema::create('atribut', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kriteria_id')->nullable();
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();

            $table->foreign('kriteria_id')
                ->on('kriteria')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade')
            ;

            $table->foreign('mahasiswa_id')
                ->on('mahasiswa')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade')
            ;
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atribut');
        Schema::dropIfExists('kriteria');
        Schema::dropIfExists('crips_detail');
        Schema::dropIfExists('crips');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('config');
    }
}
