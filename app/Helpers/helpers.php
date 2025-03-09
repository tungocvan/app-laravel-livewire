<?php

use Carbon\Carbon;

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}

function parseQuestionDetails($questionDetails) {
    // Loại bỏ dấu [] bao quanh các phần tử
    //dd($questionDetails);
    //preg_match('/\[(.*?)\]\[(.*?)\]\[(.*?)\]/', $questionDetails, $matches);
    preg_match('/\[(.*?)\]\[(.*?)\]\[(.*?)\]/s', $questionDetails, $matches);

   //dd($matches);

    // Kiểm tra nếu có đúng 3 nhóm kết quả: content, answers, correct_answers
    if (count($matches) === 4) {
        // Phân tách từng phần
        $content = $matches[1]; // Nội dung câu hỏi
        $answers = explode('|', $matches[2]); // Các đáp án
        $correct_answers = $matches[3]; // Đáp án đúng
        //dd($correct_answers);
        // Trả về mảng kết quả
        $result =  [
            'content' => $content,
            'answers' => $answers,
            'correct_answers' => $correct_answers, // Chuyển các vị trí đáp án đúng thành số nguyên
        ];

        return $result;
    }

    // Nếu chuỗi không đúng định dạng, trả về null hoặc thông báo lỗi
    return null;
}


function parseQuestions($questionString) {
    // Loại bỏ ký tự không cần thiết ở đầu và cuối
    $questionString = trim($questionString, '[]');

    // Tách từng câu hỏi bằng cách tách các phần tử lớn [[...]]
    $questionParts = explode('],[', $questionString);

    $questions = [];

    foreach ($questionParts as $part) {
        // Loại bỏ các dấu [] còn lại
        $part = trim($part, '[]');

        // Tách các phần tử của câu hỏi (nội dung câu hỏi, đáp án, đáp án đúng)
        $elements = explode('][', $part);

        // Tạo câu hỏi với các đáp án và đáp án đúng
        $questions[] = [
            'content' => $elements[0],
            'answers' => explode('|', $elements[1]),
            'correct_answer' => $elements[2],
        ];
    }

    return $questions;
}
