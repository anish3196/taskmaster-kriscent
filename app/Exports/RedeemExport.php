<?php
  
namespace App\Exports;
  
use App\Models\Points;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
  
class RedeemExport implements FromCollection, WithHeadings, WithStrictNullComparison, ShouldAutoSize
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('points')
        ->join('users', 'points.user_id', '=', 'users.id')
        ->leftJoin('redeemproducts', 'points.redeem_product_id', '=', 'redeemproducts.id')
        ->select('users.name','users.user_type','points.point','points.remain_point','points.scan_date','points.scan_time','redeemproducts.name as proname','points.upi_id','points.account_name','points.account_no','points.account_ifsc')
        ->where('redeem',1)
        ->get();
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["User Name","User Type (1 - dealer;4- retailer;3- electrician;2 - distributor)","Point", "Remaining Point", "Scan date","Scan time","Product name","UPI Id","Bank account name","Account No.","Ifsc code"];
    }
}