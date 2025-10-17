<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serviceTickets extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'item_category',
        'service_id',
        'sold_to_party',	
        'mobile_no',
        'description',
        'created_on',
        'user_status',
        'category',
        'product',
        'service_Tech',
        'site_code',
        'call_bifurcation',
        'part_Required',
        'changed_on',
        'call_completion_date',
        'serial_no',
        'brand',
        'sales_office',
        'confirmation_no',
        'transaction_type',
        'status',
        'availability',
        'higher_level_item',
        'sla',
        'billing',
        'bill_to_party',
        'pr_number',
        'invoice_number',
        'sto_number',
        'so_number',
        'article_code',
        'address',
        'service_characteristi',
        'product_source',
        'state',
        'city'
    ];
}
