<x-app-layout>
    <x-slot name="header">Edit Trainee: {{ $trainee->name }}</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.trainees.update', $trainee) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $trainee->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $trainee->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Domain</label>
                            <input type="text" name="domain" class="form-control" value="{{ $trainee->domain }}" placeholder="e.g. Web Development, Data Science">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password (Leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Trainee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
