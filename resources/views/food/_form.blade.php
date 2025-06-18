<div class="card card-custom">
    <div class="card-body">
        <form method="POST" action="{{ $action }}" id="foodItemForm">
            @csrf
            @if(in_array($method, ['PUT', 'DELETE'])) @method($method) @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-box me-2"></i>Item Name
                        </label>
                        <input name="name" 
                               type="text" 
                               class="form-control form-control-custom @error('name') is-invalid @enderror" 
                               value="{{ old('name', $foodItem->name ?? '') }}" 
                               placeholder="Enter item name (e.g., Organic Apples)"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-tags me-2"></i>Category
                        </label>
                        <select name="category" 
                                class="form-select form-control-custom @error('category') is-invalid @enderror" 
                                required 
                                id="categorySelect">
                            <option value="" disabled selected>Choose a category...</option>
                            @foreach($categories as $categoryGroup => $items)
                                <optgroup label="{{ $categoryGroup }}">
                                    @foreach($items as $item)
                                        <option value="{{ $item }}" 
                                                {{ old('category', $foodItem->category ?? '') == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-123 me-2"></i>Quantity
                        </label>
                        <input name="quantity" 
                               type="number" 
                               step="0.01" 
                               min="0" 
                               class="form-control form-control-custom @error('quantity') is-invalid @enderror" 
                               value="{{ old('quantity', $foodItem->quantity ?? '') }}" 
                               placeholder="0.00"
                               required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-rulers me-2"></i>Unit
                        </label>
                        <select name="unit" 
                                class="form-select form-control-custom @error('unit') is-invalid @enderror" 
                                required>
                            <option value="" disabled selected>Select unit...</option>
                            @foreach($units as $unitGroup => $unitItems)
                                <optgroup label="{{ $unitGroup }}">
                                    @foreach($unitItems as $unit)
                                        <option value="{{ $unit }}" 
                                                {{ old('unit', $foodItem->unit ?? '') == $unit ? 'selected' : '' }}>
                                            {{ $unit }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-calendar3 me-2"></i>Expiry Date
                        </label>
                        <input name="expiry_date" 
                               type="date" 
                               class="form-control form-control-custom @error('expiry_date') is-invalid @enderror" 
                               value="{{ old('expiry_date', isset($foodItem) ? $foodItem->expiry_date->format('Y-m-d') : '') }}" 
                               min="{{ date('Y-m-d') }}"
                               required>
                        @error('expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Select when this item expires
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">
                    <i class="bi bi-sticky me-2"></i>Notes (Optional)
                </label>
                <textarea name="notes" 
                          class="form-control form-control-custom @error('notes') is-invalid @enderror" 
                          rows="3" 
                          placeholder="Add any additional notes about this item (e.g., brand, storage location, special instructions)">{{ old('notes', $foodItem->notes ?? '') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">
                    <i class="bi bi-info-circle me-1"></i>
                    Maximum 500 characters
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('food-items.index') }}" class="btn btn-outline-secondary btn-custom">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                
                <div>
                    @if(isset($foodItem))
                        <button type="button" class="btn btn-outline-danger btn-custom me-2" onclick="resetForm()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </button>
                    @endif
                    <button type="submit" class="btn btn-custom btn-success-custom">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ isset($foodItem) ? 'Update Item' : 'Save Item' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('categorySelect');
    const nameInput = document.querySelector('input[name="name"]');
    
    // Auto-suggest names based on category
    const categoryToNames = {
        'Rice': ['Jasmine Rice', 'Brown Rice', 'Basmati Rice', 'White Rice'],
        'Chicken': ['Chicken Breast', 'Chicken Thighs', 'Whole Chicken', 'Ground Chicken'],
        'Milk': ['Whole Milk', 'Skim Milk', '2% Milk', 'Almond Milk'],
        'Apples': ['Red Apples', 'Green Apples', 'Gala Apples', 'Granny Smith'],
        'Potatoes': ['Russet Potatoes', 'Red Potatoes', 'Sweet Potatoes', 'Baby Potatoes'],
        // Add more as needed
    };
    
    categorySelect.addEventListener('change', function() {
        const selectedCategory = this.value;
        if (categoryToNames[selectedCategory] && !nameInput.value) {
            // Create a datalist for autocomplete
            let datalist = document.getElementById('namesList');
            if (!datalist) {
                datalist = document.createElement('datalist');
                datalist.id = 'namesList';
                nameInput.parentNode.appendChild(datalist);
                nameInput.setAttribute('list', 'namesList');
            }
            
            datalist.innerHTML = '';
            categoryToNames[selectedCategory].forEach(name => {
                const option = document.createElement('option');
                option.value = name;
                datalist.appendChild(option);
            });
        }
    });
    
    // Form validation
    const form = document.getElementById('foodItemForm');
    form.addEventListener('submit', function(e) {
        const quantity = parseFloat(document.querySelector('input[name="quantity"]').value);
        if (quantity <= 0) {
            e.preventDefault();
            alert('Quantity must be greater than 0');
            return false;
        }
    });
});

function resetForm() {
    if (confirm('Are you sure you want to reset all fields? This will undo any changes you made.')) {
        document.getElementById('foodItemForm').reset();
    }
}

// Add character counter for notes
document.querySelector('textarea[name="notes"]').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;
    const remaining = maxLength - currentLength;
    
    let counter = document.getElementById('notesCounter');
    if (!counter) {
        counter = document.createElement('small');
        counter.id = 'notesCounter';
        counter.className = 'text-muted';
        this.parentNode.appendChild(counter);
    }
    
    counter.textContent = `${remaining} characters remaining`;
    counter.style.color = remaining < 50 ? '#dc3545' : '#6c757d';
});
</script>