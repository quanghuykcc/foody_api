<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRestaurantIdToFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->integer('restaurant_id')->unsigned();

            $table->foreign('restaurant_id')
                        ->references('id')
                        ->on('restaurants')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foods', function(Blueprint $table) {
            $table->dropForeign('foods_restaurant_id_foreign');

            $table->dropColumn('restaurant_id');
        });
    }
}
