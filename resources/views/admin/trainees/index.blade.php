<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-3">
            <span class="fs-4 fw-bold" style="color: #0f3a69;">Manage Trainees</span>
            
            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('admin.trainees.index') }}" method="GET" class="d-flex shadow-sm rounded-pill overflow-hidden bg-white">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 px-4 py-2" placeholder="Search trainees..." style="width: 250px; outline: none; box-shadow: none;">
                    <button type="submit" class="btn btn-light border-0 px-3 text-primary"><i class="fas fa-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('admin.trainees.index') }}" class="btn btn-light border-0 px-3 text-danger"><i class="fas fa-times"></i></a>
                    @endif
                </form>
                
                <a href="{{ route('admin.trainees.create') }}" class="btn rounded-pill px-4" style="background: linear-gradient(135deg, #0ea5e9, #2563eb); color: white; border: none; font-weight: 600; box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);"><i class="fas fa-user-plus me-2"></i> Add Trainee</a>
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
            margin-top: 1rem;
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
        .btn-action-edit {
            background: #e0f2fe; /* Light Blue */
            color: #0284c7; /* Dark Blue */
            border: none;
            transition: all 0.3s;
        }
        .btn-action-edit:hover {
            background: #0284c7;
            color: #ffffff;
            transform: scale(1.1);
        }
        
        .btn-action-delete {
            background: #fee2e2; /* Light Red */
            color: #ef4444; /* Red */
            border: none;
            transition: all 0.3s;
        }
        .btn-action-delete:hover {
            background: #ef4444;
            color: #ffffff;
            transform: scale(1.1);
        }
    </style>

    <div class="premium-table-container">
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Domain</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trainees as $trainee)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">
                                    {{ substr($trainee->name, 0, 1) }}
                                </div>
                                <strong class="text-dark">{{ $trainee->name }}</strong>
                            </div>
                        </td>
                        <td><span class="text-muted"><i class="fas fa-envelope me-1 opacity-50"></i> {{ $trainee->email }}</span></td>
                        <td>
                            @if($trainee->domain)
                                <span class="badge bg-info text-white rounded-pill px-3">{{ $trainee->domain }}</span>
                            @else
                                <span class="text-muted fst-italic">Unassigned</span>
                            @endif
                        </td>
                        <td><span class="text-muted"><i class="far fa-calendar-alt me-1 opacity-50"></i> {{ $trainee->created_at->format('M d, Y') }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.trainees.edit', $trainee) }}" class="btn btn-sm btn-action-edit rounded-circle me-1 shadow-sm" style="width: 36px; height: 36px; padding: 0; line-height: 36px;"><i class="fas fa-pen"></i></a>
                            <form action="{{ route('admin.trainees.destroy', $trainee) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-action-delete rounded-circle shadow-sm" style="width: 36px; height: 36px; padding: 0; line-height: 36px;" onclick="return confirm('Remove trainee?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-3x mb-3 text-light"></i>
                            <h5 class="mb-0">No trainees found</h5>
                            @if(request('search'))
                                <a href="{{ route('admin.trainees.index') }}" class="btn btn-outline-primary mt-3 rounded-pill">Clear Search</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $trainees->links('pagination::bootstrap-5') }}
    </div>
</x-app-layout>
