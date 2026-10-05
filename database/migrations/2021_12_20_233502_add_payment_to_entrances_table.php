<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentToEntrancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrances', function (Blueprint $table) {
            $table->integer('payment_status')->unsigned()->default(0);
            $table->integer('plan_status')->unsigned()->default(0);
            $table->string('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entrances', function (Blueprint $table) {
            $table->dropColumn('payment_status');
            $table->dropColumn('plan_status');
            $table->dropColumn('message');
        });
    }
}
