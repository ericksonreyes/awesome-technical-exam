<?php

use App\Models\UserModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserModel::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('guid', 255);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('status', 150);
            $table->bigInteger('createdOn');
            $table->bigInteger('lastUpdatedOn');
            $table->index(['email', 'password'], 'idx_email_password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(UserModel::TABLE_NAME);
    }
}
