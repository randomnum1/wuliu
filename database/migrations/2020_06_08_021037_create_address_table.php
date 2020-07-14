<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->string('country',200)->default("")->comment("地址所属国家区域");
            $table->string('en_name',200)->default("")->comment("英文名");
            $table->string('cn_name',200)->default("")->comment("中文名");
            $table->string('phone',200)->default("");
            $table->string('email',200)->default("");
            $table->string('province',200)->default("")->comment("省");
            $table->string('city',200)->default("")->nullable()->comment("市");
            $table->string('area',200)->default("")->nullable()->comment("区");
            $table->string('detail',200)->default("")->comment("详细地址");
            $table->string('postcode',20)->default("")->comment("邮编");
            $table->string('state',200)->default("0")->comment("1为默认地址");
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
        Schema::dropIfExists('addresses');
    }
}
