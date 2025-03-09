<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;


class QuestionImport implements ToArray
{
    /**
    * @param Collection $collection
    */
    public function array(array $array)
    {
        // Dữ liệu từ file Excel sẽ được trả về dưới dạng mảng.
        return $array;
    }
}
