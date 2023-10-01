<?php
  
namespace App\Exports;
  
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
  
class UsersExport implements FromCollection, WithHeadings, WithStrictNullComparison, ShouldAutoSize
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('users')
        ->join('profiles', 'profiles.user_id', '=', 'users.id')
        ->select('users.id','users.name','users.mobile_no','profiles.address','users.user_type','profiles.update_user','profiles.update_date','users.status')
        ->get();
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["ID", "Name", "Mobile NO.","Address","User Type(1 - dealer;4- retailer;3- electrician;2 - distributor)","Approval by","Approval date","Approval status(1- Approved;3- Rejected;0- Pending)"];
    }
}