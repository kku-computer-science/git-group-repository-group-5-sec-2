<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Tags</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #fff;
            font-family: 'Noto Sans Thai', sans-serif !important;
        }

        .container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            padding: 25px;
        }

        /* สไตล์ข้อความแจ้งเตือน */
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
            /* ซ่อนเริ่มต้น */
        }
    </style>
</head>

<body>

    @extends('dashboards.users.layouts.user-dash-layout')
    @section('content')
        <div class="container mt-5">
            <div class="card p-4 shadow-sm">
                <h2 class="card-title mb-4 text-center">
                    <i class="fas fa-tag me-2"></i> สร้างแท็กใหม่
                </h2>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="tag-form" action="{{ route('tags.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="form-label">ชื่อแท็ก</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required>
                        <div id="name-error" class="error-message text-danger">❌ ห้ามมีช่องว่างใน Tag Name</div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary w-48">สร้าง</button>
                        <a href="{{ route('highlight.index') }}" class="btn btn-secondary w-48 text-center">ย้อนกลับ</a>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    @section('javascript')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tagInput = document.getElementById('name');
                const form = document.getElementById('tag-form');
                const errorMessage = document.getElementById('name-error');

                function validateTagName() {
                    const tagName = tagInput.value;
                    if (/\s/.test(tagName)) { // เช็คว่ามี space หรือไม่
                        errorMessage.style.display = 'block'; // แสดงข้อความแจ้งเตือน
                        tagInput.classList.add('is-invalid'); // เพิ่ม border สีแดง
                        return false;
                    } else {
                        errorMessage.style.display = 'none'; // ซ่อนข้อความแจ้งเตือน
                        tagInput.classList.remove('is-invalid'); // เอา border สีแดงออก
                        return true;
                    }
                }

                // ตรวจสอบเมื่อพิมพ์
                tagInput.addEventListener('input', validateTagName);

                // ตรวจสอบเมื่อ submit ฟอร์ม
                form.addEventListener('submit', function (event) {
                    if (!validateTagName()) {
                        event.preventDefault(); // ยกเลิกการ submit ถ้ามี space
                    }
                });
            });
        </script>
    @endsection

</body>

</html>