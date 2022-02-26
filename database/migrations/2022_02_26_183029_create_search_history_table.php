<?php

use App\Models\SearchHistoryModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SearchHistoryModel::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('email', 255);
            $table->string('searchString', 1000);
            $table->integer('resultCount');
            $table->double('searchSpeed', 32, 18);
            $table->integer('searchedOn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(SearchHistoryModel::TABLE_NAME);
    }
}
