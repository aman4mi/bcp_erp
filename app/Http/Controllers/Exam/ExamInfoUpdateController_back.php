<?php

namespace App\Http\Controllers\Exam;

use App\Exports\ExamInfoUpdateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamInfoUpdateRequest;
use App\Models\ExamInfoUpdate;
use App\Models\Subject;
use App\Models\TrainingInstitute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExamInfoUpdateController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subjects = Subject::where('active', true)->get();
        $institutes = TrainingInstitute::where('active', true)->get();
        return view('exam.exam-info-update', [
            'subjects' => $subjects,
            'institutes' => $institutes]
        );
    }

    public function store(ExamInfoUpdateRequest $request)
    {
        $query = "SELECT eiu.id, eiu.exam_year, eiu.exam_session, eiu.roll_no, eiu.bmdc_reg_no, eiu.candidate_name
                         FROM exam_info_updates AS eiu
                         WHERE eiu.exam_year = '" . $request->exam_year . "' AND eiu.exam_session = '" . $request->exam_session . "'  AND eiu.roll_no =" . $request->roll_no;

        $queryList = DB::select($query);
        if (count($queryList) > 0) {
            return redirect()->back()->with('error', 'Data already exists');
        }

        ExamInfoUpdate::create(array_merge($request->all()));
        return redirect()->back()->with('success', 'Data saved successfully.');
    }

    public function examInfoUpdateFileExport(Request $request)
    {
        $exam_year = $request->exam_year;
        $exam_session = $request->exam_session;
        $subject_id = $request->subject_id;

        return Excel::download(new ExamInfoUpdateExport($exam_year, $exam_session, $subject_id), 'exam-info-update-data.xlsx');
    }

    public function show()
    {
        $subjects = Subject::where('active', true)->get();
        return view('exam.list-exam-info-update', ['subjects' => $subjects]);
    }

    public function edit($id)
    {
        {
            $subjects = Subject::where('active', true)->get();
            $institutes = TrainingInstitute::where('active', true)->get();

            return view('exam.edit-exam-info-update', [
                'examInfo' => ExamInfoUpdate::findOrFail($id),
                'subjects' => $subjects,
                'institutes' => $institutes,
            ]);
        }
    }

    public function getExamUpdateData()
    {
        $query = "SELECT * FROM exam_info_updates";
        $data = DB::select($query);
        return json_encode($data);
    }

    public function deleteData($id)
    {
        dd($id);
        // $xm = ExamInfoUpdate::find($id);
        // $xm->delete();
    }

}