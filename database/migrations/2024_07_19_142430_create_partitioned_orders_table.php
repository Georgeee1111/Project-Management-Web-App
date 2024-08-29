<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Brokenice\LaravelMysqlPartition\Models\Partition;
use Brokenice\LaravelMysqlPartition\Schema\Schema;

class CreatePartitionedOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', static function (Blueprint $table) {
            $table->bigInteger('order_id');
            $table->date('order_date');
            $table->integer('customer_id');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->primary(['order_id', 'order_date']);
        });

        // Force autoincrement of one field in composite primary key
        Schema::forceAutoIncrement('orders', 'order_id');
        
        // Make partition by RANGE on YEAR(order_date)
        Schema::partitionByRange('orders', 'YEAR(order_date)',
            [
                new Partition('p2022', Partition::RANGE_TYPE, 2022),
                new Partition('p2023', Partition::RANGE_TYPE, 2023),
                new Partition('p2024', Partition::RANGE_TYPE, 2024)
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
