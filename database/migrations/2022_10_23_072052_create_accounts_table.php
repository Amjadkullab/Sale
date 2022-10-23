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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name',225);
            $table->foreignId('account_types_id')->constrained('accounts_types');
            $table->integer('parent_account_number');  //كود الحساب الاب
            $table->integer('account_number');// رقم الحساب المالي على مستوى الشركة
            $table->decimal('start_balance'); // رصيد ابتدائي// دائن او مدين او متزن او المدة
            $table->integer('added_by');
            $table->dateTime('date');
            $table->integer('updated_by')->nullable();
            $table->dateTime('last_update');
            $table->integer('com_code');
            $table->tinyInteger('is_archived')->default(1);
            $table->decimal('current_balance');// رصيد الحساب الحالي
            $table->string('notes');
            $table->integer('other_table_FK');
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
        Schema::dropIfExists('accounts');
    }
};
