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
        Schema::create('bank_reports', function (Blueprint $table) {
            $table->increments('id', 11);
            $table->char('bank_id', 12);
            $table->double('balance');
            $table->date('date');
            $table->double('receive');
            $table->double('transfer');
            $table->double('refund');
            $table->double('pay');
            $table->double('pay_usd');
            $table->integer('ins_id');
            $table->integer('upd_id')->nullable();
            $table->dateTime('ins_datetime');
            $table->dateTime('upd_datetime')->nullable();
            $table->char('del_flag', 1)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_reports');
    }
};
