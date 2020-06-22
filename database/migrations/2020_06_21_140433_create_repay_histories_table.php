<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepayHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repay_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->decimal('amount');
            $table->timestamps();

            $table->foreign('application_id')
                ->references('id')
                ->on('loan_applications')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repay_histories');
    }
}
