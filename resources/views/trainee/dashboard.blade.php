<x-app-layout>
    <x-slot name="header">My Dashboard</x-slot>

    <style>
        /* Extremely Premium Dashboard Styles */
        .stat-card {
            border-radius: 20px;
            border: none;
            padding: 1.75rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            z-index: 1;
        }
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.12);
        }
        
        .stat-bg-shape {
            position: absolute;
            top: -20px;
            right: -20px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            z-index: -1;
            transition: transform 0.5s ease;
        }
        .stat-bg-shape-2 {
            position: absolute;
            bottom: -30px;
            right: 40px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: -1;
            transition: transform 0.5s ease;
        }
        
        .stat-card:hover .stat-bg-shape {
            transform: scale(1.2);
        }
        .stat-card:hover .stat-bg-shape-2 {
            transform: scale(1.5);
        }

        .gradient-primary { background: linear-gradient(135deg, #0ea5e9, #2563eb); }
        .gradient-success { background: linear-gradient(135deg, #10b981, #059669); }
        .gradient-purple { background: linear-gradient(135deg, #a855f7, #7c3aed); }
        .gradient-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
            margin-bottom: 1rem;
        }
        .stat-title {
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0;
            line-height: 1;
        }

        /* Premium Course Cards */
        .section-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }
        .section-title::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            background: var(--brand-green, #8bc53f);
            bottom: -8px;
            left: 0;
            border-radius: 2px;
        }

        .course-card {
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.05);
            background: #ffffff;
            padding: 1.25rem 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .course-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px; /* Thinner accent bar */
            height: 100%;
            background: linear-gradient(to bottom, #0ea5e9, #10b981);
            opacity: 0.8;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border-color: rgba(14, 165, 233, 0.1);
        }
        
        .course-card h5 {
            font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; transition: color 0.2s; } 
            
        .course-card:hover h5 { color: #0ea5e9; }
        
        .course-card p {
            color: #64748b; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.5rem; flex-grow: 1; } 
            
        .course-footer {
            display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 1rem; border-top: 1px solid #f1f5f9; } 
            
        .badge-status.bg-success {
            background-color: #ecfdf5 !important; color: #059669; border: 1px solid #10b981; padding: 0.4rem 0.8rem; border-radius: 50px; font-weight: 600; font-size: 0.75rem; } 
            
        .badge-status.bg-light {
            background-color: #f8fafc !important; color: #64748b; border: 1px solid #e2e8f0; padding: 0.4rem 0.8rem; border-radius: 50px; font-weight: 600; font-size: 0.75rem; } 
            
        .btn-start {
            border-radius: 50px; padding: 0.4rem 1rem; font-weight: 600; font-size: 0.8rem; color: #0ea5e9; border: 2px solid #0ea5e9; transition: all 0.3s ease; text-decoration: none; } 
            
        .btn-start:hover {
            background: #0ea5e9; color: #ffffff; transform: scale(1.05); box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3); } 

        /* Premium Scrollbar for Courses */
        #courses-scroll-area::-webkit-scrollbar { width: 6px; }
        #courses-scroll-area::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        #courses-scroll-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        #courses-scroll-area::-webkit-scrollbar-thumb:hover { background: #0ea5e9; }
    </style>

    <!-- Super Premium Stats Row (Sticky) -->
    <div class="sticky-top pt-2 pb-3 mb-4" style="background: #f8fafc; z-index: 100; margin-top: -1rem; transition: all 0.3s ease;">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stat-card gradient-primary">
                    <div class="stat-bg-shape"></div>
                    <div class="stat-bg-shape-2"></div>
                    <i class="fas fa-book-open stat-icon"></i>
                    <div class="stat-title">Assigned Courses</div>
                    <div class="stat-value">{{ $total_assigned_courses }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card gradient-success">
                    <div class="stat-bg-shape"></div>
                    <div class="stat-bg-shape-2"></div>
                    <i class="fas fa-check-circle stat-icon"></i>
                    <div class="stat-title">Completed Courses</div>
                    <div class="stat-value">{{ $completed_courses }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card gradient-purple">
                    <div class="stat-bg-shape"></div>
                    <div class="stat-bg-shape-2"></div>
                    <i class="fas fa-clipboard-check stat-icon"></i>
                    <div class="stat-title">Completed Quizzes</div>
                    <div class="stat-value">{{ $completed_quizzes }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card gradient-warning">
                    <div class="stat-bg-shape"></div>
                    <div class="stat-bg-shape-2"></div>
                    <i class="fas fa-award stat-icon"></i>
                    <div class="stat-title">Certificates Won</div>
                    <div class="stat-value">{{ $total_certificates }}</div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="section-title">My Learning Path</h3>
    <div id="courses-scroll-area" class="row g-4 mb-5" style="max-height: 800px; overflow-y: auto; overflow-x: hidden; padding-right: 5px;">
        @foreach($assigned_courses as $course)
        <div class="col-lg-6">
            <div class="course-card">
                @if($course->duration_display)
                    <div class="position-absolute" style="top: 1.25rem; right: 1.25rem;">
                        <span class="badge bg-white text-muted border px-2 py-1 rounded-pill" style="font-size: 0.7rem; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                            <i class="fas fa-history me-1 text-primary"></i> {{ $course->duration_display }}
                        </span>
                    </div>
                @endif
                <h5 style="padding-right: 80px;">{{ $course->title }}</h5>
                <p>{{ \Illuminate\Support\Str::limit($course->description, 100) }}</p>
                
                <div class="course-footer">
                    <div>
                        @if($course->pivot->status == 'completed')
                            <span class="badge badge-status bg-success"><i class="fas fa-check-circle me-1"></i> Completed</span>
                        @else
                            <span class="badge badge-status bg-light"><i class="fas fa-clock me-1 text-primary"></i> In Progress</span>
                        @endif
                    </div>
                    
                    <a href="{{ route('trainee.courses.show', $course) }}" class="btn btn-start">
                        @if($course->pivot->status == 'completed')
                            <i class="fas fa-redo me-1"></i> Review
                        @else
                            <i class="fas fa-play me-1"></i> Start
                        @endif
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        
        @if($assigned_courses->isEmpty())
            <div class="col-12 text-center py-5 bg-white shadow-sm" style="border-radius: 20px;">
                <div class="py-5">
                    <i class="fas fa-rocket fa-4x text-light mb-4 shadow-sm p-4 rounded-circle bg-gray-50 border"></i>
                    <h4 class="fw-bold text-dark">You're all caught up!</h4>
                    <p class="text-muted fs-5">No courses are currently assigned to you. Speak with your administrator to unlock new learning opportunities.</p>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
