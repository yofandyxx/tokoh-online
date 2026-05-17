<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
/**
* Run the migrations.
*/
public function up(): void
{
Schema::create('users', function (Blueprint $table) {
$table->id(); // Primary key (auto increment)

$table->string('name'); // Nama user
$table->string('email')->unique(); // Email unik
$table->timestamp('email_verified_at')->nullable(); // Waktu verifikasi email

$table->string('password'); // Password user
$table->string('role')->default('user'); // Role: admin / user / kasir
$table->rememberToken(); // Token "remember me"

$table->timestamps(); // created_at & updated_at
});
}
/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('users');
}
};