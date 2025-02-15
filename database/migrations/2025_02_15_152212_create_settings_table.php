<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        // Insert default setting for reporting interval
        DB::table('settings')->insert([
            ['key' => 'reporting_interval', 'value' => 'hourly'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
