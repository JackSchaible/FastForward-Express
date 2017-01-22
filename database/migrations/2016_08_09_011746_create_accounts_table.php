<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('account_id');
            $table->unsignedInteger('rate_type_id');
            $table->unsignedInteger('parent_account_id')->nullable();
            $table->unsignedInteger('billing_address_id')->nullable();
            $table->unsignedInteger('shipping_address_id');
            $table->string('account_number')->nullable();
            $table->string('invoice_interval');
            $table->string('stripe_id')->nullable();
            $table->string('name');
            $table->timestamp('start_date');
            $table->boolean('send_bills');
            $table->boolean('is_master');
            $table->boolean('gst_exempt');
            $table->boolean('charge_interest');
            $table->boolean('can_be_parent');
            $table->string('custom_field')->nullable();

			$table->unique('account_number');
			$table->foreign('rate_type_id')->references('rate_type_id')->on('rate_types');
			$table->foreign('billing_address_id')->references('address_id')->on('addresses');
            $table->foreign('shipping_address_id')->references('address_id')->on('addresses');
			$table->foreign('parent_account_id')->references('account_id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accounts');
    }
}
