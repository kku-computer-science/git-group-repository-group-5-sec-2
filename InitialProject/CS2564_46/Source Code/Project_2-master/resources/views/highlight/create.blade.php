<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create Highlight</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #fff;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            padding: 25px;
        }

        
    </style>
</head>

<body>

    @extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">สร้าง Highlight ใหม่</h2>

    <form action="{{ route('highlight.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">หัวเรื่อง</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Detail -->
        <div class="mb-3">
            <label for="detail" class="form-label">รายละเอียด</label>
            <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" 
                rows="8" style="height: 200px; resize: vertical;" required></textarea>
            @error('detail')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Cover Image Upload -->
        <div class="mb-3">
            <label for="cover_image" class="form-label">อัปโหลดภาพปก (ขนาดแนะนำ 1600 x 900)</label>
            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" required>
            <img id="coverPreview" src="#" alt="Cover Preview" class="img-fluid mt-2 d-none" style="max-width: 200px;">
            @error('cover_image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Multiple Images Upload -->
        <div class="mb-3">
            <label for="images" class="form-label">อัปโหลดอัลบั้มภาพ</label>
            <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
            <div id="imagePreviewContainer" class="mt-2"></div>
            @error('images')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Select Tags -->
        <div class="mb-3">
            <label class="form-label">เลือก Tags</label>
            <div class=" ms-4 d-flex flex-wrap gap-3">
                @foreach ($tags as $tag)
                    <div class="col-md-1">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}">
                            <label for="tag{{ $tag->id }}">{{ $tag->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('tags')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        
        

        <button type="submit" class="btn btn-primary">สร้าง Highlight</button>
        <a href="{{ route('highlight.index') }}" class="btn btn-secondary">ยกเลิก</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('cover_image').addEventListener('change', function(event) {
    let coverPreview = document.getElementById('coverPreview');
    if (event.target.files.length > 0) {
        let file = event.target.files[0];
        coverPreview.src = URL.createObjectURL(file);
        coverPreview.classList.remove('d-none');
    }
});

// แสดงรูปตัวอย่างหลายรูป
document.getElementById('images').addEventListener('change', function(event) {
    let previewContainer = document.getElementById('imagePreviewContainer');
    previewContainer.innerHTML = ''; // เคลียร์รูปเก่าออกก่อน
    
    if (event.target.files.length > 0) {
        Array.from(event.target.files).forEach(file => {
            let img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.classList.add('img-thumbnail', 'm-1');
            img.style.maxWidth = '100px';
            previewContainer.appendChild(img);
        });
    }
});
</script>
@endsection




</body>

</html>