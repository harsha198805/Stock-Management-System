<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->after('unit_price'); // 1 = active, 0 = inactive, 2 = out_of_stock
        });
    }

    public function down()
    {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
