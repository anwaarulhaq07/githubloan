<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UserExport;
use App\Exports\MortageExport;
use App\Exports\CompleteLoanExport;
use App\Exports\CompleteMortageExport;
use App\Exports\CompleteHistoryExport;
use App\Exports\BankHistoryExport;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    //
    function bank_history_excel(Request $request) 
    {
        $from =$request->from_date;
        $to = $request->to_date;
        $bank_id = $request->bank_id;
        return Excel::download(new BankHistoryExport($from,$to,$bank_id), 'users.xlsx');
    }
    function complete_history_excel(Request $request) 
    {
       
        $from =$request->from_date;
        $to = $request->to_date;
        return Excel::download(new CompleteHistoryExport($from,$to), 'users.xlsx');
    }
    function export($id) 
    {
        // return $id;
        return Excel::download(new UserExport($id), 'users.xlsx');
    }
    function complete_export()
    {
        return Excel::download(new CompleteLoanExport, 'users.xlsx');
    }
    function mortage_export($id)
    {
        // return $id;
        return Excel::download(new MortageExport($id), 'users.xlsx');
    }
    function complete_mortage_export()
    {
        return Excel::download(new CompleteMortageExport, 'users.xlsx');
    }
}
