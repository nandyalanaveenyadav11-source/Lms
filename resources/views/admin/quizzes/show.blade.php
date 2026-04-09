<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <div>
                <span class="text-muted text-uppercase small fw-bold tracking-wider">Quiz Manager</span>
                <h3 class="fw-bold mb-0" style="color: #0f3a69;">{{ $quiz->title }}</h3>
                <div class="small mt-1"><i class="fas fa-link me-1 text-primary"></i> <span class="text-secondary">{{ $course->title }}</span></div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-soft-info rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal"><i class="fas fa-file-excel me-2"></i> Import Excel/CSV</button>
                <button class="btn btn-gradient-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addQuestionModal"><i class="fas fa-plus me-2"></i> Add Question</button>
            </div>
        </div>
    </x-slot>

    <style>
        .btn-soft-info { background: #e0f2fe; color: #0284c7; border: none; font-weight: 600; transition: all 0.3s; }
        .btn-soft-info:hover { background: #0284c7; color: #ffffff; }
        .btn-gradient-primary { background: linear-gradient(135deg, #0ea5e9, #2563eb); color: white; border: none; font-weight: 600; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2); transition: all 0.3s; }
        .btn-gradient-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3); color: white; }
        
        .question-card {
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        .question-card:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
        .question-header {
            padding: 1.5rem;
            border-bottom: 2px dashed #f1f5f9;
            background: linear-gradient(to right, #ffffff, #fdfdfe);
            border-top-left-radius: 20px; border-top-right-radius: 20px;
        }
        
        .option-badge {
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            border: 2px solid transparent;
            transition: all 0.2s;
        }
        .option-badge.correct { background: #ecfdf5; color: #059669; border-color: #a7f3d0; box-shadow: 0 4px 10px rgba(5, 150, 105, 0.05); }
        .option-badge.incorrect { background: #f8fafc; color: #475569; border-color: #e2e8f0; }
        .option-badge.incorrect:hover { background: #f1f5f9; border-color: #cbd5e1; }
        
        .option-letter {
            width: 28px; height: 28px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 12px; font-size: 0.8rem;
        }
        .option-badge.correct .option-letter { background: #059669; color: white; }
        .option-badge.incorrect .option-letter { background: #e2e8f0; color: #64748b; }
        
        .btn-action-delete { background: #fee2e2; color: #ef4444; border: none; transition: all 0.3s; width: 34px; height: 34px; padding: 0; line-height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; }
        .btn-action-delete:hover { background: #ef4444; color: #ffffff; transform: scale(1.1); }
        
        .modal-content { border-radius: 24px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .modal-header { border-bottom: 1px solid #f1f5f9; padding: 1.75rem 2rem; background: #fdfdfe; border-top-left-radius: 24px; border-top-right-radius: 24px; }
        .modal-title { font-weight: 800; color: #0f3a69; }
        .modal-body { padding: 2rem; }
        .modal-footer { border-top: 1px solid #f1f5f9; padding: 1.5rem 2rem; background: #fdfdfe; border-bottom-left-radius: 24px; border-bottom-right-radius: 24px; }
        .form-control, .form-select { border-radius: 12px; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; font-weight: 500; }
        .form-control:focus, .form-select:focus { border-color: #0ea5e9; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1); outline: none; }
    </style>

    @foreach($quiz->questions as $index => $question)
    <div class="question-card">
        <div class="question-header d-flex justify-content-between align-items-start gap-4">
            <div class="d-flex gap-3 align-items-start">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm flex-shrink-0" style="width: 40px; height: 40px;">
                    {{ $index + 1 }}
                </div>
                <h5 class="mb-0 fw-bold text-dark pt-2" style="line-height: 1.5;">{{ $question->question_text }}</h5>
            </div>
            <div>
                <form action="{{ route('admin.quizzes.questions.destroy', [$quiz, $question]) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-action-delete shadow-sm" onclick="return confirm('Delete this question?')" title="Delete Question"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="option-badge @if($question->correct_answer == 'a') correct @else incorrect @endif">
                        <span class="option-letter">A</span> <span class="flex-grow-1">{{ $question->option_a }}</span>
                        @if($question->correct_answer == 'a') <i class="fas fa-check-circle fs-5 ms-2"></i> @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="option-badge @if($question->correct_answer == 'b') correct @else incorrect @endif">
                        <span class="option-letter">B</span> <span class="flex-grow-1">{{ $question->option_b }}</span>
                        @if($question->correct_answer == 'b') <i class="fas fa-check-circle fs-5 ms-2"></i> @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="option-badge @if($question->correct_answer == 'c') correct @else incorrect @endif">
                        <span class="option-letter">C</span> <span class="flex-grow-1">{{ $question->option_c }}</span>
                        @if($question->correct_answer == 'c') <i class="fas fa-check-circle fs-5 ms-2"></i> @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="option-badge @if($question->correct_answer == 'd') correct @else incorrect @endif">
                        <span class="option-letter">D</span> <span class="flex-grow-1">{{ $question->option_d }}</span>
                        @if($question->correct_answer == 'd') <i class="fas fa-check-circle fs-5 ms-2"></i> @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if($quiz->questions->isEmpty())
        <div class="text-center py-5 bg-white rounded-5 shadow-sm border border-light mt-3">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                <i class="fas fa-question-circle fa-3x text-primary opacity-50"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">No Questions Yet</h4>
            <p class="text-muted mb-4">You completely control the assessment. Add questions to evaluate trainees.</p>
            <button class="btn btn-gradient-primary rounded-pill px-4 py-2 shadow" data-bs-toggle="modal" data-bs-target="#addQuestionModal"><i class="fas fa-plus me-2"></i> Create Your First Question</button>
        </div>
    @endif

    <!-- Add Question Modal -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-edit text-primary me-2"></i>Draft New Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label text-muted fw-bold small text-uppercase">Question Text</label>
                            <textarea name="question_text" class="form-control" rows="3" placeholder="What is the main advantage of..." required></textarea>
                        </div>
                        
                        <div class="p-4 bg-light rounded-4 mb-4">
                            <label class="form-label text-muted fw-bold small text-uppercase mb-3 d-block border-bottom pb-2">Multiple Choice Options</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-white fw-bold text-primary">A</span>
                                        <input type="text" name="option_a" class="form-control border-start-0" placeholder="Option A" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-white fw-bold text-primary">B</span>
                                        <input type="text" name="option_b" class="form-control border-start-0" placeholder="Option B" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-white fw-bold text-primary">C</span>
                                        <input type="text" name="option_c" class="form-control border-start-0" placeholder="Option C" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-white fw-bold text-primary">D</span>
                                        <input type="text" name="option_d" class="form-control border-start-0" placeholder="Option D" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label text-muted fw-bold small text-uppercase">Correct Answer Designation</label>
                            <div class="position-relative">
                                <select name="correct_answer" class="form-select form-control-lg fw-bold text-success border-success" style="background-color: #ecfdf5; cursor: pointer;" required>
                                    <option value="a" selected>Option A is correct</option>
                                    <option value="b">Option B is correct</option>
                                    <option value="c">Option C is correct</option>
                                    <option value="d">Option D is correct</option>
                                </select>
                                <i class="fas fa-check-circle text-success position-absolute top-50 end-0 translate-middle mt-0 me-3 fs-5" style="pointer-events: none;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-primary rounded-pill px-5">Add Question to Quiz</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Import Excel/CSV Modal -->
    <div class="modal fade" id="importExcelModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="{{ route('admin.quizzes.questions.import', $quiz) }}" method="POST" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-file-csv text-info me-2"></i>Bulk Import Questions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info border-0 shadow-sm rounded-4 mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-info-circle me-2 fs-5"></i>
                                <strong class="small text-uppercase fw-bold">Instructions & Format</strong>
                            </div>
                            <p class="small mb-2">Upload a <strong>CSV file</strong> with exactly 6 columns in this order:</p>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered bg-white mb-0 small text-center" style="font-size: 11px;">
                                    <thead class="bg-light text-muted">
                                        <tr>
                                            <th>Question</th>
                                            <th>A</th>
                                            <th>B</th>
                                            <th>C</th>
                                            <th>D</th>
                                            <th>Correct</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-truncate" style="max-width: 80px;">Ex: What is PHP?</td>
                                            <td>Lang</td>
                                            <td>Fruit</td>
                                            <td>Car</td>
                                            <td>Song</td>
                                            <td>a</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="small mt-2 mb-0 text-muted"><em>* Note: Save your Excel as "CSV (Comma delimited)" before uploading.</em></p>
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-muted fw-bold small text-uppercase">Select CSV/Excel File</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark rounded-pill px-5">Upload & Process</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
