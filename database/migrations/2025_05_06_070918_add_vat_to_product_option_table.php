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
        Schema::table('product_options', function (Blueprint $table) {

            $table->renameColumn('game_id', 'product_id');
            $table->renameColumn('price', 'base_price');
            $table->decimal('discount', 8, 2)->default(0)->after('base_price');
            $table->decimal('vat', 8, 2)->default(0)->after('discount');
            $table->dropColumn('final_price');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_options', function (Blueprint $table) {
            $table->renameColumn('product_id', 'game_id');
            $table->renameColumn('base_price', 'price');

            $table->dropColumn('discount');
            $table->dropColumn('vat');

            // Tambahkan kembali final_price jika dihapus
            $table->decimal('final_price', 8, 2)->default(0);
        });
    }
};
