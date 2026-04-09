<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-3">
            <span class="fs-4 fw-bold" style="color: #0f3a69;">Manage Courses</span>
            
            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('admin.courses.index') }}" method="GET" class="d-flex shadow-sm rounded-pill overflow-hidden bg-white">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 px-4 py-2" placeholder="Search courses..." style="width: 250px; outline: none; box-shadow: none;">
                    <button type="submit" class="btn btn-light border-0 px-3 text-primary"><i class="fas fa-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-light border-0 px-3 text-danger"><i class="fas fa-times"></i></a>
                    @endif
                </form>
                
                <a href="{{ route('admin.courses.create') }}" class="btn rounded-pill px-4" style="background: linear-gradient(135deg, #8bc53f, #10b981); color: white; border: none; font-weight: 600; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);"><i class="fas fa-plus me-2"></i> Create Course</a>
            </div>
        </div>
    </x-slot>

    <style>
        .admin-course-card {
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.02);
            background: linear-gradient(135deg, #ffffff 0%, #f4f8ff 100%);
            padding: 1.75rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .admin-course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }
        .btn-action-edit {
            background: #e0f2fe;
            color: #0284c7;
            border: none;
            transition: all 0.3s;
        }
        .btn-action-edit:hover {
            background: #0284c7;
            color: #ffffff;
            transform: scale(1.1);
        }
        
        .btn-action-delete {
            background: #fee2e2;
            color: #ef4444;
            border: none;
            transition: all 0.3s;
        }
        .btn-action-delete:hover {
            background: #ef4444;
            color: #ffffff;
            transform: scale(1.1);
        }
    </style>

    <div class="row g-4 mt-1">
        @forelse($courses as $course)
        <div class="col-md-6 col-lg-4 mb-2">
            <div class="admin-course-card">
                <h5 class="fw-bold text-dark mb-3">{{ $course->title }}</h5>
                <p class="text-muted small mb-4 flex-grow-1">{{ \Illuminate\Support\Str::limit($course->description, 100) }}</p>
                
                <div class="d-flex justify-content-between small text-muted mb-4 pb-3 border-bottom border-light">
                    <span class="badge bg-light text-primary py-2 px-3 rounded-pill border"><i class="fas fa-play-circle me-1"></i> {{ $course->lessons_count }} Lessons</span>
                    <span class="badge bg-light text-success py-2 px-3 rounded-pill border"><i class="fas fa-users me-1"></i> {{ $course->trainees_count }} Enrolled</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-sm px-3 rounded-pill" style="background:#f1f5f9; color:#475569; font-weight:600;"><i class="fas fa-cog"></i> Manage</a>
                    <div>
                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-action-edit rounded-circle me-1 shadow-sm" style="width: 36px; height: 36px; padding: 0; line-height: 36px;"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-action-delete rounded-circle shadow-sm" style="width: 36px; height: 36px; padding: 0; line-height: 36px;" onclick="return confirm('Delete this course?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 py-5 text-center bg-white rounded-5 shadow-sm">
            <i class="fas fa-search fa-3x text-light mb-3"></i>
            <h4 class="text-muted">No courses found</h4>
            @if(request('search'))
                <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-primary mt-2 rounded-pill">Clear Search</a>
            @endif
        </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $courses->links('pagination::bootstrap-5') }}
    </div>
</x-app-layout>
