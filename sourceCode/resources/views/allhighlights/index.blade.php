@extends('layouts.layout')

@section('content')
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }

        .highlight-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            /* height: 300px; */
            /* กำหนดขนาดการ์ด */
            display: flex;
            flex-direction: column;
            /* จัดแนวรูปภาพและ title ให้เป็นแนวตั้ง */
        }

        .highlight-item img {
            width: 100%;
            height: auto; /* ปล่อยให้สูงตามสัดส่วนจริงของรูป */
            /* height: 100%; */
            /* ทำให้รูปภาพเต็มขนาดของการ์ด */
            object-fit: cover;
            /* ทำให้รูปภาพเติมเต็มกรอบโดยไม่บิดเบี้ยว */
        }

        .hover-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            /* สีดำโปร่งแสง */
            color: white;
            text-align: center;
            padding: 15px;
            opacity: 0;
            /* ซ่อน title */
            transform: translateY(100%);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            font-family: 'Noto Sans Thai', sans-serif;
        }

        /* แสดง title เมื่อเมาส์ไปชี้ที่การ์ด */
        .highlight-item:hover .hover-title {
            opacity: 1;
            transform: translateY(0);
        }

        /* ปรับปุ่ม Tags */
        .btn-outline-primary{
            padding: 3px 6px;
            translate: 0px -4px;
        }

    </style>

<body>
    <div class="container py-5">
        {{-- Debug เช็คค่า cover_image --}}
        {{-- @foreach($highlights as $highlight)
        <p>{{ $highlight->cover_image }}</p>
        @endforeach --}}

        <h1 class="text-center fw-bold mb-4">{{trans('message.Highlights')}}</h1>
        <div class="d-flex gap-2 ml-5">
            {{trans('message.tags')}} : 
            @foreach($tags as $tag)
                <a href="highlights/tag/{{$tag->name}}" class="btn btn-outline-primary mb-5">{{ $tag->name }}</a>
            @endforeach
        </div>
        
        <div class="row g-4">
            @foreach($highlights as $highlight)
                <div class="col-lg-4 col-md-6 col-12">
                    <a href="{{ route('highlight.detail', ['id' => $highlight->id]) }}" class="text-decoration-none">
                        <div class="highlight-item">
                            <img src="{{ asset($highlight->cover_image) }}" class="img-fluid rounded">
                            <div class="hover-title">{{ $highlight->title }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</body>
@endsection
