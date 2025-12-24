<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Kita letakkan setelah email biar rapi
        // Default 'admin' agar saat testing kalian ga ribet (bisa diubah nanti)
        // Atau default 'user' untuk keamanan. Pilih 'user' ya.
        $table->string('role')->default('user')->after('email'); 
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role'); // Ini buat jaga-jaga kalau mau rollback
    });
}

    
};
