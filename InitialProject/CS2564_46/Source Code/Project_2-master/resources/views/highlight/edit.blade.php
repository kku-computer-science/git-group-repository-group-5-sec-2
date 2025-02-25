<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>edit Highlight</title>

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

        .form-check {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 20px;
            padding: 6px 12px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-check:hover {
            background: #e9ecef;
        }

        .form-check-input {
            display: none;
        }

        .form-check label {
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check label::before {
            content: "";
            width: 20px;
            height: 20px;
            border: 2px solid #ccc;
            border-radius: 50%;
            display: inline-block;
            transition: all 0.3s ease;
            margin-left: 8px;
            flex-shrink: 0;
        }

        .form-check-input:checked+label::before {
            background: blue;
            border-color: blue;
            content: "✔";
            color: white;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>

    @extends('dashboards.users.layouts.user-dash-layout')

    @section('content')
        <div class="container mt-5">
            <h2 class="mb-4">แก้ไข Highlight</h2>

            <form action="{{ route('highlight.update', $highlight->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ $highlight->title }}" required>
                </div>

                <!-- Detail -->
                <div class="mb-3">
                    <label class="form-label">Detail</label>
                    <textarea class="form-control" name="detail" rows="8" style="height: 200px; resize: vertical;"
                        required>{{ $highlight->detail }}</textarea>
                </div>

                <!-- Cover Image -->
                <div class="mb-3">
                    <label class="form-label">Cover Image ปัจจุบัน</label>
                    <img src="{{ asset($highlight->cover_image) }}" class="img-fluid mt-2 col-md-12">
                    <label class="form-label mt-3">Cover Image ใหม่</label>
                    <input type="file" class="form-control" name="cover_image">
                </div>

                <!-- Images ที่อัปโหลดไปแล้ว -->
                <div class="mb-3">
                    <label class="form-label">Images ที่อัปโหลดแล้ว</label>
                    <div class="d-flex flex-wrap">
                        @foreach ($highlight->images as $image)
                            <div id="image-{{ $image->id }}" class="position-relative m-2">
                                <img src="{{ asset($image->image_path) }}" class="img-thumbnail" style="max-width: 100px;">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                    onclick="deleteImage({{ $image->id }})">
                                    ×
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- อัปโหลด Images ใหม่ -->
                <div class="mb-3">
                    <label class="form-label">เพิ่ม Images ใหม่</label>
                    <input type="file" class="form-control" name="images[]" multiple>
                </div>

        <!-- Tags -->
        <div class="mb-3">
            <label class="form-label">เลือก Tags</label>
            <div class="ms-4 d-flex flex-wrap gap-2">
                @foreach ($tags as $tag)
                    <div class="col-md-1">
                        <input type="checkbox" class="form-check-input" name="tags[]" value="{{ $tag->id }}"
                            {{ in_array($tag->id, $highlight->tags->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $tag->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

                <!-- Active Status -->
                <div class="mb-3">
                    <label class="form-label">สถานะการแสดงผล</label>
                    <select class="form-select" disabled>
                        <option value="1" {{ $highlight->active == 1 ? 'selected' : '' }}>แสดง</option>
                        <option value="0" {{ $highlight->active == 0 ? 'selected' : '' }}>ไม่แสดง</option>
                    </select>
                    <input type="hidden" name="active" value="{{ $highlight->active }}">
                </div>



                <!-- ปุ่มอัปเดต และ ย้อนกลับ -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">อัปเดต</button>
                    <a href="{{ route('highlight.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
                </div>
            </form>
        </div>
    @endsection

    @section('javascript')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function deleteImage(imageId) {
                if (!confirm('คุณต้องการลบรูปภาพนี้หรือไม่?')) return;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/highlight/image/delete/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`image-${imageId}`).remove();
                        } else {
                            alert('เกิดข้อผิดพลาด: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
                        console.error('Error:', error);
                    });
            }
        </script>
    @endsection

</body>

</html>
