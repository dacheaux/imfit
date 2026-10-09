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
        // Some databases already have these columns without this migration recorded as run.
        Schema::table('entrances', function (Blueprint $table) {
            if (! Schema::hasColumn('entrances', 'payment_status')) {
                $table->integer('payment_status')->unsigned()->default(0);
            }
            if (! Schema::hasColumn('entrances', 'plan_status')) {
                $table->integer('plan_status')->unsigned()->default(0);
            }
            if (! Schema::hasColumn('entrances', 'message')) {
                $table->string('message')->nullable();
            }
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
