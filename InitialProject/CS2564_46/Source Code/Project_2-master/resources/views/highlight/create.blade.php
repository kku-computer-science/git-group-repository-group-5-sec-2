<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create Highlight</title>

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


        .form-check {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 20px;
            padding: 6px 12px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-check:hover {
            background: #e9ecef;
        }

        .form-check-input {
            display: none;
            /* ซ่อน Checkbox ปกติ */
        }

        .form-check label {
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ✅ สร้างสไตล์ให้ Checkbox */
        .form-check label::before {
            content: "";
            width: 20px;
            height: 20px;
            border: 2px solid #ccc;
            border-radius: 50%;
            display: inline-block;
            transition: all 0.3s ease;
            margin-left: 8px;
            flex-shrink: 0;
        }

        /* ✅ สร้างเอฟเฟกต์เมื่อ Checkbox ถูกเลือก */
        .form-check-input:checked+label::before {
            background: blue;
            border-color: blue;
            content: "✔";
            color: white;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* tag v.2 */
        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
        }
        .selected-items {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 10px;
            padding-bottom: 10px;
        }
        .selected-item {
            background-color: #e9ecef;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .selected-item span {
            cursor: pointer;
        }

    </style>
</head>

<body>

    @extends('dashboards.users.layouts.user-dash-layout')

    @section('content')
        <div class="container mt-5">
            <h2 class="mb-4">สร้าง Highlight ใหม่</h2>

            <form action="{{ route('highlight.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                        required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Detail -->
                <div class="mb-3">
                    <label for="detail" class="form-label">Detail</label>
                    <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" rows="8"
                        style="height: 200px; resize: vertical;" required></textarea>
                    @error('detail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Cover Image Upload -->
                <div class="mb-3">
                    <label for="cover_image" class="form-label">อัปโหลดภาพปก (ขนาดแนะนำ 1600 x 900)</label>
                    <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image"
                        name="cover_image" accept="image/*" required>
                    <img id="coverPreview" src="#" alt="Cover Preview" class="img-fluid mt-2 d-none"
                        style="max-width: 200px;">
                    @error('cover_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Multiple Images Upload -->
                <div class="mb-3">
                    <label for="images" class="form-label">อัปโหลดอัลบั้มภาพ</label>
                    <input type="file" class="form-control @error('images') is-invalid @enderror" id="images"
                        name="images[]" accept="image/*" multiple>
                    <div id="imagePreviewContainer" class="mt-2"></div>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Select Tags -->
                <div class="mb-3">
                    <label class="form-label">เลือก Tags</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($tags as $tag)
                            <div class="col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}">
                                    <label for="tag{{ $tag->id }}">{{ $tag->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('tags')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror 

                    <!-- ✅ ปุ่มสำหรับไปที่หน้าเพิ่ม Tag -->
                    <a href="{{ route('tags.create') }}" class="btn btn-primary mt-2">+ สร้าง Tag ใหม่</a>
                </div>

                <!-- แก้  tag v.2-->

                <!-- <div class="mb-3">
                    <label class="form-label">เลือกหัวข้อที่เกี่ยวข้อง</label>
                    
                    <div class="dropdown">
                        <input 
                            type="text" 
                            class="form-control" 
                            placeholder="Search and select..." 
                            id="dropdownInput" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">

                        <ul class="dropdown-menu w-100" id="dropdownContent">
                            @foreach ($tags as $tag)
                                <li>
                                    <label class="dropdown-item" for="tag{{ $tag->id }}">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="tags[]" 
                                            value="{{ $tag->id }}" 
                                            id="tag{{ $tag->id }}">
                                        <span>{{ $tag->name }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div> -->

                    <!-- Show selected items -->
                    <!-- <div class="selected-items" id="selectedItems"></div>
                </div> -->



                <button type="submit" class="btn btn-primary">สร้าง Highlight</button>
                <a href="{{ route('highlight.index') }}" class="btn btn-secondary">ยกเลิก</a>
            </form>
        </div>
    @endsection

    @section('scripts')
        <script>
            document.getElementById('cover_image').addEventListener('change', function (event) {
                let coverPreview = document.getElementById('coverPreview');
                if (event.target.files.length > 0) {
                    let file = event.target.files[0];
                    coverPreview.src = URL.createObjectURL(file);
                    coverPreview.classList.remove('d-none');
                }
            });

            // แสดงรูปตัวอย่างหลายรูป
            document.getElementById('images').addEventListener('change', function (event) {
                let previewContainer = document.getElementById('imagePreviewContainer');
                previewContainer.innerHTML = ''; // เคลียร์รูปเก่าออกก่อน

                if (event.target.files.length > 0) {
                    Array.from(event.target.files).forEach(file => {
                        let img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.classList.add('img-thumbnail', 'm-1');
                        img.style.maxWidth = '100px';
                        previewContainer.appendChild(img);
                    });
                }
            });


            // tag v.2
            // const dropdownInput = document.getElementById('dropdownInput');
            // const dropdownContent = document.getElementById('dropdownContent');
            // const selectedItemsContainer = document.getElementById('selectedItems');

            // Filter options based on input
            // dropdownInput.addEventListener('input', (e) => {
            // const filter = e.target.value.toLowerCase();
            // const labels = dropdownContent.querySelectorAll('label');
            // labels.forEach((label) => {
            //     const text = label.textContent.toLowerCase();
            //     if (text.includes(filter)) {
            //     label.parentElement.style.display = 'block';
            //     } else {
            //     label.parentElement.style.display = 'none';
            //     }
            // });
            // });

            // Handle checkbox selection
            // dropdownContent.addEventListener('change', (e) => {
            //     const checkbox = e.target;
            //     const tagName = checkbox.closest('label').querySelector('span').textContent; // Get the tag name from <span>
            //     const value = checkbox.value;

            //     if (checkbox.checked) {
            //         // Add the selected tag to the container
            //         const item = document.createElement('div');
            //         item.className = 'selected-item';
            //         item.textContent = tagName; // Use the tag name here
            //         const removeButton = document.createElement('span');
            //         removeButton.textContent = '✕';
            //         removeButton.style.cursor = 'pointer';
            //         removeButton.addEventListener('click', () => {
            //             checkbox.checked = false; // Uncheck the corresponding checkbox
            //             selectedItemsContainer.removeChild(item); // Remove the item from selected list
            //         });
            //         item.appendChild(removeButton);
            //         selectedItemsContainer.appendChild(item);
            //     } else {
            //         // Remove the tag from the container when unchecked
            //         const items = selectedItemsContainer.querySelectorAll('.selected-item');
            //         items.forEach((item) => {
            //             if (item.textContent.includes(tagName)) {
            //                 selectedItemsContainer.removeChild(item);
            //             }
            //         });
            //     }
            // });
            // Close dropdown when clicking outside
            // document.addEventListener('click', (e) => {
            // const dropdown = document.querySelector('.dropdown');
            // if (!dropdown.contains(e.target)) {
            //     dropdown.querySelector('.dropdown-menu').classList.remove('show');
            // }
            // });


            
        </script>
    @endsection
</body>

</html>