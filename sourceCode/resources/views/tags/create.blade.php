<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Tags</title>

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

        /* สไตล์ข้อความแจ้งเตือน */
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 5px;
            display: none; /* ซ่อนเริ่มต้น */
        }
    </style>
</head>

<body>

    @extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container mt-5">
    <h2>สร้าง Tag ใหม่</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form id="tag-form" action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tag Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            <div id="name-error" class="error-message">❌ ห้ามมีช่องว่างใน Tag Name</div>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">สร้าง</button>
        <a href="{{ route('highlight.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
    </form>
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
