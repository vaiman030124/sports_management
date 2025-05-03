<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpPasswordResetsTable extends Migration
{
    public function up()
    {
        Schema::create('otp_password_resets', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('otp', 6);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();
            $table->enum('status', ['pending', 'verified', 'expired'])->default('pending');
        });
    }

    public function down()
    {
        Schema::dropIfExists('otp_password_resets');
    }
}
