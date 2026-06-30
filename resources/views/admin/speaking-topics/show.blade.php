@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Speaking Topic Details</h1>

        <div class="card">
            <div class="card-body">
                <h3>{{ $speakingTopic->title }}</h3>
                <p><strong>Slug:</strong> {{ $speakingTopic->slug }}</p>
                <p><strong>Status:</strong> {{ $speakingTopic->is_active ? 'Active' : 'Inactive' }}</p>
                <p><strong>Description:</strong></p>
                <p>{{ $speakingTopic->description ?: 'No description provided.' }}</p>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.speaking-topics.edit', $speakingTopic) }}" class="btn btn-warning">
                Edit
            </a>
            <a href="{{ route('admin.speaking-topics.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>
@endsection