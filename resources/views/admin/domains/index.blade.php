<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
            <div>
                <span class="text-muted text-uppercase small fw-bold tracking-wider">System Settings</span>
                <h3 class="fw-bold mb-0" style="color: #0f3a69;">Manage Domains</h3>
            </div>
            <button class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#createDomainModal">
                <i class="fas fa-plus me-1"></i> Add New Domain
            </button>
        </div>
    </x-slot>

    <style>
        .domain-card {
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.03);
            transition: all 0.3s;
            height: 100%;
        }
        .domain-card:hover { transform: translateY(-5px); box-shadow: 0 15px 50px rgba(0,0,0,0.08); }
        
        .domain-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .count-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-weight: 600;
        }
    </style>

    <div class="row g-4">
        @forelse($domains as $domain)
        <div class="col-lg-3 col-md-4">
            <div class="domain-card p-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="domain-icon">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link link-muted p-0" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2" style="border-radius: 12px;">
                                <li>
                                    <button class="dropdown-item rounded-3" data-bs-toggle="modal" data-bs-target="#editDomainModal{{ $domain->id }}">
                                        <i class="fas fa-edit me-2 small"></i> Edit Name
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger rounded-3" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash me-2 small"></i> Delete Domain
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark mb-3">{{ $domain->name }}</h5>
                </div>
                
                <div class="mt-auto">
                    <div class="d-flex flex-wrap gap-2">
                        <span class="count-badge bg-soft-info text-info">
                            <i class="fas fa-book-open me-1"></i> {{ $domain->courses_count }} Courses
                        </span>
                        <span class="count-badge bg-soft-success text-success">
                            <i class="fas fa-users me-1"></i> {{ $domain->trainees_count }} Trainees
                        </span>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editDomainModal{{ $domain->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('admin.domains.update', $domain) }}" method="POST" class="w-100">
                        @csrf @method('PUT')
                        <div class="modal-content rounded-4 border-0">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Edit Domain</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body py-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">DOMAIN NAME</label>
                                    <input type="text" name="name" class="form-control py-2 px-3 rounded-3" value="{{ $domain->name }}" required>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-gradient-primary">Update Domain</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted">
                <i class="fas fa-ghost fa-3x mb-3 opacity-20"></i>
                <p>No domains created yet. Start by adding a domain for better categorization.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createDomainModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.domains.store') }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content rounded-4 border-0">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Add New Domain</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">DOMAIN NAME</label>
                            <input type="text" name="name" class="form-control py-2 px-3 rounded-3" placeholder="e.g. Web Development" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-primary">Create Domain</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
