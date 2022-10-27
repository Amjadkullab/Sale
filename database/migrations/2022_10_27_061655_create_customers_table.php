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
            $table->integer('account_number');// رقم الحساب المالي على مستوى الشركة
            $table->decimal('start_balance'); // رصيد ابتدائي// دائن او مدين او متزن او المدة
            $table->tinyInteger('start_balance_status'); // رصيد ابتدائي// دائن او مدين او متزن او المدة
            $table->integer('added_by');
            $table->dateTime('date');
            $table->integer('updated_by')->nullable();
            $table->integer('com_code');
            $table->tinyInteger('is_archived')->default(1);
            $table->decimal('current_balance');// رصيد الحساب الحالي
            $table->string('notes');
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
