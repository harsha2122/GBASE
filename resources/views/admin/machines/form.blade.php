<div class="space-y-8">
    <!-- Basic Information -->
    <div class="admin-card">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Machine Information</h3>

        <div class="admin-form-group">
            <label class="admin-form-label">Machine Name *</label>
            <input type="text" name="name" value="{{ old('name', $machine->name ?? '') }}" required class="admin-form-input" placeholder="Enter machine name">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="admin-form-group">
                <label class="admin-form-label">Category *</label>
                <select name="category" required class="admin-form-select">
                    <option value="">Select Category</option>
                    <option value="Pre-Process" {{ old('category', $machine->category ?? '') === 'Pre-Process' ? 'selected' : '' }}>Pre-Process</option>
                    <option value="Freezing" {{ old('category', $machine->category ?? '') === 'Freezing' ? 'selected' : '' }}>Freezing</option>
                    <option value="Heating" {{ old('category', $machine->category ?? '') === 'Heating' ? 'selected' : '' }}>Heating</option>
                    <option value="Sorting" {{ old('category', $machine->category ?? '') === 'Sorting' ? 'selected' : '' }}>Sorting</option>
                </select>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $machine->slug ?? '') }}" class="admin-form-input" placeholder="Auto-generated if empty">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="admin-form-group">
                <label class="admin-form-label">Assigned Page</label>
                <input type="text" name="page" value="{{ old('page', $machine->page ?? '') }}" class="admin-form-input" placeholder="e.g., equipments, freezing">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Display Order</label>
                <input type="number" name="order" value="{{ old('order', $machine->order ?? 0) }}" class="admin-form-input" placeholder="Display order">
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="admin-card">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Description</h3>

        <div class="admin-form-group">
            <label class="admin-form-label">Description</label>
            <textarea name="description" class="admin-form-textarea" rows="6" placeholder="Detailed machine description">{{ old('description', $machine->description ?? '') }}</textarea>
        </div>
    </div>

    <!-- Machine Image -->
    <div class="admin-card">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Machine Image</h3>

        <div class="admin-form-group">
            @if(!empty($machine->image))
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $machine->image) }}" alt="Machine" class="max-w-sm rounded-lg shadow-md">
                    <label class="flex items-center mt-2 text-sm">
                        <input type="checkbox" name="remove_image" class="mr-2"> Remove current image
                    </label>
                </div>
            @endif

            <label class="admin-form-label">Upload Image</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-gray-400 transition-colors">
                <input type="file" name="image" accept="image/*" class="hidden" id="machine-input">
                <div onclick="document.getElementById('machine-input').click()">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <p class="text-gray-600">Click or drag to upload image</p>
                    <p class="text-gray-500 text-sm mt-1">PNG, JPG up to 10MB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-4">
        <button type="submit" class="admin-btn-primary">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                {{ isset($machine) ? 'Update Machine' : 'Create Machine' }}
            </span>
        </button>
        <a href="{{ route('machines.index') }}" class="admin-btn-secondary">Cancel</a>
    </div>
</div>
