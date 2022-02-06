<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $table = config('laravisit.table_name');

        Schema::create($table, function (Blueprint $table) {
            $table->id();
            $table->morphs('visitable');
            $table->json('data');
            $table->timestamps();
        });
    }
};
