<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('accounts_contact')->nullable()->after('email');
            $table->string('accounts_email')->nullable()->after('accounts_contact');
            $table->string('accounts_phone')->nullable()->after('accounts_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('accounts_contact');
            $table->dropColumn('accounts_email');
            $table->dropColumn('accounts_phone');
        });
    }
}
