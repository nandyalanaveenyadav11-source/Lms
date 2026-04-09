<x-app-layout>
    <x-slot name="header">Quiz Result</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 text-center mb-5">
                <div class="card-body py-5">
                    @if($result->passed)
                        <div class="mb-4">
                            <i class="fas fa-trophy fa-5x text-warning"></i>
                        </div>
                        <h2 class="text-success fw-bold">Congratulations!</h2>
                        <p class="lead">You have passed the quiz with a score of <strong>{{ $result->score }}%</strong>.</p>
                        <hr>
                        <p>Your certificate is now available for download.</p>
                        <div class="mt-4">
                            <a href="{{ route('trainee.certificates.index') }}" class="btn btn-primary btn-lg px-4">View My Certificates</a>
                        </div>
                    @else
                        <div class="mb-4">
                            <i class="fas fa-times-circle fa-5x text-danger"></i>
                        </div>
                        <h2 class="text-danger fw-bold">Better Luck Next Time!</h2>
                        <p class="lead">You scored <strong>{{ $result->score }}%</strong>. You need at least {{ $quiz->passing_marks }}% to pass.</p>
                        <hr>
                        <p>You can review the course material and try again.</p>
                        <div class="mt-4">
                            <a href="{{ route('trainee.courses.show', $course) }}" class="btn btn-outline-primary btn-lg px-4">Back to Course</a>
                        </div>
                    @endif
                </div>
            </div>

            <h3 class="mb-4">Quiz Review</h3>
            @foreach($questions as $index => $question)
                @php
                    $userAnswer = isset($userAnswers[$question->id]) ? strtolower($userAnswers[$question->id]) : null;
                    $correctAnswer = strtolower($question->correct_answer);
                    $isCorrect = $userAnswer === $correctAnswer;
                @endphp
                <div class="card mb-4 shadow-sm border-0 {{ $isCorrect ? 'border-start border-success border-4' : 'border-start border-danger border-4' }}">
                    <div class="card-body">
                        <h5 class="mb-4">Question {{ $index + 1 }}: {{ $question->question_text }}</h5>
                        
                        <div class="list-group">
                            @foreach(['a', 'b', 'c', 'd'] as $optionKey)
                                @php
                                    $optionText = 'option_' . $optionKey;
                                    $isUserChoice = $userAnswer === $optionKey;
                                    $isCorrectChoice = $correctAnswer === $optionKey;
                                    
                                    $bgClass = '';
                                    if ($isCorrectChoice) {
                                        $bgClass = 'list-group-item-success';
                                    } elseif ($isUserChoice && !$isCorrect) {
                                        $bgClass = 'list-group-item-danger';
                                    }
                                @endphp
                                <div class="list-group-item {{ $bgClass }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ strtoupper($optionKey) }}.</strong> {{ $question->$optionText }}
                                        </div>
                                        <div>
                                            @if($isCorrectChoice)
                                                <i class="fas fa-check-circle text-success fs-5"></i>
                                            @elseif($isUserChoice && !$isCorrect)
                                                <i class="fas fa-times-circle text-danger fs-5"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
