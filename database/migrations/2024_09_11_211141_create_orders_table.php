<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('user_id');

            $table->string('from_address_type')->nullable();
            $table->string('from_first_name')->nullable();
            $table->string('from_last_name')->nullable();
            $table->string('from_company')->nullable();
            $table->string('from_street_1')->nullable();
            $table->string('from_street_2')->nullable();
            $table->string('from_city')->nullable();
            $table->string('from_state')->nullable();
            $table->string('from_zipcode')->nullable();
            $table->string('from_phone_number')->nullable();
            $table->string('from_save_to_address_book')->nullable();
            $table->string('from_make_address_default')->nullable();

            $table->string('to_address_type')->nullable();
            $table->string('to_first_name')->nullable();
            $table->string('to_last_name')->nullable();
            $table->string('to_company')->nullable();
            $table->string('to_street_1')->nullable();
            $table->string('to_street_2')->nullable();
            $table->string('to_city')->nullable();
            $table->string('to_state')->nullable();
            $table->string('to_zipcode')->nullable();
            $table->string('to_phone_number')->nullable();
            $table->string('to_email')->nullable();
            $table->string('to_save_to_address_book')->nullable();
            

            $table->string('package_weight')->nullable();
            $table->string('package_length')->nullable();
            $table->string('package_width')->nullable();
            $table->string('package_height')->nullable();
            $table->string('package_description')->nullable();
            $table->string('package_shipment_date')->nullable();
            

            $table->string('shipping_service_type')->nullable();
            $table->string('shipping_amount')->nullable();

            $table->string('stripe_charge_id')->nullable();
            $table->string('stripe_amount_captured')->nullable();
            $table->string('stripe_balance_transaction_id')->nullable();
            $table->string('stripe_is_captured')->nullable();
            $table->string('stripe_txn_created_at')->nullable();
            $table->string('stripe_receipt_url')->nullable();
            $table->string('stripe_status')->nullable();
            $table->json('stripe_response')->nullable();

            $table->string('fedex_master_tracking_number')->nullable();
            $table->string('fedex_ship_datestamp')->nullable();
            $table->string('fedex_service_name')->nullable();
            $table->string('fedex_service_category')->nullable();
            $table->string('fedex_delivery_datestamp')->nullable();
            $table->string('fedex_carrier_code')->nullable();
            $table->string('fedex_image_type')->nullable();
            $table->longText('fedex_image')->nullable();
            $table->string('fedex_status_code')->nullable();
            $table->json("fedex_response")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
