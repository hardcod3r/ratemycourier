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
        Schema::create('aggregated_views', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('courier_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('type'); // 0 = List View, 1 = Detail View
            $table->date('view_date'); // Aggregation by date
            $table->integer('views')->default(0); // Συγκεντρωτικός αριθμός προβολών
            $table->timestamps();
            $table->unique(['courier_id', 'type', 'view_date']); // Unique για aggregation
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aggregated_views');
    }
};
