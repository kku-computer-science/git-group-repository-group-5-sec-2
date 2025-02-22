<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

        
    </style>
</head>

<body>

    @extends('dashboards.users.layouts.user-dash-layout')

    @section('content')
    <div class="container mt-5">
        <h2>รายการ Highlight Papers</h2>

        {{-- Highlight Lists --}}
        <a href="{{ route('highlight.create') }}" class="btn btn-primary mb-3">+ สร้าง Highlight ใหม่</a>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cover Image</th>
                    <th>Title</th>
                    <th>Creator</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($highlights as $highlight)
                <tr>
                    <td>{{ $highlight->id }}</td>
                    <td>
                        <img src="{{ asset($highlight->cover_image) }}" alt="Cover Image" class="img-thumbnail" style="max-width: 100px;">
                    </td>
                    <td>{{ $highlight->title }}</td>
                    <td>{{ $highlight->creator }}</td>
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

        {{-- Tags Lists --}}
        <div class="mt-4">
            <h4>Tags ทั้งหมด</h4>
            
            <!-- ✅ ปุ่มสำหรับไปที่หน้าเพิ่ม Tag -->
            <a href="{{ route('tags.create') }}" class="btn btn-success mb-3">+ สร้าง Tag ใหม่</a>
        
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
        </div>
        
    </div>
    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endsection

</body>

</html>