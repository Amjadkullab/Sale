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
        Schema::create('suppliers_with_orders_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('suppliers_with_orders_auto_serial')->constrained('suppliers_with_orders');
            $table->tinyInteger('order_type');
            $table->integer('com_code');
            $table->decimal('deliverd_quantity');
            $table->integer('uom_id');
            $table->tinyInteger('isMain_retail_uom');
            $table->decimal('unit_price');
            $table->decimal('total_price');
            $table->date('order_date');
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->integer('item_code'); // كود الصنف
            // $table->foreignId('batch_id')->constrained('batches'); // رقم المخزن التي يتم تخزين الصنف بها
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
        Schema::dropIfExists('suppliers_with_orders_details');
    }
};
