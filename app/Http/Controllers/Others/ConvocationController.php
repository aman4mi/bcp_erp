<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConvocationGuestRequest;
use App\Models\BcpsGoldenJubileeGuest;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Exports\BcpsGoldenJubileeExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ConvocationController extends Controller
{

    public function create2()
    {
        return view('others.convocationform');
    }

    public function getSubjectByDegreeType()
    {
        $degtype = $_REQUEST['degtype'];

        //dd("hi");
        if($degtype=='FCPS'){
            $subjects = Subject::where('fcps_flg', 'Y')->get(['id', 'subject_name']);
        } elseif($degtype=='MCPS'){
            $subjects = Subject::where('mcps_flg', 'Y')->get(['id', 'subject_name']);
        }

         return $subjects;
    }

    public function store(ConvocationGuestRequest $request)
    {
        //dd($request->is_spouse_chk);
        if ($request->is_spouse_chk == null) {
            $is_spouse = 0;
        } else if ($request->is_spouse_chk == "on") {
            $is_spouse = 1;
        }
        if ($request->is_origin_cert_rec == null) {
            $is_origin_cert_rec = 0;
        } else if ($request->is_origin_cert_rec == "on") {
            $is_origin_cert_rec = 1;
        }
        if ($request->is_prov_cert_rec == null) {
            $is_prov_cert_rec = 0;
        } else if ($request->is_prov_cert_rec == "on") {
            $is_prov_cert_rec = 1;
        }

        $query = "SELECT id, mem_fellow_radio, fellow_id FROM convocation_guests
        WHERE mem_fellow_radio = '" . $request->mem_fellow_radio . "' AND fellow_id = '" . $request->fellow_id . "'";

        $queryList = DB::select($query);
        // if (count($queryList) > 0) {
        //     return redirect()->back()->with('error', 'This Fellow/Member already registered.');
        // }

        if ($request->file()) {
            $moneyRecFileName = ($request->file('money_rec_file') != null) ? time() . '_mrf_' . $request->fellow_id . '_' . $request->file('money_rec_file')->getClientOriginalName() : " ";
            $moneyRecFilePath = ($request->file('money_rec_file') != null) ? $request->file('money_rec_file')->storeAs('uploads/convocation', $moneyRecFileName, 'public') : " ";

            $imgUpFileName = ($request->file('img_up_file') != null) ? time() . '_iuf_' . $request->fellow_id . '_' . $request->file('img_up_file')->getClientOriginalName() : " ";
            $imgUpFilePath = ($request->file('img_up_file') != null) ? $request->file('img_up_file')->storeAs('uploads/convocation', $imgUpFileName, 'public') : " ";
        }

        $file_id = DB::table('convocation_guests')->insertGetId([
            "mem_fellow_radio" => $request->mem_fellow_radio,
            "fellow_id" => $request->fellow_id,
            "subject_id" => $request->subject_id,
            "exam_year" => $request->exam_year,
            "exam_session" => $request->exam_session,
            "candidate_name" => $request->candidate_name,
            "father_name" => $request->father_name,
            "mailing_addr" => $request->mailing_addr,
            "mobile" => $request->mobile,
            "email" => $request->email,
            "is_spouse_chk" => $is_spouse,
            "is_origin_cert_rec" => $is_origin_cert_rec,
            "is_prov_cert_rec" => $is_prov_cert_rec,
            "spouse_name" => $request->spouse_name,
            "spouse_relation" => $request->spouse_relation,   
            "payment_mode" => $request->payment_mode,
            "reg_fee" => $request->reg_fee,
            "money_receipt_no" => $request->money_receipt_no,
            "bank_name" => $request->bank_name,
            "bank_branch" => $request->bank_branch,
            "date_submission" => $request->date_submission,
            "money_rec_file" => $moneyRecFilePath,
            "img_up_file" => $imgUpFilePath,
        ]);

        return redirect()->back()->with('success', 'Data saved successfully.');
    }

   

}