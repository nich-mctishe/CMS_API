<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClientsTableMakeNullableUneccessaryColumnThatICantDropCusItsSqlLiteAndYouNeverKnowIMightNeedThemOneDay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function($table) {
            $table->string('desc')->nullable()->change();
            $table->string('role')->nullable()->change();
            $table->string('dateStarted')->nullable()->change();
            $table->string('dateEnded')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
