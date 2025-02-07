<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Highlight Paper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1 class="mb-4">Edit Highlight Paper</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('highlight.update', $highlight_paper->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $highlight_paper->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ $highlight_paper->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Picture</label><br>
                @if($highlight_paper->picture)
                    <img src="{{ asset($highlight_paper->picture) }}" alt="Current Image" width="150" class="mb-2">
                @else
                    <p>No Image Available</p>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Upload New Picture</label>
                <input type="file" name="picture" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Select Paper</label>
                <select name="paper_id" class="form-select" required>
                    <option value="">-- Select Paper --</option>
                    @foreach($papers as $paper)
                        <option value="{{ $paper->id }}" {{ $highlight_paper->paper_id == $paper->id ? 'selected' : '' }}>
                            {{ $paper->paper_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="isSelected" class="form-check-input" value="1" {{ $highlight_paper->isSelected ? 'checked' : '' }}>
                <label class="form-check-label">Set as Selected</label>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('highlight.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
