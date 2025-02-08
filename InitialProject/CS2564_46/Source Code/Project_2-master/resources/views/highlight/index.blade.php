<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Highlight Papers</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1 class="mb-4">Highlight Papers</h1>
        <a class="btn btn-primary" href="{{ route('highlight.create')}}">สร้าง highlight</a>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Picture</th>
                    <th>Paper_Name</th>
                    <th>isSelected</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($highlight_papers as $highlightPapers)
                    <tr>
                        <td>{{ $highlightPapers->id }}</td>
                        <td>{{ $highlightPapers->title }}</td>
                        <td>{{ $highlightPapers->description }}</td>
                        <td><img src="{{ asset($highlightPapers->picture) }}" alt="Highlight Image" width="100"></td>
                        <td>{{ $highlightPapers->paper->paper_name }}</td>
                        <td>
                            @if($highlightPapers->isSelected)
                                <span class="text-success fw-bold">เลือกแล้ว</span>
                            @else
                                <span class="text-danger fw-bold">ไม่ได้เลือก</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('highlight.destroy', $highlightPapers->id) }}" method="POST">
                                <a href="{{ route('highlight.edit', $highlightPapers->id) }}" class="btn btn-warning">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {!! $highlight_papers->links() !!}
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
