<div class="space-y-8">
    <!-- Basic Information -->
    <div class="admin-card">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Basic Information</h3>

        <div class="admin-form-group">
            <label class="admin-form-label">Page Title *</label>
            <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" required class="admin-form-input" placeholder="Enter page title">
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Page Slug *</label>
            <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" required class="admin-form-input" placeholder="e.g., home, about, contact">
            <p class="text-gray-500 text-sm mt-2">Used in URL: example.com/{{ old('slug', $page->slug ?? 'slug') }}</p>
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Breadcrumb Text</label>
            <input type="text" name="breadcrumb" value="{{ old('breadcrumb', $page->breadcrumb ?? '') }}" class="admin-form-input" placeholder="Navigation breadcrumb text">
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Meta Description (SEO)</label>
            <textarea name="meta_description" class="admin-form-textarea" rows="3" placeholder="Brief description for search engines (160 chars max)">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
            <p class="text-gray-500 text-sm mt-2">Maximum 160 characters</p>
        </div>
    </div>

    <!-- Hero Image -->
    <div class="admin-card">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Hero Image</h3>

        <div class="admin-form-group">
            @if(!empty($page->hero_image))
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $page->hero_image) }}" alt="Hero" class="max-w-sm rounded-lg shadow-md">
                    <label class="flex items-center mt-2 text-sm">
                        <input type="checkbox" name="remove_hero_image" class="mr-2"> Remove current image
                    </label>
                </div>
            @endif

            <label class="admin-form-label">Upload New Image</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-gray-400 transition-colors">
                <input type="file" name="hero_image" accept="image/*" class="hidden" id="hero-input">
                <div onclick="document.getElementById('hero-input').click()">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <p class="text-gray-600">Click or drag to upload image</p>
                    <p class="text-gray-500 text-sm mt-1">PNG, JPG up to 10MB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="admin-card">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Page Content</h3>

        <div class="admin-form-group">
            <label class="admin-form-label">Content *</label>
            <textarea name="content" required class="admin-form-textarea" rows="10" placeholder="Enter page content here...">{{ old('content', $page->content ?? '') }}</textarea>
            <p class="text-gray-500 text-sm mt-2">Note: Rich text editor (with formatting) will be available in the next update</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-4">
        <button type="submit" class="admin-btn-primary">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                {{ isset($page) ? 'Update Page' : 'Create Page' }}
            </span>
        </button>
        <a href="{{ route('pages.index') }}" class="admin-btn-secondary">Cancel</a>
    </div>
</div>
