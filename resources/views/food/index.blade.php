@extends('layouts.app')

@section('title', 'Pantry Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-number">{{ $items->count() }}</div>
            <div>Total Items</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-danger">
            <div class="stats-number">{{ $expiredItems->count() }}</div>
            <div>Expired Items</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-warning">
            <div class="stats-number">{{ $expiringSoon->count() }}</div>
            <div>Expiring Soon</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card bg-success">
            <div class="stats-number">{{ $items->count() - $expiredItems->count() - $expiringSoon->count() }}</div>
            <div>Fresh Items</div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-list-ul me-2"></i>Your Pantry Items</h2>
    <a href="{{ route('food-items.create') }}" class="btn btn-custom btn-primary-custom">
        <i class="bi bi-plus-circle me-2"></i>Add New Item
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-custom">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
</div>
@endif

@if($expiredItems->count() > 0)
<div class="alert alert-danger alert-custom">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <strong>Warning!</strong> You have {{ $expiredItems->count() }} expired item(s) that need attention.
</div>
@endif

@if($expiringSoon->count() > 0)
<div class="alert alert-warning alert-custom">
    <i class="bi bi-clock me-2"></i>
    <strong>Notice:</strong> {{ $expiringSoon->count() }} item(s) will expire within the next week.
</div>
@endif

<div class="card card-custom">
    <div class="card-body p-0">
        @if($items->count() > 0)
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th><i class="bi bi-box me-2"></i>Item</th>
                        <th><i class="bi bi-tags me-2"></i>Category</th>
                        <th><i class="bi bi-123 me-2"></i>Quantity</th>
                        <th><i class="bi bi-calendar me-2"></i>Expiry Date</th>
                        <th><i class="bi bi-exclamation-circle me-2"></i>Status</th>
                        <th><i class="bi bi-sticky me-2"></i>Notes</th>
                        <th><i class="bi bi-gear me-2"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    @php
                        $today = now()->toDateString();
                        $nextWeek = now()->addWeek()->toDateString();
                        $expiryDate = $item->expiry_date->toDateString();
                        
                        $status = 'fresh';
                        $statusClass = 'badge-fresh';
                        $statusText = 'Fresh';
                        $statusIcon = 'bi-check-circle';
                        
                        if ($expiryDate < $today) {
                            $status = 'expired';
                            $statusClass = 'badge-expired';
                            $statusText = 'Expired';
                            $statusIcon = 'bi-x-circle';
                        } elseif ($expiryDate <= $nextWeek) {
                            $status = 'expiring';
                            $statusClass = 'badge-expiring';
                            $statusText = 'Expiring Soon';
                            $statusIcon = 'bi-exclamation-triangle';
                        }
                    @endphp
                    <tr class="{{ $status === 'expired' ? 'table-danger' : ($status === 'expiring' ? 'table-warning' : '') }}">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @switch($item->category)
                                        @case('Fruits')
                                            <i class="bi bi-apple text-success fs-4"></i>
                                            @break
                                        @case('Vegetables')
                                            <i class="bi bi-flower1 text-success fs-4"></i>
                                            @break
                                        @case('Dairy & Alternatives')
                                            <i class="bi bi-cup text-info fs-4"></i>
                                            @break
                                        @case('Proteins')
                                            <i class="bi bi-egg text-warning fs-4"></i>
                                            @break
                                        @case('Grains & Cereals')
                                            <i class="bi bi-basket text-secondary fs-4"></i>
                                            @break
                                        @case('Beverages')
                                            <i class="bi bi-cup-straw text-primary fs-4"></i>
                                            @break
                                        @default
                                            <i class="bi bi-box text-muted fs-4"></i>
                                    @endswitch
                                </div>
                                <div>
                                    <strong>{{ $item->name }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $item->category }}</span>
                        </td>
                        <td>
                            <strong>{{ $item->quantity }}</strong> {{ $item->unit }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar3 me-2 text-muted"></i>
                                {{ $item->expiry_date->format('M d, Y') }}
                                <small class="text-muted ms-2">
                                    ({{ $item->expiry_date->diffForHumans() }})
                                </small>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $statusClass }}">
                                <i class="bi {{ $statusIcon }} me-1"></i>{{ $statusText }}
                            </span>
                        </td>
                        <td>
                            @if($item->notes)
                                <span class="text-muted" title="{{ $item->notes }}">
                                    {{ Str::limit($item->notes, 30) }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('food-items.edit', $item) }}" 
                                   class="btn btn-sm btn-custom btn-warning-custom" 
                                   title="Edit Item">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('food-items.destroy', $item) }}" 
                                      method="POST" 
                                      style="display:inline"
                                      onsubmit="return confirmDelete('{{ $item->name }}')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-custom btn-danger-custom" 
                                            title="Delete Item">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-basket text-muted" style="font-size: 4rem;"></i>
            <h4 class="text-muted mt-3">Your pantry is empty!</h4>
            <p class="text-muted">Start by adding your first food item to track your inventory.</p>
            <a href="{{ route('food-items.create') }}" class="btn btn-custom btn-primary-custom mt-3">
                <i class="bi bi-plus-circle me-2"></i>Add Your First Item
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Floating Action Button for Mobile -->
<div class="floating-action d-md-none">
    <a href="{{ route('food-items.create') }}" class="floating-btn">
        <i class="bi bi-plus"></i>
    </a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling for better UX
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
        row.classList.add('fade-in');
    });
});
</script>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}
</style>
@endsection