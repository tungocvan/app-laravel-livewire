@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Danh sách câu hỏi trắc nghiệm - ') }}
                    Thời gian còn lại: <span id="timer"></span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="quiz-form" action="{{ route('quiz.submit') }}" method="POST">
                        @csrf
                        @foreach ($questions as $question)
                            <div class="question">
                                <h3>Câu hỏi: {{ $question->parsed_details['content'] }}</h3>

                                <ul>
                                    @foreach ($question->parsed_details['answers'] as $index => $answer)
                                        <li>
                                            <input type="radio" name="question_{{ $question->id }}" value="{{ $index }}" id="answer_{{ $question->id }}_{{ $index }}">
                                            <label for="answer_{{ $question->id }}_{{ $index }}">{{ $answer }}</label>
                                        </li>
                                    @endforeach
                                </ul>

                                <hr>
                            </div>
                        @endforeach

                        <button type="submit">Nộp bài</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
{{-- https://www.daterangepicker.com/#examples  --}}
@stop
<script>
    // Thời gian làm bài tính bằng giây (ví dụ: 10 phút = 600 giây)
    let timeRemaining = 60;

    // Hàm cập nhật thời gian trên giao diện
    function updateTimer() {
        let minutes = Math.floor(timeRemaining / 60);
        let seconds = timeRemaining % 60;
        document.getElementById('timer').textContent = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;

        // Khi hết thời gian, tự động nộp bài
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            document.getElementById('quiz-form').submit();
        }
        timeRemaining--;
    }

    // Cập nhật đồng hồ đếm ngược mỗi giây
    let timerInterval = setInterval(updateTimer, 1000);

    // window.onload = function() {
    //     updateTimer();
    // };
    document.addEventListener('DOMContentLoaded', function(event) {

        updateTimer();
    });
</script>
