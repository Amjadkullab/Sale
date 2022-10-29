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
        Schema::create('customers', function (Blueprint $table) {

            $table->id();
            $table->string('name',225);
            $table->foreignId('account_number')->constrained('accounts');
            $table->bigInteger('customer_code');// رقم الحساب المالي على مستوى الشركة
            $table->decimal('start_balance');// رصيد ابتدائي// دائن او مدين او متزن او المدة
            $table->tinyInteger('start_balance_status'); // رصيد ابتدائي// دائن او مدين او متزن او المدة
            $table->decimal('current_balance');// رصيد الحساب الحالي
            $table->string('notes')->nullable();
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->dateTime('date');
            $table->tinyInteger('active')->default(0);
            $table->integer('com_code');
            $table->integer('city_id')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
