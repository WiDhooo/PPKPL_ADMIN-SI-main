<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tblpendaftaran', function (Blueprint $table) {
            $table->string('payment_token')->nullable()->unique()->after('order_id');
        });
    }

    public function down()
    {
        Schema::table('tblpendaftaran', function (Blueprint $table) {
            $table->dropColumn('payment_token');
        });
    }

};
