<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <div>
                <span class="text-muted text-uppercase small fw-bold tracking-wider">Course Manager</span>
                <h3 class="fw-bold mb-0" style="color: #0f3a69;">{{ $course->title }}</h3>
            </div>
            <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill border"><i class="fas fa-sitemap text-primary me-2"></i> {{ $course->domain ?? 'Main Platform' }}</span>
        </div>
    </x-slot>

    <style>
        .premium-card {
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .premium-card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            background: linear-gradient(to right, #ffffff, #f8fafc);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .premium-card-header h5 {
            font-weight: 800;
            color: #1e293b;
            margin: 0;
            font-size: 1.25rem;
        }
        
        .table-premium { margin-bottom: 0; }
        .table-premium thead th {
            background: #f8fafc; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; padding: 1rem 2rem; border-bottom: 2px solid #e2e8f0;
        }
        .table-premium tbody td {
            padding: 1rem 2rem; vertical-align: middle; color: #334155; font-weight: 500; border-bottom: 1px solid #f1f5f9; transition: background 0.2s;
        }
        .table-premium tbody tr:hover td { background-color: #f8fafc; }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #0ea5e9, #2563eb); color: white; border: none; font-weight: 600; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2); border-radius: 50px; padding: 0.5rem 1.25rem; transition: all 0.3s;
        }
        .btn-gradient-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3); color: white; }
        
        .btn-gradient-success {
            background: linear-gradient(135deg, #8bc53f, #10b981); color: white; border: none; font-weight: 600; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2); border-radius: 50px; padding: 0.5rem 1.25rem; transition: all 0.3s;
        }
        .btn-gradient-success:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3); color: white; }

        .btn-soft-info { background: #e0f2fe; color: #0284c7; border: none; font-weight: 600; border-radius: 50px; padding: 0.5rem 1.25rem; transition: all 0.3s; }
        .btn-soft-info:hover { background: #0284c7; color: #ffffff; }

        .btn-action-delete { background: #fee2e2; color: #ef4444; border: none; transition: all 0.3s; width: 34px; height: 34px; padding: 0; line-height: 34px; display: inline-flex; align-items: center; justify-content: center; }
        .btn-action-delete:hover { background: #ef4444; color: #ffffff; transform: scale(1.1); }

        .custom-select-multiple {
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 10px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        .custom-select-multiple:focus { border-color: #0ea5e9; outline: none; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1); }
        .custom-select-multiple option { padding: 8px 12px; margin-bottom: 4px; border-radius: 8px; }
        .custom-select-multiple option:checked { background: linear-gradient(135deg, #0ea5e9, #2563eb) !important; color: white !important; }

        .quiz-gradient-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 20px;
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.2);
        }
        .quiz-gradient-card::after {
            content: '\f059'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
            position: absolute; right: -20px; bottom: -40px; font-size: 150px; opacity: 0.05; transform: rotate(-15deg);
        }

        .enrolled-list-item { border: 1px solid #f1f5f9; border-radius: 12px; margin-bottom: 0.5rem; transition: all 0.2s; }
        .enrolled-list-item:hover { background: #f8fafc; border-color: #e2e8f0; transform: translateX(5px); }

        /* Premium Scrollbar */
        #roster-scroll-area::-webkit-scrollbar, 
        .custom-select-multiple::-webkit-scrollbar { width: 6px; }
        #roster-scroll-area::-webkit-scrollbar-track,
        .custom-select-multiple::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        #roster-scroll-area::-webkit-scrollbar-thumb,
        .custom-select-multiple::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        #roster-scroll-area::-webkit-scrollbar-thumb:hover,
        .custom-select-multiple::-webkit-scrollbar-thumb:hover { background: #0ea5e9; }
    </style>

    <div class="row">
        <!-- Lessons & Quiz Column -->
        <div class="col-lg-8">
            <div class="quiz-gradient-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-clipboard-check text-success me-2"></i> Assessment Quiz</h5>
                    @if(!$course->quiz)
                        <button class="btn btn-gradient-success" data-bs-toggle="modal" data-bs-target="#createQuizModal"><i class="fas fa-plus me-1"></i> Create Quiz</button>
                    @else
                        <a href="{{ route('admin.courses.quizzes.show', [$course, $course->quiz]) }}" class="btn btn-light text-dark rounded-pill px-4 fw-bold shadow-sm">Manage Questions <i class="fas fa-arrow-right ms-2"></i></a>
                    @endif
                </div>
                
                @if($course->quiz)
                    <div class="row text-center border-top border-secondary pt-4 mt-2">
                        <div class="col-4">
                            <div class="text-white-50 text-uppercase small fw-bold mb-1">Quiz Title</div>
                            <div class="fs-5 fw-bold">{{ $course->quiz->title }}</div>
                        </div>
                        <div class="col-4 border-start border-secondary">
                            <div class="text-white-50 text-uppercase small fw-bold mb-1">Passing requirement</div>
                            <div class="fs-5 fw-bold text-success">{{ $course->quiz->passing_marks }}%</div>
                        </div>
                        <div class="col-4 border-start border-secondary">
                            <div class="text-white-50 text-uppercase small fw-bold mb-1">Total Questions</div>
                            <div class="fs-5 fw-bold">{{ $course->quiz->questions()->count() }}</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-3 text-white-50">
                        <p class="mb-0">You have not created a final assessment quiz for this course yet.</p>
                    </div>
                @endif
            </div>

            <div class="premium-card">
                <div class="premium-card-header">
                    <h5><i class="fas fa-play-circle text-primary me-2"></i> Lessons Manager</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-soft-info" data-bs-toggle="modal" data-bs-target="#syncDurationsModal"><i class="fas fa-sync me-1"></i> Sync Durations</button>
                        <button class="btn btn-soft-info" data-bs-toggle="modal" data-bs-target="#importPlaylistModal"><i class="fas fa-cloud-download-alt me-1"></i> Import Playlist</button>
                        <button class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#addLessonModal"><i class="fas fa-plus me-1"></i> Add Manual</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-premium">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Lesson Details</th>
                                <th class="text-end" width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($course->lessons as $lesson)
                            <tr>
                                <td class="text-center text-muted fw-bold">{{ $lesson->order }}</td>
                                <td>
                                    <div class="fw-bold text-dark mb-1">{{ $lesson->title }}</div>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ $lesson->video_url }}" target="_blank" class="text-primary small text-decoration-none"><i class="fab fa-youtube me-1 text-danger"></i> {{ \Illuminate\Support\Str::limit($lesson->video_url, 40) }}</a>
                                        <span class="badge bg-light text-muted border py-0 px-2" style="font-size: 0.7rem;">
                                            <i class="fas fa-clock me-1"></i> {{ $lesson->duration_seconds ? floor($lesson->duration_seconds / 60) . 'm' : 'No time set' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-soft-info rounded-circle" style="width:34px; height:34px; border:none;" 
                                            data-bs-toggle="modal" data-bs-target="#editLessonModal{{ $lesson->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.courses.lessons.destroy', [$course, $lesson]) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-action-delete rounded-circle" title="Delete Lesson" onclick="return confirm('Delete this lesson?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>

                                    <!-- Edit Lesson Modal -->
                                    <div class="modal fade" id="editLessonModal{{ $lesson->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('admin.courses.lessons.update', [$course, $lesson]) }}" method="POST" class="w-100 text-start">
                                                @csrf @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit text-primary me-2"></i>Edit Lesson</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold text-muted small text-uppercase">Lesson Title</label>
                                                            <input type="text" name="title" class="form-control" value="{{ $lesson->title }}" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold text-muted small text-uppercase">YouTube Video URL</label>
                                                            <input type="url" name="video_url" class="form-control" value="{{ $lesson->video_url }}" required>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label fw-bold text-muted small text-uppercase">Video Duration (Minutes)</label>
                                                            <input type="number" name="duration_minutes" class="form-control" value="{{ $lesson->duration_seconds ? floor($lesson->duration_seconds / 60) : '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-gradient-primary">Update Lesson</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-5 text-muted"><i class="fas fa-film fa-3x mb-3 text-light"></i><br>No lessons added yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Trainee Management Column -->
        <div class="col-lg-4">
            <div class="premium-card">
                <div class="premium-card-header">
                    <h5><i class="fas fa-user-plus text-info me-2"></i> Enroll Trainees</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2 mb-4">
                        <form action="{{ route('admin.courses.assign', $course) }}" method="POST">
                            @csrf <input type="hidden" name="bulk_type" value="all">
                            <button type="submit" class="btn btn-soft-info w-100 py-2 border border-info" onclick="return confirm('Assign to ALL trainees?')"><i class="fas fa-globe me-2"></i> Enroll All Users</button>
                        </form>
                        @if($course->domain)
                        <form action="{{ route('admin.courses.assign', $course) }}" method="POST">
                            @csrf <input type="hidden" name="bulk_type" value="domain">
                            <button type="submit" class="btn text-primary w-100 py-2 border border-primary" style="background:#f8fafc;" onclick="return confirm('Assign to all {{ $course->domain }} trainees?')"><i class="fas fa-sitemap me-2"></i> Enroll Domain ({{ $course->domain }})</button>
                        </form>
                        @endif
                    </div>

                    <div class="position-relative mb-4 text-center">
                        <hr class="text-muted">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted small fw-bold">OR SELECT MANUALLY</span>
                    </div>

                    <form action="{{ route('admin.courses.assign', $course) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <div class="input-group mb-2 shadow-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted small"></i></span>
                                <input type="text" id="trainee-search" class="form-control border-start-0 ps-0" placeholder="Search by name..." style="font-size: 0.85rem;">
                            </div>
                            <select name="trainee_ids[]" id="trainee-select" class="form-select custom-select-multiple w-100" multiple style="height: 250px;">
                                @foreach($allTrainees as $trainee)
                                    <option value="{{ $trainee->id }}" {{ $course->trainees->contains($trainee->id) ? 'selected' : '' }} data-name="{{ strtolower($trainee->name) }}">
                                        {{ $trainee->name }} @if($trainee->domain) - {{ $trainee->domain }} @endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text mt-2 text-center"><i class="fas fa-mouse-pointer opacity-50 me-1"></i> Hold <kbd class="bg-light text-dark border">Ctrl</kbd> to select multiple users.</div>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary w-100 py-2 fs-6 shadow">Update Manual Enrollment</button>
                    </form>

                    <script>
                        document.getElementById('trainee-search').addEventListener('input', function(e) {
                            const term = e.target.value.toLowerCase();
                            const options = document.querySelectorAll('#trainee-select option');
                            
                            options.forEach(option => {
                                const name = option.getAttribute('data-name');
                                if (name.includes(term)) {
                                    option.style.display = 'block';
                                } else {
                                    option.style.display = 'none';
                                }
                            });
                        });
                    </script>
                </div>
            </div>

            <div class="premium-card">
                <div class="premium-card-header pb-3 border-0">
                    <h5><i class="fas fa-users text-success me-2"></i> Active Roster</h5>
                </div>
                <div class="card-body p-3 pt-0">
                    <div id="roster-scroll-area" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                        <ul class="list-unstyled mb-0">
                        @forelse($course->trainees as $trainee)
                            <li class="enrolled-list-item p-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width:32px; height:32px; font-size:12px;">{{ substr($trainee->name, 0, 1) }}</div>
                                    <span class="fw-bold text-dark" style="font-size:0.95rem;">{{ $trainee->name }}</span>
                                </div>
                                <span class="badge rounded-pill @if($trainee->pivot->status == 'completed') bg-success @else bg-warning text-dark @endif">
                                    {{ ucfirst($trainee->pivot->status) }}
                                </span>
                            </li>
                        @empty
                            <div class="text-center py-4 text-muted bg-light rounded-3">
                                <i class="fas fa-ghost mb-2 fa-2x opacity-25"></i>
                                <p class="mb-0 small">No trainees are currently enrolled.</p>
                            </div>
                        @endforelse
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Beautiful Modals -->
    <style>
        .modal-content { border-radius: 20px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .modal-header { border-bottom: 1px solid #f1f5f9; padding: 1.5rem 2rem; }
        .modal-body { padding: 2rem; }
        .modal-footer { border-top: 1px solid #f1f5f9; padding: 1.5rem 2rem; }
        .modal .form-control { border-radius: 12px; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; }
        .modal .form-control:focus { border-color: #0ea5e9; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1); }
    </style>

    <div class="modal fade" id="addLessonModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.courses.lessons.store', $course) }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold text-dark"><i class="fas fa-plus-circle text-primary me-2"></i>Add New Lesson</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Lesson Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Introduction to Routing" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">YouTube Video URL</label>
                            <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold text-muted small text-uppercase">Video Duration (Minutes)</label>
                            <input type="number" name="duration_minutes" class="form-control" placeholder="e.g. 15">
                            <div class="form-text small">Leave blank to just show lesson count instead of time.</div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-primary">Save Lesson</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="createQuizModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.courses.quizzes.store', $course) }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content border-top border-success border-5">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-dark"><i class="fas fa-stopwatch text-success me-2"></i>Define Final Quiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Quiz Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Final Assessment Exam" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Passing Marks (%)</label>
                                <input type="number" name="passing_marks" class="form-control form-control-lg text-center fs-3 text-success fw-bold" min="0" max="100" value="70" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Time Limit (Mins)</label>
                                <input type="number" name="duration_minutes" class="form-control form-control-lg text-center fs-3 text-primary fw-bold" min="1" value="15" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-success">Generate Quiz Container</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal fade" id="syncDurationsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.courses.sync-durations', $course) }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content border-top border-primary border-5">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-dark"><i class="fas fa-magic text-primary me-2"></i>Bulk Auto-Sync Durations</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-primary border-0 shadow-sm rounded-3 d-flex gap-3 mb-4">
                            <i class="fas fa-bolt fa-2x opacity-50 mt-1"></i>
                            <div class="small">This will scan all existing lessons in this course and automatically fetch their video lengths from YouTube. You don't have to enter them one by one!</div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold text-muted small text-uppercase">Google Data API Key</label>
                            <input type="password" name="api_key" class="form-control" placeholder="Paste your API Key here" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Start Auto-Sync</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="importPlaylistModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.courses.import-playlist', $course) }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content border-top border-info border-5">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-dark"><i class="fab fa-youtube text-danger me-2"></i>Auto-Import Playlist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info border-0 shadow-sm rounded-3 d-flex gap-3 mb-4">
                            <i class="fas fa-info-circle fa-2x opacity-50 mt-1"></i>
                            <div class="small">Provide a YouTube Playlist link. Our system will automatically fetch all embedded video titles and generate lessons for you instantly.</div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">YouTube Playlist URL</label>
                            <input type="url" name="playlist_url" class="form-control" placeholder="https://www.youtube.com/playlist?list=..." required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold text-muted small text-uppercase">Google Data API Key</label>
                            <input type="password" name="api_key" class="form-control" placeholder="Paste your API Key here" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark rounded-pill px-4"><i class="fas fa-sync fa-spin me-2 d-none"></i> Start Import Process</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
