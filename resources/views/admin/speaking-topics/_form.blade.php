<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input
            type="text"
            name="title"
            id="title"
            class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $speakingTopic->title ?? '') }}"
    >
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea
            name="description"
            id="description"
            rows="4"
            class="form-control @error('description') is-invalid @enderror"
    >{{ old('description', $speakingTopic->description ?? '') }}</textarea>
    @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check mb-3">
    <input
            type="checkbox"
            name="is_active"
            id="is_active"
            class="form-check-input"
            value="1"
            {{ old('is_active', $speakingTopic->is_active ?? true) ? 'checked' : '' }}
    >
    <label for="is_active" class="form-check-label">Active</label>
</div>

<button type="submit" class="btn btn-primary">
    {{ $buttonText }}
</button>
<a href="{{ route('admin.speaking-topics.index') }}" class="btn btn-secondary">
    Cancel
</a>