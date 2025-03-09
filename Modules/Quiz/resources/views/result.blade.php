@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Kết quả trắc nghiệm') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @foreach ($results as $result)
            <div class="question">
                <h3>Câu hỏi: {{ $result['question'] }}</h3>

                <ul class="answer-list">
                    @foreach ($result['correct_answers'] as $correctAnswer)
                        @foreach ($result['parsed_details']['answers'] as $index => $answer)
                            <li>
                                @if ($index == $correctAnswer && $result['user_answer'] == $correctAnswer)
                                    <!-- Đáp án đúng và người dùng chọn đúng -->
                                    <span class="icon correct">✔</span>
                                    <span class="correct">{{ $answer }}</span>
                                @elseif ($index == $correctAnswer)
                                    <!-- Đáp án đúng nhưng người dùng không chọn -->
                                    <span class="icon correct">✔</span>
                                    <span class="correct">{{ $answer }}</span>
                                @elseif ($index == $result['user_answer'])
                                    <!-- Đáp án người dùng chọn sai -->
                                    <span class="icon wrong">✘</span>
                                    <span class="wrong">{{ $answer }}</span>
                                @else
                                    <!-- Đáp án không được chọn -->
                                    <span>{{ $answer }}</span>
                                @endif
                            </li>
                        @endforeach
                    @endforeach
                </ul>

                <hr>
            </div>
        @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
