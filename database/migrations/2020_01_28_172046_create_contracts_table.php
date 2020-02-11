<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamp('date_begin');
            
            $table->timestamp('date_end');

            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties');
            
            $table->unsignedBigInteger('property_owner_id');
            $table->foreign('property_owner_id')->references('id')->on('property_owners');

            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants');
            
            $table->double('price');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
