<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('borrower_id');
            $table->integer('term');
            $table->decimal('amount');
            $table->string('first_name');
            $table->string('last_name');
            $table->decimal('monthly_income');
            $table->string('email');
            $table->string('phone');
            $table->date('dob');
            $table->string('status');
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('borrower_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('loan_applications');
    }
}
