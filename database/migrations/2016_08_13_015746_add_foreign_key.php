<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function ($table) {

            $table->foreign('commenter_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');


            $table->foreign('restaurant_id')
                        ->references('id')
                        ->on('restaurants')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        
        });

        Schema::table('restaurants', function ($table) {

            $table->foreign('category_id')
                        ->references('id')
                        ->on('categories')
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
        Schema::table('comments', function(Blueprint $table) {
            $table->dropForeign('comments_commenter_id_foreign');

            $table->dropForeign('comments_restaurant_id_foreign');
        });

        Schema::table('restaurants', function(Blueprint $table) {
            $table->dropForeign('restaurants_category_id_foreign');
        });
    }
}
