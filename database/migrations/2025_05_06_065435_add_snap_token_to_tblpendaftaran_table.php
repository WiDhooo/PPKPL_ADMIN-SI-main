<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSnapTokenToTblpendaftaranTable extends Migration
{
    public function up()
    {
        Schema::table('tblpendaftaran', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('order_id');
        });
    }

    public function down()
    {
        Schema::table('tblpendaftaran', function (Blueprint $table) {
            $table->dropColumn('snap_token');
        });
    }
}
