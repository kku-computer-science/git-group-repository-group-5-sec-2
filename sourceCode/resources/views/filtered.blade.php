@extends('layouts.layout')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100..900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Kanit', sans-serif;
    }

    /* ทำให้ลิงก์คลิกได้ทั่วทั้งรายการ */
    .highlight-item {
        display: block;
        text-decoration: none !important; /* ไม่มีขีดเส้นใต้ */
        color: inherit; /* คงสีเดิมของข้อความ */
    }

    /* การ์ดสไตล์ */
    .highlight-item .card {
        transition: background-color 0.3s ease, transform 0.2s ease;
        border-radius: 8px;
        overflow: hidden;
    }

    /* รูปภาพ */
    .highlight-item img {
        width: 250px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* เอฟเฟกต์ hover */
    .highlight-item:hover .card {
        background-color: #f0f0f0; /* เปลี่ยนเป็นสีเทา */
        transform: scale(1.02); /* ขยายขึ้นเล็กน้อย */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* เพิ่มเงา */
    }

    /* ป้องกันขีดเส้นใต้ใน <h5> และ <p> */
    .highlight-item h5,
    .highlight-item p {
        text-decoration: none !important;
    }

</style>


<div class="container py-5">
    <h1 class="fw-bold mb-4 text-primary">
        ผลการค้นหาสำหรับ: <span class="text-secondary">{{ $tagName }}</span>
    </h1>
    <p class="text-muted">พบทั้งหมด {{ $highlights->count() }} รายการ</p>

    @if ($highlights->isEmpty())
        <p class="text-danger">ไม่พบรายการที่ตรงกับคำค้นหานี้</p>
    @endif

    <div class="row g-4">
        @foreach($highlights as $highlight)
            <div class="col-12">
                <a href="{{ route('highlight.detail', ['id' => $highlight->id]) }}" class="highlight-item">
                    <div class="card border-0 shadow-sm d-flex flex-row p-2 align-items-center">
                        {{-- รูปภาพ --}}
                        <img src="{{ asset($highlight->cover_image) }}" class="img-fluid rounded-start">
                        
                        <div class="card-body">
                            {{-- ชื่อหัวข้อข่าว --}}
                            <h5 class="fw-bold text-primary">
                                {{ $highlight->title }}
                            </h5>

                            {{-- รายละเอียด --}}
                            <p class="text-muted mb-2">
                                {{ Str::limit($highlight->detail, 250) }}
                            </p>

                            {{-- วันที่สร้าง --}}
                            <div class="text-muted">
                                สร้างเมื่อ {{ \Carbon\Carbon::parse($highlight->updated_at)->format('d/m/Y') }}
                            </div>

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

@endsection
