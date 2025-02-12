<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Highlight Papers</title>

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

        h1 {
            color: #111;
            text-transform: uppercase;
            font-weight: bold;
        }

        .btn-primary {
            background: linear-gradient(45deg, #03A9F4, #0277BD);
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0288D1, #01579B);
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background-color: #03A9F4 !important;
            color: white;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table tbody tr:nth-child(even) {
            background-color: #e0e0e0;
        }

        .table tbody tr:hover {
            background-color: #c0c0c0;
            transition: background-color 0.3s ease;
        }

        .table td,
        .table th {
            text-align: center;
            vertical-align: middle;
            max-width: 200px;
            /* กำหนดค่าความกว้างสูงสุดของแต่ละคอลัมน์ */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table td:nth-child(2),
        /* คอลัมน์ "ชื่อ" */
        .table td:nth-child(3),
        /* คอลัมน์ "รายละเอียด" */
        .table td:nth-child(4) {
            /* คอลัมน์ "งานวิจัย" */
            max-width: 250px;
            /* กำหนดความกว้างสูงสุดที่ต่างกันตามต้องการ */
        }


        .btn-warning,
        .btn-danger {
            margin: 0 5px;
        }

        .badge-success {
            background-color: #4CAF50;
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
        }

        .badge-danger {
            background-color: #F44336;
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
        }

        .pagination .page-link {
            color: #03A9F4;
        }

        .pagination .page-item.active .page-link {
            background-color: #03A9F4;
            border-color: #03A9F4;
        }
    </style>
</head>

<body>

    @extends('dashboards.users.layouts.user-dash-layout')

    @section('content')
    <div class="container mt-5">
        <h2 class="text-center">รายชื่อรายงานวิจัยยอดนิยม</h2>

        <div class="d-flex justify-content-between align-items-center">
            <a class="fw-bold btn btn-primary" href="{{ route('highlight.create') }}">สร้างงานวิจัยที่ยอดนิยม +</a>

            <form method="GET" class="d-inline">
                <div class="dropdown">
                    สถานะ
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ request()->filter == 'selected' ? 'เลือกแล้ว' : (request()->filter == 'not-selected' ? 'ไม่ได้เลือก' : 'กรองข้อมูล') }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><button type="submit" name="filter" value="" class="dropdown-item">ทั้งหมด</button></li>
                        <li><button type="submit" name="filter" value="selected" class="dropdown-item">เลือกแล้ว</button></li>
                        <li><button type="submit" name="filter" value="not-selected" class="dropdown-item">ไม่ได้เลือก</button></li>
                    </ul>
                </div>
            </form>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-light">ID</th>
                        <th class="text-light">ชื่อ</th>
                        <th class="text-light">รายละเอียด</th>
                        <!-- <th>รูปภาพ</th> -->
                        <th class="text-light">งานวิจัย</th>
                        <th class="text-light">แสดงผล</th>
                        <th class="text-light">ปรับแต่ง</th>
                    </tr>
                </thead>
                <tbody id="">
                    @foreach($highlight_papers as $highlightPapers)
                    <tr class="highlight-item">
                        <td>{{ $highlightPapers->id }}</td>
                        <td>
                            <span title="{{ $highlightPapers->title }}">{{ $highlightPapers->title }}</span>
                        </td>
                        <td>
                            <span title="{{ $highlightPapers->description }}">{{ $highlightPapers->description }}</span>
                        </td>
                        <!-- <td>
                                <img src="{{ asset($highlightPapers->picture) }}" alt="Highlight Image" width="80" class="rounded">
                            </td> -->
                        <td>
                            <span title="{{ $highlightPapers->paper->paper_name }}">{{ $highlightPapers->paper->paper_name }}</span>
                        </td>
                        <td>
                            @if($highlightPapers->isSelected)
                            <span class="badge-success text-light">เลือกแล้ว</span>
                            @else
                            <span class="badge-danger text-light">ไม่ได้เลือก</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('highlight.edit', $highlightPapers->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $highlightPapers->id }}">
                                ลบ
                            </button>

                            <!-- Modal for each item -->
                            <div class="modal fade" id="deleteModal-{{ $highlightPapers->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Are you sure?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            คุณต้องการลบ Highlight นี้ใช่หรือไม่?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <form method="POST" action="{{ route('highlight.destroy', $highlightPapers->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="filter" value="{{ request()->filter }}">
                                                <button type="submit" class="btn btn-danger">ลบ</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex mt-3 justify-content-end">
                {!! $highlight_papers->appends(request()->query())->links() !!}
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endsection

</body>

</html>