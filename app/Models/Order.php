<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_address_type','from_first_name','from_last_name','from_company','from_street_1','from_street_2','from_city',
        'from_state','from_zipcode','from_phone_number','from_save_to_address_book','from_make_address_default',

        'to_address_type','to_save_to_address_book','to_first_name','to_last_name','to_zipcode','to_phone_number','to_email',
        'to_street_1','to_city','to_state',

        'package_weight','package_length','package_width','package_height','package_description','package_shipment_date',

        'shipping_service_type','shipping_amount',

        'stripe_charge_id','stripe_amount_captured','stripe_balance_transaction_id','stripe_is_captured',
        'stripe_txn_created_at','stripe_receipt_url','stripe_status','stripe_response',

        'fedex_master_tracking_number','fedex_ship_datestamp','fedex_service_name','fedex_service_category',
        'fedex_delivery_datestamp','fedex_carrier_code','fedex_image_type','fedex_image','fedex_status_code',"fedex_response",
    ];
}
