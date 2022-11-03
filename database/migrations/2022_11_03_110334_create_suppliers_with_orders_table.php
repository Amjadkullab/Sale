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
        Schema::create('suppliers_with_orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('order_type');
            $table->bigInteger('auto_serial');
            $table->bigInteger('DOC_NO');//رقم الفاتورة
            $table->date('order_date');
            $table->bigInteger('supplier_code')->constrained('suppliers');
            $table->tinyInteger('is_approved')->default(0);
            $table->integer('com_code');
            $table->string('notes')->nullable();
            $table->tinyInteger('discount_type')->nullable();
            $table->decimal('discount_percent')->nullable()->default(0);//قيمة نسبة الخصم
            $table->decimal('discount_value')->nullable()->default(0); //قيمة الخصم
            $table->decimal('tax_percent')->nullable()->default(0);//نسبة الضريبة المضافة
            $table->decimal('tax_value')->nullable()->default(0); //قيمة الضريبة
            $table->decimal('total_before_discount')->default(0);//اجمالي الفاتورة قبل الخصم
            $table->decimal('total_cost');//اجمالي الفاتورة قبل الخصم
            $table->bigInteger('account_number')->constrained('suppliers');
            $table->decimal('money_for_account');
            $table->tinyInteger('pill_type');//نوع الفاتورة اجل او كاش
            $table->decimal('what_paid')->nullable()->default(0);
            $table->decimal('what_remain')->nullable()->default(0);
            $table->foreignId('trasuries_transaction_id')->constrained('trasuries_transaction')->nullable();
            $table->decimal('supplier_balance_before');//حالة رصيد المورد قبل الفاتورة
            $table->decimal('supplier_balance_after');//حالة رصيد المورد بعد الفاتورة
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('suppliers_with_orders');
    }
};
