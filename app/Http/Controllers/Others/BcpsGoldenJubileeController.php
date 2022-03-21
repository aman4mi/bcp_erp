<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Http\Requests\BcpsGoldenJubileeGuestRequest;
use App\Models\BcpsGoldenJubileeGuest;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Exports\BcpsGoldenJubileeExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BcpsGoldenJubileeController extends Controller
{

    public function index()
    {
        return view('others.index');
    }

    public function create()
    {
        $subjects = Subject::where('active', true)->get();
        return view('others.goldenjubileeform', [
            'subjects' => $subjects]);
    }

    public function store(BcpsGoldenJubileeGuestRequest $request)
    {
        //dd($request->is_spouse_chk);
        if ($request->is_spouse_chk == null) {
            $is_spouse = 0;
        } else if ($request->is_spouse_chk == "on") {
            $is_spouse = 1;
        }

        $query = "SELECT id, mem_fellow_radio, fellow_id FROM bcps_golden_jubilee_guests
        WHERE mem_fellow_radio = '" . $request->mem_fellow_radio . "' AND fellow_id = '" . $request->fellow_id . "'";

        $queryList = DB::select($query);
        if (count($queryList) > 0) {
            return redirect()->back()->with('error', 'This Fellow/Member already registered.');
        }

        if ($request->file()) {
            $moneyRecFileName = time() . '_' . $request->fellow_id . '_' . $request->file('money_rec_file')->getClientOriginalName();
            $moneyRecFilePath = $request->file('money_rec_file')->storeAs('uploads/jubilee', $moneyRecFileName, 'public');

            $imgUpFileName = ($request->file('img_up_file') != null) ? time() . '_' . $request->fellow_id . '_' . $request->file('img_up_file')->getClientOriginalName() : " ";
            $imgUpFilePath = ($request->file('img_up_file') != null) ? $request->file('img_up_file')->storeAs('uploads/jubilee', $imgUpFileName, 'public') : " ";
        }

        $file_id = DB::table('bcps_golden_jubilee_guests')->insertGetId([
            "mem_fellow_radio" => $request->mem_fellow_radio,
            "fellow_id" => $request->fellow_id,
            "subject_id" => $request->subject_id,
            "profession" => $request->profession,
            "gender" => $request->gender,
            "candidate_name" => $request->candidate_name,
            "institute" => $request->institute,
            "department" => $request->department,
            "mailing_addr" => $request->mailing_addr,
            "mobile" => $request->mobile,
            "email" => $request->email,
            "is_spouse_chk" => $is_spouse,
            "spouse_name" => $request->spouse_name,
            "spouse_mobile" => $request->spouse_mobile,
            "reg_fee" => $request->reg_fee,
            "payment_mode" => $request->payment_mode,
            "bank_name" => $request->bank_name,
            "bank_branch" => $request->bank_branch,
            "money_receipt" => $request->money_receipt,
            "money_rec_file" => $moneyRecFilePath,
            "img_up_file" => $imgUpFilePath,
        ]);

        //BcpsGoldenJubileeGuest::create($request->all());
        return redirect()->back()->with('success', 'Data saved successfully.');
    }

    public function show()
    {
        return view('others.show');
    }

    function list() {
        $data['fellows'] = BcpsGoldenJubileeGuest::where('mem_fellow_radio', 'fcps')->get();
        $data['members'] = BcpsGoldenJubileeGuest::where('mem_fellow_radio', 'mcps')->get();
        return view('others.list', ['data' => $data]);
    }

    function listfellow() {
        $user_type = $_REQUEST['perticipant_type'];
        
        $data = BcpsGoldenJubileeGuest::where('mem_fellow_radio', $user_type)->get();
        return $data;
    }

    public function show_action_list()
    {
        return view('others.actionlist');
    }

    public function goldFileExport(Request $request)
    {
        return Excel::download(new BcpsGoldenJubileeExport(),  time() . '_' .'bcps_golden_jubilee_.xlsx');
    }

    public function stor_link()
    {
        //Artisan::call('storage:link');
        File::link(
            storage_path('app/public'), public_path('storage')
        );
        return 'Storage link created';
    }

    public function cacheclear_link(){
        $exitCode = Artisan::call('route:cache');
        return 'All routes cache has just been removed';
    }

    // public function create2()
    // {
    //     $subjects = Subject::where('active', true)->get();
    //     return view('others.convocationform', [
    //         'subjects' => $subjects]);
    // }

}