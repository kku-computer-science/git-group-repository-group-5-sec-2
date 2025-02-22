@extends('layouts.layout')
@section('content')
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">{{ $highlight->title }}</h1>
            </div>
            <div class="card-body">
                <p>{!! $highlight->content !!}</p>
            </div>
        </div>
    </div>
</body>
@endsection