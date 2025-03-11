@extends('layouts.layout')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100..900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        font-family: 'Kanit', sans-serif;
    }

    .search-container {
        position: relative;
        width: 80vw;
    }

    .tag-input-container {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
        padding: 5px;
        border: 1px solid #ced4da;
        border-radius: 20px;
        min-height: 38px;
    }

    .tag-input-container .tag {
        display: inline-flex;
        align-items: center;
        background-color: #e9ecef;
        padding: 5px 10px;
        margin: 2px;
        border-radius: 20px;
        font-size: 14px;
    }

    .tag-input-container .tag:hover {
        transition: 0.3s;
        opacity: 0.75;
        transform: scale(0.95);
    }

    .tag-input-container .remove-tag {
        margin-left: 8px;
        cursor: pointer;
        color: #dc3545;
        font-weight: bold;
    }

    .tag-input-container input {
        border: none;
        outline: none;
        flex-grow: 1;
        min-width: 100px;
        padding: 5px;
        font-family: 'Kanit', sans-serif;
    }

    .tag-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ced4da;
        border-radius: 5px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .tag-suggestion {
        padding: 8px 12px;
        cursor: pointer;
    }

    .tag-suggestion:hover {
        background-color: #f8f9fa;
    }

    .highlight-item {
        display: block;
        text-decoration: none !important;
        color: inherit;
    }

    .highlight-item .card {
        transition: background-color 0.3s ease, transform 0.2s ease;
        border-radius: 8px;
        overflow: hidden;
    }

    .highlight-item img {
        width: 250px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }

    .highlight-item:hover .card {
        background-color: #f0f0f0;
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-primary {
        padding: 3px 6px;
        translate: 0px -4px;
        opacity: 80%;
    }
</style>

<div class="container py-5">
    <div class="mb-4">
        <div class="d-flex gap-2">
            <div class="search-container">
                <div class="tag-input-container" id="tagInputContainer">
                    <!-- show selected tags -->
                    @if(request('tags'))
                        @foreach(explode(',', request('tags')) as $selectedTag)
                            <span class="tag">
                                {{ $selectedTag }}
                                <span class="remove-tag" data-tag="{{ $selectedTag }}">×</span>
                            </span>
                        @endforeach
                    @endif
                    <input type="text" id="tagSearch" placeholder="{{ trans('message.search_tags') }}">
                </div>
                <div class="tag-suggestions" id="tagSuggestions">
                    @foreach($availableTags as $tag)
                        <div class="tag-suggestion" data-tag="{{ $tag->name }}"> <span class="fas fa-plus"></span> {{ $tag->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        <input type="hidden" name="tags" id="tagsInput" value="">
    </div>
    
    <p class="text-muted">{{ trans('message.found') }} {{ $highlights->count() }} {{ trans('message.result') }}</p>

    @if ($highlights->isEmpty())
        <p class="text-danger">{{ trans('message.notfound') }}</p>
    @endif

    <div id="highlight-list" class="row g-4">
        @foreach($highlights as $highlight)
            <div class="col-12">
                <a href="{{ route('highlight.detail', ['id' => $highlight->id]) }}" class="highlight-item">
                    <div class="card border-0 shadow-sm d-flex flex-row p-2 align-items-center">
                        <img src="{{ asset($highlight->cover_image) }}" class="img-fluid rounded-start">
                        <div class="card-body">
                            <h5 class="fw-bold text-primary">
                                {{ $highlight->title }}
                            </h5>
                            <p class="text-muted mb-2">
                                {{ Str::limit($highlight->detail, 250) }}
                            </p>
                            <div class="text-muted">
                                สร้างเมื่อ {{ \Carbon\Carbon::parse($highlight->updated_at)->format('d/m/Y') }}
                            </div>
                            <div class="d-flex gap-2">
                                @foreach($highlight->tags as $tag)
                                    <a href="highlights/tag/{{ $tag->name }}" class="btn btn-outline-primary mt-2">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tagInputContainer = document.getElementById('tagInputContainer');
    const searchInput = document.getElementById('tagSearch');
    const suggestionsContainer = document.getElementById('tagSuggestions');
    const tagsInput = document.getElementById('tagsInput');

    const urlParams = new URLSearchParams(window.location.search);
    let selectedTags = urlParams.get('tags') ? urlParams.get('tags').split(',') : [];

    searchInput.addEventListener('focus', function() {
        suggestionsContainer.style.display = 'block';
        filterSuggestions('');
    });

    document.addEventListener('click', function(e) {
        if (!tagInputContainer.contains(e.target) && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.style.display = 'none';
        }
    });

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        filterSuggestions(query);
    });
    
    suggestionsContainer.addEventListener('click', function(e) {
        const suggestion = e.target.closest('.tag-suggestion');
        if (suggestion) {
            const tag = suggestion.getAttribute('data-tag');
            if (!selectedTags.includes(tag)) {
                selectedTags.push(tag);
                updateTagsDisplay();
                filterHighlights();
                searchInput.value = '';
                filterSuggestions('');
            }
        }
    });

    function attachTagListeners() {
        document.querySelectorAll('.tag').forEach(tagElement => {
            tagElement.style.cursor = 'pointer';
            tagElement.addEventListener('click', function(e) {
                const tagToRemove = this.querySelector('.remove-tag').getAttribute('data-tag');
                selectedTags = selectedTags.filter(t => t !== tagToRemove);
                updateTagsDisplay();
                filterHighlights();
                filterSuggestions('');
            });
        });
    }

    attachTagListeners();

    function updateTagsDisplay() {
        const input = tagInputContainer.querySelector('input');
        tagInputContainer.innerHTML = '';
        selectedTags.forEach(tag => {
            const tagElement = document.createElement('span');
            tagElement.className = 'tag';
            tagElement.innerHTML = `${tag} <span class="remove-tag" data-tag="${tag}">×</span>`;
            tagInputContainer.appendChild(tagElement);
        });
        tagInputContainer.appendChild(input);

        tagsInput.value = selectedTags.join(',');
        attachTagListeners();
    }

    // filter tag search
    function filterSuggestions(query) {
        const suggestions = suggestionsContainer.querySelectorAll('.tag-suggestion');
        suggestions.forEach(suggestion => {
            const tag = suggestion.getAttribute('data-tag').toLowerCase();
            const matchesQuery = tag.includes(query);
            const isNotSelected = !selectedTags.includes(tag);
            suggestion.style.display = (matchesQuery && isNotSelected) ? 'block' : 'none';
        });
    }
    
    function filterHighlights() {
        const url = new URL(window.location.href);
        url.searchParams.set('tags', selectedTags.join(','));
        window.history.pushState({}, document.title, url);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                document.querySelector('#highlight-list').innerHTML = 
                    new DOMParser().parseFromString(html, 'text/html')
                    .querySelector('#highlight-list').innerHTML;
                const count = document.querySelector('#highlight-list').children.length;
                document.querySelector('.text-muted').textContent = `{{ trans('message.found') }} ${count} {{ trans('message.result') }}`;
            })
            .catch(error => console.error('Error:', error));
    }
});
</script>

@endsection