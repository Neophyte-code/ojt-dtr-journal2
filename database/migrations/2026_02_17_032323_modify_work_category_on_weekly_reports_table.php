<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("weekly_reports", function (Blueprint $table) {
            $table->unsignedBigInteger("work_category")->change();

            $table
                ->foreign("work_category")
                ->references("id")
                ->on("work_categories")
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
