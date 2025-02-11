<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Highlight Paper</title>

    <!-- Bootstrap CSS -->
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

        h2 {
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
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

        .btn-secondary {
            background-color: #757575;
            color: white;
            border: none;
            transition: 0.3s;
        }
        .btn-secondary:hover {
            background-color: #616161;
        }

        .alert-danger {
            background-color: #F44336;
            color: white;
        }
    </style>
</head>
<body>

    @extends('dashboards.users.layouts.user-dash-layout')

    @section('content')
    <div class="container p-5 mt-5">
        <h2>สร้างงานวิจัยยอดนิยม</h2>
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form id="createForm" action="{{ route('highlight.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">ชื่อ</label> <label class="text-danger">*</label>
                <input type="text" name="title" class="form-control" required>
            </div>
    
            <div class="mb-3">
                <label class="form-label">รายละเอียด</label>
                {{-- <textarea name="description" class="form-control"></textarea> --}}
                <input type="text" name="description" class="form-control">
            </div>
    
            <div class="mb-3">
                <label class="form-label">รูปภาพ</label> <label class="text-danger">*</label>
                <input type="file" name="picture" class="form-control" accept="image/*" required>
            </div>
    
            <div class="mb-3">
                <label class="form-label">เลือกนักวิจัย</label> <label class="text-danger">*</label>
                <select id="researcherSelect" class="form-select" required>
                    <option value="">-- เลือกนักวิจัย --</option>
                    @foreach($researchers as $researcher)
                        <option value="{{ $researcher->id }}">{{ $researcher->fname_th }} {{ $researcher->lname_th }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">เลือกงานวิจัย</label> <label class="text-danger">*</label>
                <select name="paper_id" id="paperSelect" class="form-select" required>
                    <option value="">-- เลือกงานวิจัย --</option>
                    @foreach($allPapers as $paper)
                        <option value="{{ $paper->id }}">{{ $paper->paper_name }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="mb-3">
                {{-- <input type="checkbox" name="isSelected" class="form-check-input" value="1" required> 
                <label class="form-check-label">เลือกให้แสดง</label> <label class="text-danger">*</label> --}}
                <label for="form-label">การแสดงผล</label> <label class="text-danger">*</label>
                <select name="isSelected" id="isSelected" class="form-select">
                    <option value="1">เลือกให้แสดง</option>
                    <option value="0" selected>ไม่เลือกให้แสดง</option>
                </select>

            </div>
    
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmCreateModal">
                สร้างไฮไลท์
            </button>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#confirmCancelModal">
                ยกเลิก
            </button>
        </form>
    </div>
    
    <!-- Modal for Create Confirmation -->
    <div class="modal fade" id="confirmCreateModal" tabindex="-1" aria-labelledby="confirmCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCreateModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ท่านต้องการสร้าง Highlight Paper นี้หรือไม่?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="confirmCreateBtn">สร้าง</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal for Cancel Confirmation -->
    <div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCancelModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ท่านแน่ใจหรือไม่ว่าต้องการยกเลิก?
                </div>
                <div class="modal-footer">
                    <a href="{{ route('highlight.index') }}" class="btn btn-danger">ใช่</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('confirmCreateBtn').addEventListener('click', function() {
            document.getElementById('createForm').submit();
        });
    
        document.addEventListener("DOMContentLoaded", function() {
            let researcherSelect = document.getElementById("researcherSelect");
            let paperSelect = document.getElementById("paperSelect");
    
            let papersByResearcher = @json($papersByResearcher);
            let allPapers = @json($allPapers);
    
            researcherSelect.addEventListener("change", function() {
                let researcherId = this.value;
                paperSelect.innerHTML = '<option value="">-- เลือกงานวิจัย --</option>'; // เคลียร์ค่าเก่า
    
                let papers = researcherId && papersByResearcher[researcherId] 
                    ? papersByResearcher[researcherId] // ✅ ถ้ามี researcher ให้ใช้เฉพาะงานวิจัยของ researcher นั้น
                    : allPapers; // ✅ ถ้าไม่ได้เลือก researcher ให้แสดงงานวิจัยทั้งหมด
    
                papers.forEach(paper => {
                    let option = document.createElement("option");
                    option.value = paper.id;
                    option.textContent = paper.paper_name;
                    paperSelect.appendChild(option);
                });
            });
        });
    </script>
    
    @endsection
    

</body>


</html>
