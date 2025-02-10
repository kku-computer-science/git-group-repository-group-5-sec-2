<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHighlightPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('highlight_papers', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('picture', 255)->nullable();
            $table->boolean('isSelected')->default(false);
            $table->unsignedBigInteger('paper_id'); // UNSIGNED BIGINT

            // Foreign Key
            $table->foreign('paper_id')
                ->references('id')->on('papers')
                ->onDelete('cascade')  // ลบ highlight_papers หาก papers ถูกลบ
                ->onUpdate('cascade'); // อัปเดตค่า paper_id หาก papers ถูกอัปเดต

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('highlight_papers');
    }
}
