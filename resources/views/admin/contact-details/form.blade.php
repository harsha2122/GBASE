<div class="space-y-8">
    <!-- Contact Information -->
    <div class="admin-card">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Contact Information</h3>

        <div class="admin-form-group">
            <label class="admin-form-label">Type *</label>
            <select name="type" required class="admin-form-select">
                <option value="">Select Type</option>
                <option value="phone" {{ old('type', $contact->type ?? '') === 'phone' ? 'selected' : '' }}>Phone</option>
                <option value="email" {{ old('type', $contact->type ?? '') === 'email' ? 'selected' : '' }}>Email</option>
                <option value="whatsapp" {{ old('type', $contact->type ?? '') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                <option value="address" {{ old('type', $contact->type ?? '') === 'address' ? 'selected' : '' }}>Address</option>
            </select>
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Value *</label>
            <input type="text" name="value" value="{{ old('value', $contact->value ?? '') }}" required class="admin-form-input" placeholder="e.g., +91 98765 43210">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="admin-form-group">
                <label class="admin-form-label">Icon (Font Awesome)</label>
                <input type="text" name="icon" value="{{ old('icon', $contact->icon ?? '') }}" class="admin-form-input" placeholder="e.g., fas fa-phone">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Display Order</label>
                <input type="number" name="order" value="{{ old('order', $contact->order ?? 0) }}" class="admin-form-input">
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-4">
        <button type="submit" class="admin-btn-primary">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                {{ isset($contact) ? 'Update Contact' : 'Add Contact' }}
            </span>
        </button>
        <a href="{{ route('contact-details.index') }}" class="admin-btn-secondary">Cancel</a>
    </div>
</div>
