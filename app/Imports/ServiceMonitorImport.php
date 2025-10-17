<?php

namespace App\Imports;
use Carbon\Carbon;
use App\Models\serviceTickets;
use Maatwebsite\Excel\Concerns\ToModel;

class ServiceMonitorImport implements ToModel
{
    public function model(array $row)
    {
        // Skip header row
        if ($row[1] === 'Item Category') {
            return null;
        }
        //logger('6 date'.$row[6]);
        return  serviceTickets::firstOrCreate(
             ['service_id' => $row[2]],
             [
            'item_category'=> $row[1],
            'service_id'=>$row[2],
            'sold_to_party'=> $row[3],
            'mobile_no'=> $row[4],
            'description'=> $row[5],
            'created_on'=>!empty($row[6]) ? Carbon::createFromFormat('d.m.Y', $row[6])->format('Y-m-d') : null,//\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]),
            'user_status'=> $row[7],
            'category'=> $row[8],
            'product'=> $row[9],
            'service_Tech'=> $row[10],
            'site_code'=> $row[11],
            'call_bifurcation'=> $row[12],
            'part_Required'=> $row[13],
            'changed_on'=>!empty($row[14]) ? Carbon::createFromFormat('d.m.Y', $row[14])->format('Y-m-d') : null, //\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]),
            'call_completion_date'=>!empty($row[15]) ? Carbon::createFromFormat('d.m.Y', $row[15])->format('Y-m-d') : null, //\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
            'serial_no'=> $row[16],
            'brand'=> $row[17],
            'sales_office'=> $row[18],
            'confirmation_no'=> $row[19],
            'transaction_type'=> $row[20],
            'status'=> $row[21],
            'availability'=> $row[22],
            'higher_level_item'=> $row[23],
            'sla'=> $row[24],
            'billing'=> $row[25],
            'bill_to_party'=> $row[26],
            'pr_number'=> $row[27],
            'invoice_number'=> $row[28],
            'sto_number'=> $row[29],
            'so_number'=> $row[30],
            'article_code'=> $row[31],
            'address'=> $row[32],
            'service_characteristi'=> $row[33],
            'product_source'=> $row[34],
            'state'=> $row[35],
            'city'=> $row[36]
        ]);
    }
    
    /*public function collection(Collection $rows)
    {
        dd($rows); // See what’s being imported
    }*/
    
}
