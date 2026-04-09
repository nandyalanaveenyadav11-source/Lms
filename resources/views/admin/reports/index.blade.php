<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center w-100 flex-wrap gap-2">
            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-primary me-2" style="width: 48px; height: 48px;">
                <i class="fas fa-chart-line fa-lg"></i>
            </div>
            <div>
                <span class="text-muted text-uppercase small fw-bold tracking-wider">Analytics & Data</span>
                <h3 class="fw-bold mb-0" style="color: #0f3a69;">System Reports</h3>
            </div>
        </div>
    </x-slot>

    <style>
        .premium-table-container {
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .premium-table-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            background: linear-gradient(to right, #ffffff, #f8fafc);
        }
        .premium-table-header h5 {
            font-weight: 800;
            color: #1e293b;
            margin: 0;
            font-size: 1.25rem;
        }
        
        .table-premium { margin-bottom: 0; }
        .table-premium thead th {
            background: #f8fafc; color: #64748b; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; padding: 1.25rem 2rem; border-bottom: 2px solid #e2e8f0;
        }
        .table-premium tbody td {
            padding: 1.25rem 2rem; vertical-align: middle; color: #334155; font-weight: 500; border-bottom: 1px solid #f1f5f9; transition: background 0.2s;
        }
        .table-premium tbody tr:hover td { background-color: #f8fafc; }
        
        .trainee-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
        }
        
        .status-badge {
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
        }
        .status-badge.bg-success { background-color: #ecfdf5 !important; color: #059669; box-shadow: inset 0 0 0 1px #10b981; }
        .status-badge.bg-danger { background-color: #fef2f2 !important; color: #dc2626; box-shadow: inset 0 0 0 1px #ef4444; }
    </style>

    <div class="premium-table-container">
        <div class="premium-table-header">
            <h5><i class="fas fa-medal text-warning me-2 fs-4"></i> Course Completions</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th>Trainee</th>
                        <th>Course Module</th>
                        <th class="text-end">Date Achieved</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($completions as $comp)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    {{ substr($comp->trainee_name, 0, 1) }}
                                </div>
                                <span class="fw-bold text-dark">{{ $comp->trainee_name }}</span>
                            </div>
                        </td>
                        <td><span class="text-primary fw-bold">{{ $comp->course_title }}</span></td>
                        <td class="text-end"><span class="text-muted"><i class="far fa-calendar-check me-1"></i> {{ \Carbon\Carbon::parse($comp->completion_date)->format('M d, Y') }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 text-light"></i>
                            <p class="mb-0">No course completions recorded yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="premium-table-container">
        <div class="premium-table-header">
            <h5><i class="fas fa-tasks text-info me-2 fs-4"></i> Formal Assessment Results</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th>Trainee</th>
                        <th>Associated Quiz</th>
                        <th class="text-center">Score</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Recorded On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizResults as $res)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    {{ substr($res->user->name ?? '?', 0, 1) }}
                                </div>
                                <span class="fw-bold text-dark">{{ $res->user->name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $res->quiz->title ?? 'N/A' }}</div>
                            <small class="text-muted"><i class="fas fa-link me-1 opacity-50"></i>{{ $res->quiz->course->title ?? 'N/A' }}</small>
                        </td>
                        <td class="text-center">
                            <span class="fs-5 fw-bold @if($res->passed) text-success @else text-danger @endif">{{ $res->score }}%</span>
                        </td>
                        <td class="text-center">
                            <span class="badge status-badge @if($res->passed) bg-success @else bg-danger @endif">
                                @if($res->passed) <i class="fas fa-check w-100 mb-1"></i><br> PASS @else <i class="fas fa-times w-100 mb-1"></i><br> FAIL @endif
                            </span>
                        </td>
                        <td class="text-end"><span class="text-muted"><i class="far fa-clock me-1"></i> {{ $res->created_at->format('M d, Y') }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard fa-3x mb-3 text-light"></i>
                            <p class="mb-0">No quiz attempts have been made yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
