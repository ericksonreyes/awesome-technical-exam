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
            $table->string('email', 255);
            $table->longText('headers');
            $table->index(['email', FailedUserAuthenticationAttemptModel::CREATED_AT], 'idx_email_created_at');
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
