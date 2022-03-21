<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExamInfoUpdateExport implements FromCollection, WithHeadings, WithEvents
{

    public function __construct($exam_year, $exam_session, $subject_id)
    {
        $this->examYear = $exam_year;
        $this->examSession = $exam_session;
        $this->subjectId = $subject_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     * https://www.schemecolor.com/sample?getcolor=55FFC1
     * https://phpspreadsheet.readthedocs.io/en/latest/topics/recipes/#styles
     * https://phpoffice.github.io/PhpSpreadsheet/classes/PhpOffice-PhpSpreadsheet-Style-Color.html#constant_VALIDATE_ARGB_SIZE
     */
    public function collection()
    {
        if ($this->subjectId == -1) {

            return $data = DB::table('exam_info_updates')
                ->join('subjects', 'subjects.id', '=', 'exam_info_updates.subject_id')
                ->join('training_institutes as ti0', 'ti0.id', '=', 'exam_info_updates.training_institute_id')
                ->join('training_institutes as ti1', 'ti1.id', '=', 'exam_info_updates.course_institute_id')
                ->select('exam_info_updates.exam_year',
                    'exam_info_updates.exam_session',
                    'exam_info_updates.roll_no',
                    'exam_info_updates.bmdc_reg_no',
                    'exam_info_updates.candidate_name',
                    'subjects.subject_name',
                    'exam_info_updates.course_year',
                    'exam_info_updates.course_director',
                    'ti0.institute_name as training_inst',
                    'exam_info_updates.other_training_institute_name',
                    'exam_info_updates.institute_head',
                    'exam_info_updates.mobile',
                    'exam_info_updates.trainer_name',
                    'ti1.institute_name as courseinst',
                    'exam_info_updates.other_course_institute_name')
                ->where('exam_info_updates.exam_year', '=', $this->examYear)
                ->where('exam_info_updates.exam_session', '=', $this->examSession)
                ->get();
        } else {
            return $data = DB::table('exam_info_updates')
                ->join('subjects', 'subjects.id', '=', 'exam_info_updates.subject_id')
                ->join('training_institutes as ti0', 'ti0.id', '=', 'exam_info_updates.training_institute_id')
                ->join('training_institutes as ti1', 'ti1.id', '=', 'exam_info_updates.course_institute_id')
                ->select('exam_info_updates.exam_year',
                    'exam_info_updates.exam_session',
                    'exam_info_updates.roll_no',
                    'exam_info_updates.bmdc_reg_no',
                    'exam_info_updates.candidate_name',
                    'subjects.subject_name',
                    'exam_info_updates.course_year',
                    'exam_info_updates.course_director',
                    'ti0.institute_name as training_inst',
                    'exam_info_updates.other_training_institute_name',
                    'exam_info_updates.institute_head',
                    'exam_info_updates.mobile',
                    'exam_info_updates.trainer_name',
                    'ti1.institute_name as courseinst',
                    'exam_info_updates.other_course_institute_name')
                ->where('exam_info_updates.exam_year', '=', $this->examYear)
                ->where('exam_info_updates.exam_session', '=', $this->examSession)
                ->where('exam_info_updates.subject_id', '=', $this->subjectId)
                ->get();
        }

    }

    public function headings(): array
    {
        return [
            'Year',
            'Session',
            'Roll',
            'BMDC',
            'Name of Candidate',
            'Subject',
            'Course Year',
            'Course Director',
            'Last Training Institute',
            'Last Training Institute (If Others)',
            'Institute Head',
            'Mobile',
            'Last Trainer Name',
            'Last Course Institute',
            'Last Course Institute (If Others)',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:O1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                // ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW);FFB2FF8B
                    ->setARGB('FFF16F42');
            },
        ];
    }
}