<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Option;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->longText('value')->nullable();
            $table->string('excerpt')->nullable();

        });

        Option::create(['name'=>'title','excerpt'=>'网站名称']);
        Option::create(['name'=>'slogan','excerpt'=>'网站标语']);
        Option::create(['name'=>'keywords','excerpt'=>'网站关键词']);
        Option::create(['name'=>'description','excerpt'=>'网站简介']);
        Option::create(['name'=>'copyright','excerpt'=>'网站版权']);
        Option::create(['name'=>'icp','excerpt'=>'网站备案']);
        Option::create(['name'=>'logo','excerpt'=>'网站LOGO']);
        Option::create(['name'=>'phone','excerpt'=>'网站联系电话']);
        Option::create(['name'=>'email','excerpt'=>'网站联系邮箱']);
        Option::create(['name'=>'address','excerpt'=>'公司地址']);
        Option::create(['name'=>'dashboardLang','excerpt'=>'后台语言']);
        Option::create(['name'=>'frontLang','excerpt'=>'前台语言']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
};
