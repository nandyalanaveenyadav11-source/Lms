<x-app-layout>
    <x-slot name="header">Edit Course: {{ $course->title }}</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.courses.update', $course) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Course Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Domain (Leave blank for Common Course)</label>
                            <input type="text" name="domain" class="form-control" value="{{ $course->domain }}" placeholder="e.g. Web Development">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="5">{{ $course->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Course</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
