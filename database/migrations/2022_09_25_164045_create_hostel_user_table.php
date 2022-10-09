<?php

declare(strict_types=1);

use App\Models\Hostel;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hostel_user', function (Blueprint $table): void {
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Hostel::class)->constrained()->cascadeOnDelete();
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->primary(['user_id', 'hostel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostel_user');
    }
};
