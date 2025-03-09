@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Danh sách câu hỏi trắc nghiệm: - ') }}
                    <p>Thời gian làm bài: {{ $timeRemaining }} phút</p>
                    Thời gian còn lại: <span id="timer"></span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="quiz-form"  action="{{ route('quiz.submit-set', ['id' => $id]) }}" method="POST">
                        @csrf

                        @foreach($questions as $index => $question)
                            <div class="mb-4">
                                <h4>Câu {{ $index + 1 }}: {{ $question['content'] }}</h4>

                                @foreach($question['answers'] as $answerIndex => $answer)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[{{ $index }}]" id="answer{{ $index }}_{{ $answerIndex }}" value="{{ $answerIndex }}" />
                                        <label class="form-check-label" for="answer{{ $index }}_{{ $answerIndex }}">
                                            {{ $answer }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Nộp bài</button>
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
    // Thời gian làm bài tính bằng giây (ví dụ: 10 phút = 60 giây)
    let timeRemaining = {{ $timeRemaining * 60 }};

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
    // document.addEventListener('DOMContentLoaded', function(event) {

    //     updateTimer();

    // });

    document.addEventListener('DOMContentLoaded', function () {
        updateTimer();
    // Lấy tất cả các câu hỏi (các phần tử có class 'mb-4')
    const questions = document.querySelectorAll('.mb-4');

    // Hàm xáo trộn mảng (shuffle)
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]]; // Hoán đổi vị trí
        }
    }

    // Duyệt qua từng câu hỏi
    questions.forEach(question => {
        // Lấy tiêu đề câu hỏi
        const title = question.querySelector('h4');

        // Lấy tất cả các lựa chọn (các phần tử có class 'form-check')
        const answers = Array.from(question.querySelectorAll('.form-check'));

        // Xáo trộn vị trí các lựa chọn
        shuffleArray(answers);

        // Xóa tất cả các lựa chọn hiện tại trong câu hỏi
        answers.forEach(answer => {
            question.removeChild(answer);
        });

        // Thêm lại tiêu đề câu hỏi
        question.appendChild(title);

        // Thêm lại các lựa chọn đã xáo trộn vào câu hỏi
        answers.forEach(answer => {
            question.appendChild(answer);
        });
    });
});
</script>
