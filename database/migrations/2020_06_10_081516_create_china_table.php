<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('china', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('p_id')->default(0)->comment('父id');
            $table->integer('code')->comment('行政区代码');
            $table->string('name')->comment('行政区名称');
            $table->integer('level')->default(0)->comment('地区级别1省,2市,3县');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('china');
    }
}
