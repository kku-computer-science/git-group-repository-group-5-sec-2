@extends('layouts.layout')

@section('content')
<style>
        .highlight-item {
            position: relative;
            overflow: hidden;
        }
        .hover-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            text-align: center;
            padding: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .highlight-item:hover .hover-title {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-5">
        <h1 class="text-3xl font-bold text-center mb-6">Highlights</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($highlights as $highlight)
                <div class="highlight-item">
                    <img src="{{ asset('images/'.$highlight->cover_image) }}" alt="{{ $highlight->title }}" class="w-full h-64 object-cover rounded-lg shadow-lg">
                    <div class="hover-title">{{ $highlight->title }}</div>
                </div>
            @endforeach
        </div>
    </div>
</body>
@endsection


