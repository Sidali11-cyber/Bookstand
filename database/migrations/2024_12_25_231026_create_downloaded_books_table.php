<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadedBooksTable extends Migration
{
    public function up()
    {
        Schema::create('downloaded_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reader_id')->constrained()->onDelete('cascade'); // Cascade delete
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Cascade delete
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('downloaded_books');
    }
}
