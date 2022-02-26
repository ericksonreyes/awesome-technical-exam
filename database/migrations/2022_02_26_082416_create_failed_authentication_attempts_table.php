<?php

use App\Models\FailedUserAuthenticationAttemptModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedAuthenticationAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(FailedUserAuthenticationAttemptModel::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('username', 150);
            $table->longText('headers');
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
        Schema::dropIfExists(FailedUserAuthenticationAttemptModel::TABLE_NAME);
    }
}
