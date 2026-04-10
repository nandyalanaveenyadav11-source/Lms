<x-app-layout>
    <style>
        body { background-color: #f0f2f5; }
        .quiz-header { 
            background: #6c5ce7; 
            color: white; 
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .timer-box {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .question-number-badge {
            background: #e9ecef;
            color: #6c5ce7;
            font-weight: bold;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .option-container {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            margin-bottom: 1rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 15px;
            background: white;
            position: relative;
        }
        .option-container:hover { background: #f8f9fa; border-color: #6c5ce7; }
        .option-container.selected { 
            border: 2px solid #6c5ce7; 
            background: rgba(108, 92, 231, 0.05); 
        }
        
        .option-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            color: #666;
            flex-shrink: 0;
            background: white;
        }
        .selected .option-circle { 
            background: #6c5ce7; 
            color: white; 
            border-color: #6c5ce7; 
        }

        /* Sidebar Grid */
        .status-dot { width: 12px; height: 12px; border-radius: 3px; display: inline-block; margin-right: 5px; }
        .bg-answered { background: #00b894; }
        .bg-marked { background: #a29bfe; }
        .bg-not-visited { background: #dfe6e9; }
        .bg-not-answered { background: #fab1a0; }

        .question-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }
        .grid-item {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            font-size: 0.85rem;
            background: #dfe6e9;
            color: #2d3436;
            transition: 0.2s;
        }
        .grid-item.not-visited { background: #f1f2f6; color: #a4b0be; border: 1px solid #eee; }
        .grid-item.not-answered { background: #fab1a0; color: white; }
        .grid-item.answered { background: #00b894; color: white; }
        .grid-item.marked { background: #a29bfe; color: white; }
        .grid-item.current { border: 3px solid #6c5ce7; box-shadow: 0 0 10px rgba(108, 92, 231, 0.3); }

        .btn-submit-exam {
            background: #00b894;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            width: 100%;
            margin-top: 2rem;
            transition: 0.3s;
        }
        .btn-submit-exam:hover { background: #55efc4; }

        /* Actions Bar */
        .actions-bar {
            border-top: 1px solid #eee;
            margin-top: 2rem;
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
    </style>

    <div class="mb-5">
        <div class="quiz-header">
            <h4 class="mb-0 fw-bold"><i class="fas fa-check-square me-2"></i> {{ $quiz->title }}</h4>
            <div class="timer-box">
                <i class="far fa-clock"></i>
                <span id="quiz-timer">00:15:00</span>
            </div>
        </div>

        <div class="container-fluid mt-4">
            <div class="row px-lg-5">
                <!-- Main Quiz Area -->
                <div class="col-lg-9">
                    <div id="quiz-content-area" class="bg-white p-5 rounded-4 shadow-sm min-vh-75 position-relative">
                        @foreach($quiz->questions as $index => $question)
                            <div class="question-page" id="q-page-{{ $index }}" style="display: {{ $index == 0 ? 'block' : 'none' }}">
                                <div class="question-number-badge">Question {{ $index + 1 }} of {{ $quiz->questions->count() }}</div>
                                <h4 class="fw-bold mb-5 line-height-1-5">{{ $question->question_text }}</h4>

                                <div class="options-group">
                                    <div class="option-container" onclick="selectOption({{ $index }}, {{ $question->id }}, 'a')">
                                        <div class="option-circle">A</div>
                                        <span>{{ $question->option_a }}</span>
                                    </div>
                                    <div class="option-container" onclick="selectOption({{ $index }}, {{ $question->id }}, 'b')">
                                        <div class="option-circle">B</div>
                                        <span>{{ $question->option_b }}</span>
                                    </div>
                                    <div class="option-container" onclick="selectOption({{ $index }}, {{ $question->id }}, 'c')">
                                        <div class="option-circle">C</div>
                                        <span>{{ $question->option_c }}</span>
                                    </div>
                                    <div class="option-container" onclick="selectOption({{ $index }}, {{ $question->id }}, 'd')">
                                        <div class="option-circle">D</div>
                                        <span>{{ $question->option_d }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="actions-bar">
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary px-4 py-2" style="background:#6c5ce7; border:none;" onclick="markForReview()">
                                    <i class="fas fa-bookmark me-2"></i> Mark & Next
                                </button>
                                <button class="btn btn-outline-danger px-4 py-2" onclick="clearResponse()">
                                    <i class="fas fa-times me-2"></i> Clear Response
                                </button>
                            </div>
                            <div class="d-flex gap-2">
                                <button id="prev-btn" class="btn border px-4 py-2" onclick="changeQuestion(-1)" disabled>
                                    <i class="fas fa-chevron-left me-2"></i> Previous
                                </button>
                                <button id="next-btn" class="btn btn-primary px-4 py-2" style="background:#3742fa; border:none;" onclick="changeQuestion(1)">
                                    Save & Next <i class="fas fa-chevron-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Grid Area -->
                <div class="col-lg-3">
                    <div class="bg-white p-4 rounded-4 shadow-sm sticky-top" style="top: 100px;">
                        <div class="mb-4">
                            <div class="row row-cols-2 g-3">
                                <div class="col"><span class="status-dot bg-answered"></span> <span class="small text-muted">Answered</span></div>
                                <div class="col"><span class="status-dot bg-marked"></span> <span class="small text-muted">Marked</span></div>
                                <div class="col"><span class="status-dot bg-not-visited"></span> <span class="small text-muted">Not Visited</span></div>
                                <div class="col"><span class="status-dot bg-not-answered"></span> <span class="small text-muted">Not Answered</span></div>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3">Questions</h6>
                        <div class="question-grid">
                            @foreach($quiz->questions as $index => $question)
                                <div class="grid-item" id="grid-item-{{ $index }}" onclick="goToQuestion({{ $index }})">
                                    {{ $index + 1 }}
                                </div>
                            @endforeach
                        </div>

                        <form id="quiz-final-form" action="{{ route('trainee.quizzes.submit', $course) }}" method="POST">
                            @csrf
                            <input type="hidden" name="time_spent" id="time_spent_input">
                            <div id="hidden-answers"></div>
                            <button type="button" class="btn-submit-exam mt-4" onclick="confirmSubmission()">
                                <i class="fas fa-paper-plane me-2"></i> Submit Exam
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const totalQuestions = {{ $quiz->questions->count() }};
        let currentIndex = 0;
        let answers = {};
        let statuses = Array(totalQuestions).fill('not-visited'); // not-visited, not-answered, answered, marked
        statuses[0] = 'not-answered';

        function showQuestion(index) {
            document.querySelectorAll('.question-page').forEach(p => p.style.display = 'none');
            document.getElementById(`q-page-${index}`).style.display = 'block';
            
            document.querySelectorAll('.grid-item').forEach(i => i.classList.remove('current'));
            document.getElementById(`grid-item-${index}`).classList.add('current');
            
            currentIndex = index;
            updateButtons();
            renderSelectedOption();
        }

        function changeQuestion(delta) {
            const nextIndex = currentIndex + delta;
            
            if (delta === 1) { // Forward
                if (statuses[currentIndex] === 'not-visited' || statuses[currentIndex] === 'not-answered') {
                    if (!answers[currentQuestionId()]) {
                        statuses[currentIndex] = 'not-answered';
                    }
                }
            }

            if (nextIndex >= 0 && nextIndex < totalQuestions) {
                if (statuses[nextIndex] === 'not-visited') statuses[nextIndex] = 'not-answered';
                showQuestion(nextIndex);
                updateGrid();
            }
        }

        function goToQuestion(index) {
            if (statuses[index] === 'not-visited') statuses[index] = 'not-answered';
            showQuestion(index);
            updateGrid();
        }

        function currentQuestionId() {
            const el = document.querySelector(`#q-page-${currentIndex} .options-group`);
            // We get ID from data or index
            return {!! json_encode($quiz->questions->pluck('id')->toArray()) !!}[currentIndex];
        }

        function selectOption(qIdx, questionId, option) {
            answers[questionId] = option;
            statuses[qIdx] = 'answered';
            renderSelectedOption();
            updateGrid();
        }

        function renderSelectedOption() {
            const currentQId = currentQuestionId();
            const option = answers[currentQId];
            
            const containers = document.querySelectorAll(`#q-page-${currentIndex} .option-container`);
            containers.forEach(c => c.classList.remove('selected'));
            
            if (option) {
                const map = {a:0, b:1, c:2, d:3};
                containers[map[option]].classList.add('selected');
            }
        }

        function markForReview() {
            statuses[currentIndex] = 'marked';
            updateGrid();
            changeQuestion(1);
        }

        function clearResponse() {
            const qId = currentQuestionId();
            delete answers[qId];
            statuses[currentIndex] = 'not-answered';
            renderSelectedOption();
            updateGrid();
        }

        function updateGrid() {
            document.querySelectorAll('.grid-item').forEach((item, idx) => {
                item.className = 'grid-item';
                if (idx === currentIndex) item.classList.add('current');
                item.classList.add(statuses[idx]);
            });
        }

        function updateButtons() {
            document.getElementById('prev-btn').disabled = currentIndex === 0;
            const nextBtn = document.getElementById('next-btn');
            if (currentIndex === totalQuestions - 1) {
                nextBtn.innerHTML = 'Save <i class=\"fas fa-save ms-2\"></i>';
            } else {
                nextBtn.innerHTML = 'Save & Next <i class=\"fas fa-chevron-right ms-2\"></i>';
            }
        }

        // Timer Logic
        let timeLeft = {{ $quiz->duration_minutes }} * 60;
        const timerEl = document.getElementById('quiz-timer');
        timerEl.textContent = formatTime(timeLeft);

        const interval = setInterval(() => {
            timeLeft--;
            if (timeLeft <= 0) {
                clearInterval(interval);
                alert('Time is up!');
                confirmSubmission();
            }
            timerEl.textContent = formatTime(timeLeft);
        }, 1000);

        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const mins = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        function confirmSubmission() {
            if (confirm('Are you sure you want to submit your exam?')) {
                const hiddenArea = document.getElementById('hidden-answers');
                hiddenArea.innerHTML = '';
                for (let qId in answers) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `answers[${qId}]`;
                    input.value = answers[qId];
                    hiddenArea.appendChild(input);
                }
                document.getElementById('quiz-final-form').submit();
            }
        }

        // Initialize grid state for first question
        updateGrid();
    </script>
</x-app-layout>
