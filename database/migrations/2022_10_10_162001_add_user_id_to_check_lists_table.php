<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_lists', function (Blueprint $table) {
            $table->foreignId('user_id')->after('check_list_group_id')->nullable()->constrained();
            $table->foreignId('check_list_id')->after('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_lists', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['check_list_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('check_list_id');
        });
    }
};
