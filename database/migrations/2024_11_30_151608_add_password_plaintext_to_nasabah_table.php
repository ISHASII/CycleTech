<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordPlaintextToNasabahTable extends Migration
{
    public function up()
    {
        Schema::table('nasabah', function (Blueprint $table) {
            $table->string('password_plaintext')->nullable()->after('password');
        });
    }

    public function down()
    {
        Schema::table('nasabah', function (Blueprint $table) {
            $table->dropColumn('password_plaintext');
        });
    }
}