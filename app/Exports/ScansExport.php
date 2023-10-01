<?php
  
namespace App\Exports;
  
use App\Models\Points;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
  
class ScansExport implements FromCollection, WithHeadings, WithStrictNullComparison, ShouldAutoSize
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('points')
        ->join('users', 'points.user_id', '=', 'users.id')
        ->leftJoin('products', 'points.product_id', '=', 'products.id')
        ->select('points.point','points.coupon_code','points.whole_pro_code','points.address','points.city','points.state','users.name as username', 'users.user_type','products.name as productname','points.scan_date','points.scan_time')
        ->where('redeem','!=',1)
        ->get();
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Point","Coupon code","Product code", "Address","City", "State","User name","User Type (1 - dealer;4- retailer;3- electrician;2 - distributor)","Product name","Scan Date","Scan Time"];
    }
}