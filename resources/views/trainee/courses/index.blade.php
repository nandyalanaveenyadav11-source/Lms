<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div>
                <span class="text-muted text-uppercase small fw-bold tracking-wider">Learning Path</span>
                <h3 class="fw-bold mb-0" style="color: #0f3a69;">My Courses</h3>
            </div>
            <div class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill border"><i class="fas fa-book-reader text-primary me-2"></i> {{ $courses->count() }} Active Enrollments</div>
        </div>
    </x-slot>

    <style>
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
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, #0ea5e9, #10b981);
            opacity: 0.8;
            transition: width 0.3s ease;
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
    </style>

    <div class="row g-4">
        @forelse($courses as $course)
        <div class="col-lg-6 col-xl-4">
            <div class="course-card">
                @if($course->duration_display)
                    <div class="position-absolute" style="top: 1.5rem; right: 1.5rem;">
                        <span class="badge bg-light text-muted border px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                            <i class="fas fa-history me-1 text-primary"></i> {{ $course->duration_display }}
                        </span>
                    </div>
                @endif
                <h5 style="padding-right: 90px;">{{ $course->title }}</h5>
                <p>{{ \Illuminate\Support\Str::limit($course->description, 120) }}</p>
                
                <div class="course-footer">
                    <div>
                        @if($course->pivot->status == 'completed')
                            <span class="badge badge-status bg-success"><i class="fas fa-check-circle me-1"></i> Course Completed</span>
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
        @empty
        <div class="col-12 text-center py-5 mt-5">
            <div class="bg-white rounded-5 p-5 shadow-sm d-inline-block">
                <i class="fas fa-book-open fa-4x text-light mb-4 shadow-sm p-4 rounded-circle bg-gray-50 border"></i>
                <h4 class="fw-bold text-dark">No courses found</h4>
                <p class="text-muted fs-5">You are not currently enrolled in any learning paths.</p>
            </div>
        </div>
        @endforelse
    </div>
</x-app-layout>
