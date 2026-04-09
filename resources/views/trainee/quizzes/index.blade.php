<x-app-layout>
    <x-slot name="header">My Quizzes</x-slot>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Completed Quizzes</h5>
            
            @if($results->isEmpty())
                <div class="alert alert-info border-0 shadow-sm text-center py-4">
                    <i class="fas fa-info-circle fa-2x mb-3 text-info"></i>
                    <p class="mb-0">You have hasn't completed any quizzes yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Course</th>
                                <th>Quiz Title</th>
                                <th>Score</th>
                                <th>Status</th>
                                <th>Completed On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                                <tr>
                                    <td>
                                        <a href="{{ route('trainee.courses.show', $result->quiz->course) }}" class="text-decoration-none fw-bold">
                                            {{ $result->quiz->course->title }}
                                        </a>
                                    </td>
                                    <td>{{ $result->quiz->title }}</td>
                                    <td>
                                        <span class="fs-5 fw-bold {{ $result->passed ? 'text-success' : 'text-danger' }}">
                                            {{ $result->score }}%
                                        </span>
                                    </td>
                                    <td>
                                        @if($result->passed)
                                            <span class="badge bg-success px-2 py-1"><i class="fas fa-check-circle me-1"></i> Passed</span>
                                        @else
                                            <span class="badge bg-danger px-2 py-1"><i class="fas fa-times-circle me-1"></i> Failed</span>
                                        @endif
                                    </td>
                                    <td>{{ $result->created_at->format('M d, Y h:i A') }}</td>
                                    <td>
                                        <a href="{{ route('trainee.quizzes.result', $result->quiz->course) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> View Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
