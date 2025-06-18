@extends('layouts.app')

@section('title', 'Add New Item - Pantry Tracker')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-plus-circle me-2"></i>Add New Food Item</h2>
        <p class="text-muted mb-0">Fill in the details below to add a new item to your pantry</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('food-items.index') }}">Pantry</a></li>
            <li class="breadcrumb-item active">Add Item</li>
        </ol>
    </nav>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-custom">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@include('food._form', [
    'action' => route('food-items.store'), 
    'method' => 'POST'
])

<style>
.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: var(--secondary-color);
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: var(--dark-text);
}
</style>
@endsection