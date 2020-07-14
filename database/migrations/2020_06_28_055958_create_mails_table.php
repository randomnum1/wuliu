<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->integer('user_id');
            $table->string('a_country')->nullable();
            $table->string('a_en_name')->nullable();
            $table->string('a_cn_name')->nullable();
            $table->string('a_phone')->nullable();
            $table->string('a_email')->nullable();
            $table->string('a_province')->nullable();
            $table->string('a_city')->nullable();
            $table->string('a_area')->nullable();
            $table->string('a_detail')->nullable();
            $table->string('a_postcode')->nullable();
            $table->string('b_country')->nullable();
            $table->string('b_en_name')->nullable();
            $table->string('b_cn_name')->nullable();
            $table->string('b_phone')->nullable();
            $table->string('b_email')->nullable();
            $table->string('b_province')->nullable();
            $table->string('b_city')->nullable();
            $table->string('b_area')->nullable();
            $table->string('b_detail')->nullable();
            $table->string('b_postcode')->nullable();
            $table->string('type')->nullable();
            $table->string('date')->nullable();
            $table->integer('packaging')->comment('是否包装，0,1')->nullable();
            $table->integer('tax')->comment('是否包税，0,1')->nullable();
            $table->string('note')->nullable();
            $table->string('money')->nullable();
            $table->string('money_proof1')->comment('付款凭证')->nullable();
            $table->string('money_proof2')->comment('付款凭证')->nullable();
            $table->string('money_proof3')->comment('付款凭证')->nullable();
            $table->string('money_sort')->nullable()->comment('付款类型');
            $table->string('name')->nullable()->comment('仓库名称')->nullable();
            $table->string('location')->nullable()->comment('库位号')->nullable();
            $table->string('take_user')->nullable();
            $table->string('into_user')->nullable();
            $table->string('out_user')->nullable();
            $table->string('send_user')->nullable();
            $table->string('order_time')->nullable();
            $table->string('take_time')->nullable();
            $table->string('into_time')->nullable();
            $table->string('check_time')->nullable();
            $table->string('pay_time')->nullable();
            $table->string('confirm_time')->nullable();
            $table->string('out_time')->nullable();
            $table->string('send_time')->nullable();
            $table->string('state')->comment('待取件、待入库、待核价、待付款、待确认、待出库、待发出、已邮寄')->nullable();
            $table->string('photo1')->comment('电子存根照片')->nullable();
            $table->string('photo2')->comment('电子存根照片')->nullable();
            $table->string('photo3')->comment('电子存根照片')->nullable();
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mail_number')->nullable();
            $table->string('sort')->default('')->comment('物品类别')->nullable();
            $table->string('number')->default('')->comment('物品数量')->nullable();
            $table->string('weight')->default('')->comment('物品重量')->nullable();
            $table->string('money')->default('')->comment('相关费用')->nullable();
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
        Schema::dropIfExists('mails');

        Schema::dropIfExists('items');
    }
}
