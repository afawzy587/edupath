<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserExportController extends Controller
{
    public function __invoke(Request $request, string $type): StreamedResponse
    {
        abort_unless(in_array($type, ['hobbies', 'assessments'], true), 404);

        $search = trim((string) $request->query('search', ''));

        $questions = Question::query()
            ->with('translations')
            ->where('type', $type)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        $questionIds = $questions->pluck('id');

        $students = User::query()
            ->where('type', 'student')
            ->when($search !== '', fn($query) => $query->where('name', 'like', '%'.$search.'%'))
            ->with([
                'answers' => fn($query) => $query->whereIn('question_id', $questionIds),
            ])
            ->orderBy('name')
            ->orderBy('id')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = array_merge(
            ['Student Name', 'Email', 'School'],
            $questions->map(fn($question) => (string) $question->title)->all()
        );

        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($students as $student) {
            $answersByQuestion = $student->answers->pluck('value', 'question_id');

            $rowData = array_merge(
                [
                    $student->name,
                    $student->email,
                    $student->school,
                ],
                $questions->map(fn($question) => $answersByQuestion->get($question->id, '—'))->all()
            );

            $sheet->fromArray($rowData, null, 'A'.$row);
            $row++;
        }

        $totalColumns = max(count($headers), 1);
        for ($index = 1; $index <= $totalColumns; $index++) {
            $column = Coordinate::stringFromColumnIndex($index);
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $fileName = 'users_'.$type.'_report_'.now()->format('Ymd_His').'.xlsx';

        return response()->streamDownload(function () use ($spreadsheet): void {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            $spreadsheet->disconnectWorksheets();
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
