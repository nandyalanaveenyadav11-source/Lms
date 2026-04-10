<x-app-layout>
    <x-slot name="header">{{ $course->title }}</x-slot>

    <div class="row">
        <!-- Video Player and Content -->
        <div class="col-lg-8" style="position: sticky; top: 20px; align-self: start;">
            <div class="card mb-4">
                @php
                    $activeLessonId = request('lesson') ? (int) request('lesson') : ($course->lessons->first()->id ?? null);
                    $activeLesson = $course->lessons->firstWhere('id', $activeLessonId);
                @endphp

                @if($activeLesson)
                    @php
                        // Check if it's a youtube URL and specifically a playlist
                        $isYoutube = str_contains($activeLesson->video_url, 'youtube.com') || str_contains($activeLesson->video_url, 'youtu.be');
                        $videoId = '';
                        if ($isYoutube) {
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $activeLesson->video_url, $match)) {
                                $videoId = $match[1];
                            }
                        }
                        // It's a "Redirect Playlist" ONLY if it HAS a list= but NO v= (video ID)
                        $isPlaylistRedirect = str_contains($activeLesson->video_url, 'list=') && !$videoId;
                    @endphp

                    @if($activeLesson->type === 'pdf')
                        {{-- PDF Viewer --}}
                        <div class="ratio ratio-4x3 bg-light" style="border-radius: 12px; overflow: hidden; border: 1px solid #e1e8ed;">
                            <iframe src="{{ $activeLesson->content_url }}" title="{{ $activeLesson->title }}"></iframe>
                        </div>
                        <div class="px-3 pt-2 text-end">
                            <a href="{{ $activeLesson->content_url }}" target="_blank" download class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-download me-1"></i> Download PDF for Offline Reading
                            </a>
                        </div>
                    @elseif($isPlaylistRedirect)
                        {{-- Redirect to YouTube for Playlists --}}
                        <div class="position-relative cursor-pointer" onclick="window.open('{{ $activeLesson->video_url }}', '_blank')">
                            <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" class="card-img-top" style="height: 450px; object-fit: cover;" onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/0.jpg'">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <i class="fas fa-play-circle fa-5x text-white shadow" style="opacity: 0.9;"></i>
                            </div>
                            <div class="position-absolute bottom-0 start-0 p-3 w-100 text-white" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                                <h5 class="mb-0">This is a Playlist - Click to Play on YouTube <i class="fas fa-external-link-alt small"></i></h5>
                            </div>
                        </div>
                    @else
                        {{-- Embed single video on website --}}
                        <div class="ratio ratio-16x9 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                            <iframe src="{{ $activeLesson->embed_url }}" title="{{ $activeLesson->title }}" allowfullscreen></iframe>
                        </div>
                        <div class="px-3 pt-2 text-end">
                            <a href="{{ $activeLesson->video_url }}" target="_blank" class="text-muted small text-decoration-none hover-primary">
                                <i class="fab fa-youtube text-danger me-1"></i> Video not loading? Watch on YouTube <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                            </a>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">{{ $activeLesson->title }}</h4>
                            @if(!in_array($activeLesson->id, $completedLessonIds))
                                <form action="{{ route('trainee.lessons.complete', $activeLesson) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Mark as Completed</button>
                                </form>
                            @else
                                <span class="badge bg-success py-2 px-3"><i class="fas fa-check-double"></i> Completed</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between">
                            @php
                                $prevLesson = $course->lessons->where('order', '<', $activeLesson->order)->sortByDesc('order')->first();
                                $nextLesson = $course->lessons->where('order', '>', $activeLesson->order)->sortBy('order')->first();
                            @endphp
                            
                            @if($prevLesson)
                                <a href="{{ route('trainee.courses.show', [$course, 'lesson' => $prevLesson->id]) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Previous: {{ \Illuminate\Support\Str::limit($prevLesson->title, 20) }}
                                </a>
                            @else
                                <div></div>
                            @endif

                            @if($nextLesson)
                                <a href="{{ route('trainee.courses.show', [$course, 'lesson' => $nextLesson->id]) }}" class="btn btn-outline-secondary">
                                    Next: {{ \Illuminate\Support\Str::limit($nextLesson->title, 20) }} <i class="fas fa-arrow-right"></i>
                                </a>
                            @else
                                @if($progress >= 100 && $course->quiz)
                                    <a href="{{ route('trainee.quizzes.show', $course) }}" class="btn btn-primary">
                                        Attempt Quiz <i class="fas fa-tasks"></i>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card-body text-center py-5">
                        <p class="text-muted">No lessons available for this course yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar: Lesson List and Progress -->
        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Course Progress</h5>
                </div>
                <div class="card-body">
                    <div class="progress mb-2" style="height: 15px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"></div>
                    </div>
                    <p class="small text-muted mb-0">{{ $progress }}% Complete</p>
                </div>
            </div>

            <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list-ul text-primary me-2"></i> Course Content</h5>
                </div>
                <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                    @foreach($course->lessons as $lesson)
                        <a href="{{ route('trainee.courses.show', [$course, 'lesson' => $lesson->id]) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 border-start border-4 {{ $activeLessonId == $lesson->id ? 'bg-light border-primary fw-bold text-primary' : 'border-transparent' }}">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-light text-muted rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.7rem;">{{ $lesson->order }}</span>
                                <i class="fas {{ $lesson->type == 'pdf' ? 'fa-file-pdf text-danger' : 'fa-play-circle text-primary' }} me-2 opacity-75"></i>
                                <span style="font-size: 0.95rem;">{{ $lesson->title }}</span>
                            </div>
                            @if(in_array($lesson->id, $completedLessonIds))
                                <i class="fas fa-check-circle text-success fs-5"></i>
                            @else
                                <i class="far fa-circle text-muted fs-5"></i>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            @if($progress >= 100 && $course->quiz)
                <div class="mt-4">
                    <a href="{{ route('trainee.quizzes.show', $course) }}" class="btn btn-lg btn-primary w-100">Take Quiz</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
