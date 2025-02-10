<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Highlight Paper</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        
        body {
            background-color: #fff;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            background-color: #fff; /* ดำเทา */
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            padding: 25px;
        }

        h1 {
            color: #03A9F4; /* ฟ้า */
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }

        /* Custom Buttons */
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

        /* Form Styling */
        .form-label {
            color:rgb(0, 0, 0);
        }

        .form-control {
            background-color:rgb(241, 241, 241);
            border: 1px solid #444;
            color:rgb(0, 0, 0);
        }

        .form-control:focus {
            border-color: #03A9F4;
            box-shadow: 0 0 5px rgba(3, 169, 244, 0.5);
        }

        .form-check-input {
            background-color: #03A9F4;
            border-color: #03A9F4;
        }

        .form-check-label {
            color:rgb(0, 0, 0);
        }

        .alert-danger {
            background-color: #F44336;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1>Edit Highlight Paper</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="editForm" action="{{ route('highlight.update', $highlight_paper->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="form-label">ชื่อ</label>
                <input type="text" name="title" class="form-control" value="{{ $highlight_paper->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">รายละเอียด</label>
                <textarea name="description" class="form-control">{{ $highlight_paper->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">รูปปัจจุบัน</label><br>
                @if($highlight_paper->picture)
                    <img src="{{ asset($highlight_paper->picture) }}" alt="Current Image" width="150" class="mb-2">
                @else
                    <p>No Image Available</p>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">อัปโหลดรูปใหม่</label>
                <input type="file" name="picture" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">เลือกงานวิจัย</label>
                <select name="paper_id" class="form-select" required>
                    <option value="">-- เลือกงานวิจัย --</option>
                    @foreach($papers as $paper)
                        <option value="{{ $paper->id }}" {{ $highlight_paper->paper_id == $paper->id ? 'selected' : '' }}>
                            {{ $paper->paper_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="isSelected" class="form-check-input" value="1" {{ $highlight_paper->isSelected ? 'checked' : '' }}>
                <label class="form-check-label">เลือกให้แสดง</label>
            </div>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmEditModal">
                อัปเดตข้อมูล
            </button>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#confirmCancelModal">
                ยกเลิก
            </button>
        </form>
    </div>

    <!-- Modal for Edit Confirmation -->
    <div class="modal fade" id="confirmEditModal" tabindex="-1" aria-labelledby="confirmEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmEditModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ท่านต้องกาที่จะอัปเดต Highlight Paper นี้หรือไม่?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="confirmEditBtn">ยืนยัน</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('confirmEditBtn').addEventListener('click', function() {
            document.getElementById('editForm').submit();
        });
    </script>

</body>

</html>
