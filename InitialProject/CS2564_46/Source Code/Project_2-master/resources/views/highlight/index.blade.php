<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Highlight Papers</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #fff;
            font-family: 'Poppins', sans-serif;
        }
        
        .container {
            background-color:#fff;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            padding: 25px;
        }

        h1 {
            color: #03A9F4;
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
            transform: scale(1.05);
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

        .table td, .table th {
            text-align: center;
            vertical-align: middle;
        }

        .btn-warning, .btn-danger {
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

    <div class="container mt-5">
        <h1 class="text-center">Highlight Papers</h1>
        
        <div class="d-flex justify-content-between align-items-center">
            <a class="fw-bold btn btn-primary" href="{{ route('highlight.create') }}">+ Create Highlight</a>
            
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    กรองข้อมูล
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item filter-option" data-filter="all" href="#">ทั้งหมด</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="selected" href="#">เลือกแล้ว</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="not-selected" href="#">ไม่ได้เลือก</a></li>
                </ul>
            </div>
        </div>


        <div class="table-responsive mt-4">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อ</th>
                        <th>รายละเอียด</th>
                        <th>รูปภาพ</th>
                        <th>งานวิจัย</th>
                        <th>แสดงผล</th>
                        <th>ปรับแต่ง</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($highlight_papers as $highlightPapers)
                        <tr>
                            <td>{{ $highlightPapers->id }}</td>
                            <td>{{ $highlightPapers->title }}</td>
                            <td>{{ $highlightPapers->description }}</td>
                            <td>
                                <img src="{{ asset($highlightPapers->picture) }}" alt="Highlight Image" width="80" class="rounded">
                            </td>
                            <td>{{ $highlightPapers->paper->paper_name }}</td>
                            <td>
                                @if($highlightPapers->isSelected)
                                    <span class="badge-success">เลือกแล้ว</span>
                                @else
                                    <span class="badge-danger">ไม่ได้เลือก</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('highlight.edit', $highlightPapers->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('highlight.destroy', $highlightPapers->id) }}')">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
            const filterOptions = document.querySelectorAll(".filter-option");

            filterOptions.forEach(option => {
                option.addEventListener("click", function (event) {
                    event.preventDefault();
                    const filterValue = this.getAttribute("data-filter");

                    document.querySelectorAll(".table tbody tr").forEach(row => {
                        const isSelected = row.querySelector(".badge-success") !== null;
                        
                        if (filterValue === "all") {
                            row.style.display = "";
                        } else if (filterValue === "selected" && !isSelected) {
                            row.style.display = "none";
                        } else if (filterValue === "not-selected" && isSelected) {
                            row.style.display = "none";
                        } else {
                            row.style.display = "";
                        }
                    });
                });
            });
        });
    </script>

</body>
</html>
