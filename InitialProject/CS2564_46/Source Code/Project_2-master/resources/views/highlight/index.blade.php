<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Highlight</title>

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

        .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .status-label {
        margin-left: 70px;
        line-height: 34px;
    }        

    /* กำหนดความกว้างของแต่ละคอลัมน์ */
.table th:nth-child(1), /* ID column */
.table td:nth-child(1) {
    width: 5%;
}

.table th:nth-child(2), /* Title column */
.table td:nth-child(2) {
    width: 40%;
}

.table th:nth-child(3), /* Creator column */
.table td:nth-child(3) {
    width: 20%;
}

.table th:nth-child(4), /* Active column */
.table td:nth-child(4) {
    width: 15%;
}

.table th:nth-child(5), /* Actions column */
.table td:nth-child(5) {
    width: 20%;
}
.table td:nth-child(2) {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 0; /* จำเป็นสำหรับ text-overflow ใน table */
}
    </style>
</head>

<body>

    @extends('dashboards.users.layouts.user-dash-layout')

    @section('content')
    <div class="container mt-5">
        <h2>รายการ Highlights</h2>

        {{-- Highlight Lists --}}
        <a href="{{ route('highlight.create') }}" class="btn btn-primary mb-3">+ สร้าง Highlight ใหม่</a>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Creator</th>
                    <th>Active</th> <!-- ✅ ใช้ Toggle Switch -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($highlights as $highlight)
                <tr>
                    <td>{{ $highlight->id }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $highlight->title }}</td>
                    <td>{{ $highlight->creator }}</td>
        
                    <!-- ✅ ใช้ Toggle Switch สำหรับ Active -->
                    <td class="text-center">
                        <form action="{{ route('highlight.toggleActive', $highlight->id) }}" method="POST" class="toggle-form">
                            @csrf
                            <input type="hidden" name="active" value="{{ $highlight->active }}">
                            <label class="toggle-switch">
                                <input type="checkbox" class="toggle-active"
                                       data-id="{{ $highlight->id }}"
                                       {{ $highlight->active ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </form>
                    </td>
                    
                    
        
                    <td>
                        <a href="{{ route('highlight.edit', $highlight->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('highlight.destroy', $highlight->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบ Highlight นี้?');">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $highlights->links() }} 
        </div>

        {{-- Tags Lists --}}
        <div class="mt-4">
            <h4>Tags ทั้งหมด</h4>
        
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tag Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->name }}</td>
                        <td>
                            <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบแท็กนี้?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $tags->links() }} 
            </div>
        </div>
        
    </div>
    @endsection

    @section('javascript')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            console.log("✅ JavaScript Loaded");
            
            document.querySelectorAll(".toggle-active").forEach(function (toggle) {
                toggle.addEventListener("change", function (event) {
                    let form = this.closest(".toggle-form"); // หา `<form>` ที่ใกล้ที่สุด
                    let input = form.querySelector("input[name='active']");
                    let activeCount = document.querySelectorAll(".toggle-active:checked").length; // นับจำนวน Active

                    // ✅ เช็คว่ามี Active เกิน 5 อันหรือไม่
                    if (activeCount > 5 && this.checked) {
                        alert("❌ ไม่สามารถเปิด Active เกิน 5 รายการได้!"); // แสดง Alert แจ้งเตือน
                        event.preventDefault(); // ป้องกันการเปลี่ยนค่า
                        this.checked = false;  // ปิด Toggle กลับไป
                        return;
                    }

                    // ✅ อัปเดตค่า hidden input ก่อน submit form
                    input.value = this.checked ? 1 : 0;
                    form.submit();
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endsection


    
</body>

</html>