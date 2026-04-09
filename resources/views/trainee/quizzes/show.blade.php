<x-app-layout>
    <x-slot name="header">Quiz: {{ $quiz->title }}</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4 border-primary">
                <div class="card-body bg-light">
                    <h5 class="mb-0 text-primary">Instructions:</h5>
                    <ul class="mb-0 mt-2 small">
                        <li>Read each question carefully.</li>
                        <li>You need at least {{ $quiz->passing_marks }}% to pass and earn a certificate.</li>
                        <li>Click "Submit Quiz" at the bottom when finished.</li>
                    </ul>
                </div>
            </div>

            <form action="{{ route('trainee.quizzes.submit', $course) }}" method="POST">
                @csrf
                @foreach($quiz->questions as $index => $question)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-4">Question {{ $index + 1 }}: {{ $question->question_text }}</h5>
                            
                            <div class="list-group">
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="answers[{{ $question->id }}]" value="a" required>
                                    {{ $question->option_a }}
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="answers[{{ $question->id }}]" value="b">
                                    {{ $question->option_b }}
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="answers[{{ $question->id }}]" value="c">
                                    {{ $question->option_c }}
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="answers[{{ $question->id }}]" value="d">
                                    {{ $question->option_d }}
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="text-center mb-5">
                    <button type="submit" class="btn btn-lg btn-success px-5 py-3 shadow">Submit Quiz</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
