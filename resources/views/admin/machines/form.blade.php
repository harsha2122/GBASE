<div class="space-y-6">
    <!-- Machine Details -->
    <div class="admin-card">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <div class="w-8 h-8 bg-gradient-success rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 000-2H7zM4 7a1 1 0 011-1h10a1 1 0 011 1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/></svg>
            </div>
            Machine Details
        </h3>

        <div class="admin-form-group">
            <label class="admin-form-label">Machine Name *</label>
            <input type="text" name="name" value="{{ old('name', $machine->name ?? '') }}" required class="admin-form-input" placeholder="e.g., Cutting Machine">
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
                <label class="admin-form-label">URL Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $machine->slug ?? '') }}" class="admin-form-input" placeholder="Auto-generated">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="admin-form-group">
                <label class="admin-form-label">Assigned Page</label>
                <input type="text" name="page" value="{{ old('page', $machine->page ?? '') }}" class="admin-form-input" placeholder="e.g., equipments">
                <p class="text-gray-400 text-xs mt-2">Which page this machine appears on</p>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Display Order</label>
                <input type="number" name="order" value="{{ old('order', $machine->order ?? 0) }}" class="admin-form-input" placeholder="0">
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="admin-card">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <div class="w-8 h-8 bg-gradient-info rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"/></svg>
            </div>
            Description
        </h3>

        <div class="admin-form-group">
            <textarea name="description" class="admin-form-textarea" rows="6" placeholder="Detailed description of the machine...">{{ old('description', $machine->description ?? '') }}</textarea>
        </div>
    </div>

    <!-- Image -->
    <div class="admin-card">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <div class="w-8 h-8 bg-gradient-warning rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/></svg>
            </div>
            Machine Image
        </h3>

        @if(!empty($machine->image))
            <div class="mb-6">
                <img src="{{ asset('storage/' . $machine->image) }}" alt="Machine" class="max-w-md rounded-lg shadow-lg">
                <label class="flex items-center mt-4 text-gray-300 cursor-pointer">
                    <input type="checkbox" name="remove_image" class="mr-2"> Remove current image
                </label>
            </div>
        @endif

        <div class="border-2 border-dashed border-border rounded-lg p-8 text-center cursor-pointer hover:border-primary transition-colors">
            <input type="file" name="image" accept="image/*" class="hidden" id="machine-input">
            <div onclick="document.getElementById('machine-input').click()">
                <svg class="w-12 h-12 text-gray-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <p class="text-gray-300 font-medium">Click or drag to upload image</p>
                <p class="text-gray-500 text-sm mt-1">PNG, JPG up to 10MB</p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-3">
        <button type="submit" class="btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
            {{ isset($machine) ? 'Update Machine' : 'Create Machine' }}
        </button>
        <a href="{{ route('machines.index') }}" class="btn-secondary">Cancel</a>
    </div>
</div>
