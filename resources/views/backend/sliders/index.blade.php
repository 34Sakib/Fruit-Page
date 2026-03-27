@extends('backend.layouts.master')

@section('title', 'Manage Sliders')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Image container styles */
    .table td {
        vertical-align: middle !important;
    }

    /* Table layout improvements */
    table.table td,
    table.table th {
        vertical-align: middle !important;
        padding: 8px 10px !important;
        font-size: 14px;
    }

    .sortable-ghost { opacity: 0.4; background: #d7f0ff !important; }

    .slider-item { cursor: move; transition: background-color 0.2s ease; }
    .slider-item:hover { background-color: #f5f5f5; }

    td:nth-child(3) { max-width: 180px; word-break: break-word; }
    td:nth-child(4) { max-width: 220px; word-break: break-word; }

    @media (max-width: 768px) {
        .table td:nth-child(2) > div > div {
            width: 80px !important;
            height: 60px !important;
        }
        td:nth-child(3) { 
            max-width: 120px; 
        }
        td:nth-child(4) { 
            display: none; 
        }
    }
</style>
@endpush



@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Sliders</h3>
                        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Slider
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Order</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody id="sortable">
                                @forelse($sliders as $slider)
                                    <tr class="slider-item" data-id="{{ $slider->id }}">

                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div style="width: 120px; height: 80px; overflow: hidden;" class="d-flex align-items-center justify-content-center border rounded">
                                                    @if($slider->image)
                                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('no-image.png') }}" alt="No Image" class="img-fluid h-100 w-100" style="object-fit: cover;">
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ $slider->title }}</td>

                                        <td>{{ Str::limit($slider->description, 50) }}</td>

                                        <td>
                                            <span class="badge {{ $slider->is_active ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>

                                        <td>{{ $slider->order }}</td>

                                        <td>
                                            <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.sliders.destroy', $slider->id) }}" 
                                                  method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this slider?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No sliders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sortable = document.getElementById('sortable');

    new Sortable(sortable, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: function () {
            const sliderItems = Array.from(sortable.querySelectorAll('tr[data-id]'));
            const sliders = sliderItems.map((item, index) => ({
                id: item.getAttribute('data-id'),
                order: index + 1
            }));

            axios.post('{{ route("admin.sliders.update-order") }}', { sliders })
                .then(response => {
                    if (response.data.success) {
                        sliderItems.forEach((item, index) => {
                            const orderCell = item.querySelector('td:nth-child(6)');
                            if (orderCell) orderCell.textContent = index + 1;
                        });
                    }
                })
                .catch(error => console.error('Order update error:', error));
        }
    });
});
</script>
@endpush
