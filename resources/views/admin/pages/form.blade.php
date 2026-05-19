<div class="space-y-6">
    <!-- Page Information -->
    <div class="admin-card">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <div class="w-8 h-8 bg-gradient-primary rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"/></svg>
            </div>
            Page Information
        </h3>

        <div class="admin-form-group">
            <label class="admin-form-label">Page Title *</label>
            <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" required class="admin-form-input" placeholder="Enter page title">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="admin-form-group">
                <label class="admin-form-label">Slug (URL) *</label>
                <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" required class="admin-form-input" placeholder="page-slug">
                <p class="text-gray-400 text-xs mt-2">URL: /{{ old('slug', $page->slug ?? 'slug') }}</p>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label">Breadcrumb Navigation</label>
                <input type="text" name="breadcrumb" value="{{ old('breadcrumb', $page->breadcrumb ?? '') }}" class="admin-form-input" placeholder="e.g., Home > Products">
            </div>
        </div>

        <div class="admin-form-group">
            <label class="admin-form-label">Meta Description (SEO)</label>
            <textarea name="meta_description" class="admin-form-textarea" rows="2" placeholder="Brief description for search engines (160 chars)">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
            <p class="text-gray-400 text-xs mt-2">Recommended: 150-160 characters</p>
        </div>
    </div>

    <!-- Content -->
    <div class="admin-card">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <div class="w-8 h-8 bg-gradient-success rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a1 1 0 011-1h10a1 1 0 011 1v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
            </div>
            Page Content
        </h3>

        <div class="admin-form-group">
            <label class="admin-form-label">Content *</label>
            <textarea name="content" required class="admin-form-textarea" rows="10" placeholder="Enter your page content here...">{{ old('content', $page->content ?? '') }}</textarea>
            <p class="text-gray-400 text-xs mt-2">HTML and basic formatting supported</p>
        </div>
    </div>

    <!-- Hero Image -->
    <div class="admin-card">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <div class="w-8 h-8 bg-gradient-warning rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/></svg>
            </div>
            Hero Image
        </h3>

        @if(!empty($page->hero_image))
            <div class="mb-6">
                <img src="{{ asset('storage/' . $page->hero_image) }}" alt="Hero" class="max-w-md rounded-lg shadow-lg">
                <label class="flex items-center mt-4 text-gray-300 cursor-pointer">
                    <input type="checkbox" name="remove_hero_image" class="mr-2"> Remove this image
                </label>
            </div>
        @endif

        <div class="border-2 border-dashed border-border rounded-lg p-8 text-center cursor-pointer hover:border-primary transition-colors">
            <input type="file" name="hero_image" accept="image/*" class="hidden" id="hero-input">
            <div onclick="document.getElementById('hero-input').click()">
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
            {{ isset($page) ? 'Update Page' : 'Create Page' }}
        </button>
        <a href="{{ route('pages.index') }}" class="btn-secondary">Cancel</a>
    </div>
</div>
