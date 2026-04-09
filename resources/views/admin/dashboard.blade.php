<x-app-layout>
    <x-slot name="header">Admin Space</x-slot>

    <style>
        /* Premium Admin Dashboard Styles */
        .admin-stat-card {
            border-radius: 20px;
            border: none;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin-stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .admin-stat-bg-1 {
            position: absolute;
            top: -30px;
            right: -30px;
            width: 180px;
            height: 180px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
            border-radius: 50%;
            z-index: -1;
            transition: transform 0.6s ease;
        }
        .admin-stat-bg-2 {
            position: absolute;
            bottom: -20px;
            left: -20px;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            z-index: -1;
            transition: transform 0.6s ease;
        }
        
        .admin-stat-card:hover .admin-stat-bg-1 { transform: scale(1.3) rotate(45deg); }
        .admin-stat-card:hover .admin-stat-bg-2 { transform: scale(1.6); }

        .bg-grad-purple { background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); }
        .bg-grad-blue { background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%); }
        .bg-grad-emerald { background: linear-gradient(135deg, #10b981 0%, #047857 100%); }

        .stat-content { text-align: left; }
        .stat-icon-wrapper {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .stat-value {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 0.2rem;
        }
        .stat-label {
            font-size: 1.05rem;
            font-weight: 500;
            opacity: 0.9;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Premium Table Container */
        .premium-table-container {
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
            margin-top: 2rem;
        }
        .premium-table-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background: linear-gradient(to right, #ffffff, #f8fafc);
        }
        .premium-table-header h5 {
            font-weight: 800;
            color: #0f3a69;
            margin: 0;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .table-premium { margin-bottom: 0; }
        .table-premium thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 1.25rem 2rem;
            border-bottom: 2px solid #e2e8f0;
        }
        .table-premium tbody td {
            padding: 1.25rem 2rem;
            vertical-align: middle;
            color: #334155;
            font-weight: 500;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }
        .table-premium tbody tr:hover td {
            background-color: #f8fafc;
        }
        
        .lesson-badge {
            background: #e0f2fe;
            color: #0284c7;
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
        }
        
        .btn-table-action {
            border-radius: 50px;
            padding: 0.4rem 1.5rem;
            font-weight: 600;
            font-size: 0.85rem;
            color: #0f3a69;
            border: 2px solid #0f3a69;
            transition: all 0.3s;
        }
        .btn-table-action:hover {
            background: #0f3a69;
            color: #fff;
            box-shadow: 0 4px 12px rgba(15, 58, 105, 0.2);
            transform: scale(1.05);
        }
    </style>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="admin-stat-card bg-grad-purple">
                <div class="admin-stat-bg-1"></div>
                <div class="admin-stat-bg-2"></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $total_trainees }}</div>
                    <div class="stat-label">Total Trainees</div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-stat-card bg-grad-blue">
                <div class="admin-stat-bg-1"></div>
                <div class="admin-stat-bg-2"></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $total_courses }}</div>
                    <div class="stat-label">Total Courses</div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-stat-card bg-grad-emerald">
                <div class="admin-stat-bg-1"></div>
                <div class="admin-stat-bg-2"></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $total_completions }}</div>
                    <div class="stat-label">Completions</div>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-medal"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="premium-table-container">
        <div class="premium-table-header">
            <h5><i class="fas fa-clock text-primary border p-2 rounded-circle bg-white shadow-sm"></i> Recently Added Courses</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th>Course Title</th>
                        <th>Lessons</th>
                        <th>Created Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_courses as $course)
                    <tr>
                        <td>
                            <strong class="text-dark fs-6">{{ $course->title }}</strong>
                        </td>
                        <td>
                            <span class="lesson-badge"><i class="fas fa-book-open me-1"></i> {{ $course->lessons()->count() }}</span>
                        </td>
                        <td>
                            <span class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $course->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-table-action">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @if($recent_courses->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3 text-light"></i>
                            <p class="mb-0">No courses created yet.</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
