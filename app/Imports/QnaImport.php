<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Answer;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
//use Maatwebsite\Excel\Facades\Excel;

class QnaImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        Log::info("row");

        if ($row[0] != 'question' && !is_null($row[0]) && trim($row[0]) !== '') {

            $questionId = Question::insertGetId([
                'question' => $row[0]
            ]);

            for ($i = 1; $i < count($row) - 1; $i++) {
                if ($row[$i] != null) {

                    $is_correct = 0;
                    if ($row[7] == $row[$i]) {
                        $is_correct = 1;
                    }

                    Answer::insert([
                        'questions_id' => $questionId,
                        'answer' => $row[$i],
                        'is_correct' => $is_correct
                    ]);
                }
            }
        } else {
            Log::warning("Skipping row with empty question or header row: " . json_encode($row));
        }

        // return new Question([
        //     //
        // ]);
    }
}
