@extends('layouts.app')

@section('content')
<div class="container" x-data="exportPdf">
    <div id="result" class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Kết quả trắc nghiệm') }} - <a href="{{ route('student.index') }}">Quay lại</a></div>
                <div class="card-body">
                    <p><strong>Họ và tên: <span> {{$name}}</span></strong></p>
                    <p>Tổng số câu: <span> {{$total['total']}}</span></p>
                    <p>Số câu trả lời đúng:<span> {{$total['right']}}</span></p>
                    <p>Số câu trả lời sai: <span> {{$total['wrong']}}</span></p>
                    <p>Chưa trả lời: <span> {{$total['noAnswer']}}</span></p>
                    <p>Đạt tỉ lệ: <span> {{$total['tile']}}%</span></p>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($results as $index => $result)
                        <div class="mb-4">
                            <h4>Câu {{ $index + 1 }}: {{ $result['question'] }}</h4>

                            @foreach($result['answers'] as $answerIndex => $answer)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answers[{{ $index }}]" id="answer{{ $index }}_{{ $answerIndex }}" value="{{ $answerIndex }}" disabled
                                        @if($result['user_answer'] == $answerIndex && $result['user_answer']!==null) checked @endif>
                                    <label class="form-check-label" for="answer{{ $index }}_{{ $answerIndex }}">
                                        {{ $answer }}
                                        @if($answerIndex == $result['correct_answer'] && $result['user_answer']!==null)
                                            <span class="text-success">✔</span>
                                        @elseif($result['user_answer'] == $answerIndex && $result['user_answer']!==null)
                                            <span class="text-danger">✘</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <a href="{{ route('student.index') }}">Quay lại</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>

document.addEventListener('DOMContentLoaded', function () {
    const element = document.getElementById('result');
            html2canvas(element, {
                scale: 1,
                useCORS: true,
                logging: false,
                allowTaint: true,
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/jpeg', 0.8);
                const pdf = new jspdf.jsPDF('p', 'mm', 'a4');

                const imgWidth = 210;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                const a4Height = 297;
                const marginTop = 5;
                const marginBottom = 5;
                const contentHeight = a4Height - marginTop - marginBottom;

                let position = 0;

                while (position < imgHeight) {
                    if (position > 0) {
                        pdf.addPage();
                    }

                    const remainingHeight = imgHeight - position;
                    const renderHeight = Math.min(remainingHeight, contentHeight);
                    const yPosition = -position + marginTop;
                    pdf.addImage(
                        imgData,
                        'JPEG',
                        0,
                        yPosition,
                        imgWidth,
                        renderHeight
                    );

                    position += contentHeight;
                }

                // Save PDF to Blob
                const pdfBlob = pdf.output('blob');
                const formData = new FormData();
                formData.append('pdf', pdfBlob, 'result.pdf');

                // Upload PDF to server
                fetch('/upload-pdf', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Upload successful:', data);
                })
                .catch(error => {
                    console.error('Upload failed:', error);
                });
            });
});

    </script>

@stop
