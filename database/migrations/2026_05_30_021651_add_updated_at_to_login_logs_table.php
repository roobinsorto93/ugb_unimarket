<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('login_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('login_logs', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });
    }

    public function down()
    {
        Schema::table('login_logs', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
    }
};