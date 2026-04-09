<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div>
                <span class="text-muted text-uppercase small fw-bold tracking-wider">Achievements</span>
                <h3 class="fw-bold mb-0" style="color: #0f3a69;">My Certificates</h3>
            </div>
            <div class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill border"><i class="fas fa-medal text-warning me-2"></i> {{ $certificates->count() }} Total Won</div>
        </div>
    </x-slot>

    <style>
        .cert-card {
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.05);
            background: #ffffff;
            padding: 1.5rem;
            height: 100%;
            text-align: center;
            position: relative;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .cert-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }
        
        .cert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border-color: rgba(245, 158, 11, 0.2);
        }
        
        .medal-icon {
            font-size: 3rem;
            color: #f59e0b;
            margin-bottom: 1rem;
            filter: drop-shadow(0 4px 8px rgba(245, 158, 11, 0.2));
        }

        .cert-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .cert-date {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .cert-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-cert-view {
            background-color: #f0f7ff;
            color: #0ea5e9;
            border: 1px solid #0ea5e9;
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cert-view:hover {
            background-color: #0ea5e9;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
        }

        .btn-cert-down {
            background-color: #0ea5e9;
            color: #ffffff;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cert-down:hover {
            background-color: #0284c7;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
        }
    </style>

    <div class="row g-4">
        @forelse($certificates as $cert)
        <div class="col-md-6 col-lg-4">
            <div class="cert-card">
                <div class="medal-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h5 class="cert-title">{{ $cert->course->title }}</h5>
                <p class="cert-date">Awarded on {{ $cert->created_at->format('M d, Y') }}</p>
                
                <div class="cert-actions">
                    <a href="{{ route('trainee.certificates.show', $cert) }}" target="_blank" class="btn-cert-view">
                        <i class="fas fa-eye me-1"></i> View
                    </a>
                    <a href="{{ route('trainee.certificates.download', $cert) }}" class="btn-cert-down">
                        <i class="fas fa-download me-1"></i> Download
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 mt-5">
            <div class="bg-white rounded-5 p-5 shadow-sm d-inline-block">
                <i class="fas fa-award fa-4x text-light mb-4 shadow-sm p-4 rounded-circle bg-gray-50 border"></i>
                <h4 class="fw-bold text-dark">No certificates yet</h4>
                <p class="text-muted fs-5">Complete your courses and pass final quizzes to earn certificates!</p>
                <a href="{{ route('trainee.courses.index') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3 fw-bold">Start Learning</a>
            </div>
        </div>
        @endforelse
    </div>
</x-app-layout>
