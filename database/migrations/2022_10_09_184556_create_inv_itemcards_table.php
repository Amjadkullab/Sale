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
        Schema::create('inv_itemcards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('item_type'); // مخزني ..استهلاكي .. عهدة
            $table->foreignId('inv_itemcard_categories_id')->constrained('inv_itemcard_categories');
            $table->bigInteger('parent_inv_itemcard_id');// كود الصنف الاب له
            $table->tinyInteger('does_has_retailunit');//    هل للصنف وحدة تجزئة
            $table->foreignId('retail_uom_id')->constrained('inv_uoms'); // كود وحدة قياس التجزئة
            $table->foreignId('uom_id')->constrained('inv_uoms'); // كود وحدة قياس الاب
            $table->decimal('price');//السعر القطاعي بوحدة القياس الاساسية
            $table->decimal('nos_gomla_price');//سعر النص جملة مع الوحدة الاب
            $table->decimal('gomla_price');//سعر الجملة مع وحدة القياس الاساسية
            $table->decimal('price_retail');//لسعر القطاعي بوحدة القياس التجزئة
            $table->decimal('nos_gomla_price_retail');//سعر النص جملة مع الوحدة التجزئة
            $table->decimal('gomla_price_retail');//سعر  جملة مع الوحدة التجزئة
            $table->decimal('retail_uom_quntToParent'); // عدد وحدات التجزئة بالنسبة للوحدة الاب
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->integer('com_code');
            $table->date('date');
            $table->tinyInteger('active')->default(1);
            $table->bigInteger('item_code');
            $table->string('barcode');
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
        Schema::dropIfExists('inv_itemcards');
    }
};
