<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LSurma\LaravelBlacklist\LaravelBlacklistServiceProvider;

class CreateBlacklistTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $model = LaravelBlacklistServiceProvider::getBlacklistModel();
        $this->table = (new $model)->getTable();    
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
    
            $table->string('type')->nullable(false);
            $table->string('value')->nullable(false);

            $table->unique(['type', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
