<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>edit Highlight</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #fff;
            font-family: 'Noto Sans Thai', sans-serif !important;
        }

        .container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            padding: 25px;
        }

        .badge {
            font-weight: normal;
        }

        /* Tag styles */
        #tags-container .badge {
            transition: all 0.3s ease;
        }

        #tags-container .badge:hover {
            background-color: #0056b3 !important;
        }

        #tag-suggestions {
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #tag-suggestions .list-group-item.active {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>

<body>

    @extends('dashboards.users.layouts.user-dash-layout')

    @section('content')
        <div class="container mt-5">
            <h2 class="mb-4">แก้ไขไฮไลท์</h2>

            <form action="{{ route('highlight.update', $highlight->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label"><span style="color: red;">*</span> ชื่อ</label>
                    <input type="text" class="form-control" name="title" value="{{ $highlight->title }}" required>
                    @error('title')
                        <div class="invalid-feedback" style="color: red;">กรุณากรอกชื่อให้ครบถ้วน</div>
                    @enderror
                </div>

                <!-- Detail -->
                <div class="mb-3">
                    <label class="form-label"><span style="color: red;">*</span> รายละเอียด</label>
                    <textarea class="form-control" name="detail" rows="8" style="height: 200px; resize: vertical;"
                        required>{{ $highlight->detail }}</textarea>
                    @error('title')
                        <div class="invalid-feedback" style="color: red;">กรุณากรอกชื่อให้ครบถ้วน</div>
                    @enderror
                </div>
                
                <!-- Cover Image Upload -->
                <div class="my-3">
                    <!-- Current Cover Image Preview -->
                    <label for="cover_image" class="form-label">
                        ภาพปกปัจจุบัน
                    </label>
                    <img id="coverPreview" src="{{ asset($highlight->cover_image) }}" alt="Cover Preview"
                        class="w-128 h-64 mt-2">

                    <label for="cover_image" class="form-label" style="margin-top: 15px">
                        <span class="text-red-500">*</span> อัปโหลดภาพปก
                    </label>

                    <!-- Image Upload Box -->
                    <div class="relative border-dashed border-2 border-gray-400 rounded-lg p-8 text-center cursor-pointer hover:border-blue-500 transition-all"
                        id="uploadBox">
                        <input type="file" id="cover_image" name="cover_image" accept="image/*"
                            class="absolute inset-0 opacity-0 cursor-pointer">

                        <!-- Upload Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-black-400 mx-auto mb-2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>

                        <!-- Instruction Text -->
                        <p class="text-grey-600"><span class="text-black-500 font-bold">คลิกเพื่ออัปโหลดรูป</span> .png, .jpeg, .svg, .avif, .webp (ขนาดแนะนำ 1600 x 900)</p>
                    </div>
                </div>
                
                <!-- Multiple Images Upload -->
                <div class="my-3">
                    <!-- Existing Images Preview -->
                    <label for="cover_image" class="form-label" style="margin-top: 5px;">อัลบั้มภาพปัจจุบัน</label>
                    <div class="d-flex flex-wrap mt-2">
                        @foreach ($highlight->images as $image)
                            <div id="image-{{ $image->id }}" class="position-relative m-2">
                                <img src="{{ asset($image->image_path) }}" class="img-thumbnail" style="max-width: 100px;">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                    onclick="deleteImage({{ $image->id }})">×</button>
                            </div>
                        @endforeach
                    </div>
                    <!-- New Images Preview Container -->
                    <div id="imagePreviewContainer" class="mt-2 hidden flex"></div>
                    <label for="images" class="form-label" style="margin-top: 10px">อัปโหลดอัลบั้มภาพ</label>
                    
                    <!-- Image Upload Box -->
                    <div class="relative border-dashed border-2 border-gray-400 rounded-lg p-8 text-center cursor-pointer hover:border-blue-500 transition-all"
                        id="uploadBoxMultiple">
                        <input type="file" class="absolute inset-0 opacity-0 cursor-pointer" id="images" name="images[]"
                            accept="image/*" multiple>
                        
                            <!-- Upload Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-black-400 mx-auto mb-2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        
                        <!-- Instruction Text -->
                        <p class="text-grey-600"><span class="text-black-500 font-bold">คลิกเพื่ออัปโหลดรูป</span> .png, .jpeg, .svg, .avif, .webp (อัปโหลดได้หลายรูป)</p>
                    </div>
                </div>
                
                <!-- Tags Input -->
                <div class="mb-3">
                    <label for="tag-input" class="form-label">เพิ่มแท็ก</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" style="height:100%" id="tag-input"
                            placeholder="พิมพ์แท็ก แล้วกด Enter เพื่อเพิ่ม" autocomplete="off">
                        <button class="btn btn-outline-secondary" type="button" id="add-tag-btn">เพิ่ม</button>
                    </div>
                    <div id="tag-suggestions" class="list-group position-absolute d-none"
                        style="z-index: 1000; width: 95%;"></div>
                    <div id="tags-container" class="d-flex flex-wrap gap-2 mb-2">
                        <!-- Tags ที่มีอยู่แล้วจะถูกเพิ่มที่นี่ -->
                    </div>
                    <input type="hidden" name="tags_json" id="tags-input">
                </div>

                <!-- Active Status -->
                <div class="mb-3">
                    <!-- <label for="active" class="form-label">สถานะการแสดงผล</label> -->
                    <select class="form-select" id="active" name="active" hidden aria-label="เลือกสถานะการแสดงผล">
                        <option value="1" {{ $highlight->active == 1 ? 'selected' : '' }}>✅ แสดงผล</option>
                        <option value="0" {{ $highlight->active == 0 ? 'selected' : '' }}>❌ ไม่แสดงผล</option>
                    </select>
                </div>

                <!-- ปุ่มอัปเดต และ ย้อนกลับ -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">อัปเดต</button>
                    <a href="{{ route('highlight.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
                </div>
            </form>
        </div>
    @endsection

    @section('javascript')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            //coverimage 
            document.getElementById('cover_image').addEventListener('change', function (event) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('coverPreview').src = e.target.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            });

            document.getElementById('images').addEventListener('change', function (event) {
                const previewContainer = document.getElementById('imagePreviewContainer');
                previewContainer.innerHTML = '';  // Clear previous previews
                previewContainer.classList.remove('hidden');  // Make preview container visible

                Array.from(event.target.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const imgContainer = document.createElement('div');
                        imgContainer.classList.add('position-relative', 'm-2');
                        imgContainer.setAttribute('data-index', index);

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail');
                        img.style.maxWidth = '100px';

                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0', 'end-0');
                        deleteButton.innerText = '×';
                        deleteButton.onclick = () => confirmDeleteNewImage(imgContainer, index);

                        imgContainer.appendChild(img);
                        imgContainer.appendChild(deleteButton);
                        previewContainer.appendChild(imgContainer);
                    };
                    reader.readAsDataURL(file);
                });
            });

            function confirmDeleteNewImage(imgContainer, index) {
                if (confirm('คุณต้องการลบรูปภาพนี้หรือไม่?')) {
                    deleteNewImage(imgContainer, index);
                }
            }

            function deleteNewImage(imgContainer, index) {
                imgContainer.remove();
                const fileInput = document.getElementById('images');
                const dataTransfer = new DataTransfer();
                Array.from(fileInput.files).forEach((file, i) => {
                    if (i !== index) {
                        dataTransfer.items.add(file);
                    }
                });
                fileInput.files = dataTransfer.files;
            }

            function deleteImage(imageId) {
                if (!confirm('คุณต้องการลบรูปภาพนี้หรือไม่?')) return;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/highlight/image/delete/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`image-${imageId}`).remove();
                        } else {
                            alert('เกิดข้อผิดพลาด: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
                        console.error('Error:', error);
                    });
            }


            // Tags Manager with Autocomplete
            document.addEventListener('DOMContentLoaded', function () {
                const tagInput = document.getElementById('tag-input');
                const addTagBtn = document.getElementById('add-tag-btn');
                const tagsContainer = document.getElementById('tags-container');
                const tagsInputField = document.getElementById('tags-input');
                const tagSuggestions = document.getElementById('tag-suggestions');
                // ดึงค่า tags ปัจจุบันจาก $highlight->tags
                let tags = [
                    @foreach($highlight->tags as $tag)
                        "{{ $tag->name }}",
                    @endforeach
                ];

                let allTags = [];

                // ดึงข้อมูล tags ทั้งหมดจาก API
                fetch('{{ route("tags.list") }}')
                    .then(response => response.json())
                    .then(data => {
                        allTags = data.map(tag => tag.name);
                    })
                    .catch(error => console.error('Error fetching tags:', error));
                // Function to update the hidden input with all tags
                function updateTagsInput() {
                    tagsInputField.value = JSON.stringify(tags);
                }
                // Function to create a tag element
                function createTagElement(tagName) {
                    const tagElement = document.createElement('div');
                    tagElement.className = 'badge bg-primary me-1 mb-1 p-2';
                    tagElement.style.position = 'relative';

                    tagElement.innerHTML = `${tagName} <button type="button" class="btn-close btn-close-white ms-2" 
                                style="font-size: 0.5rem;" aria-label="Close"></button>`;

                    // Add click event to remove tag
                    tagElement.querySelector('.btn-close').addEventListener('click', function () {
                        tags = tags.filter(t => t !== tagName);
                        tagElement.remove();
                        updateTagsInput();
                    });

                    return tagElement;
                }

                // Function to add a new tag
                function addTag(tagName) {
                    tagName = tagName.replace(/\s+/g, '');
                    if (tagName && !tags.includes(tagName)) {
                        tags.push(tagName);
                        tagsContainer.appendChild(createTagElement(tagName));
                        updateTagsInput();
                    }
                    tagInput.value = '';
                    tagInput.focus();
                    tagSuggestions.classList.add('d-none');
                }

                // Function to show tag suggestions
                function showSuggestions(inputValue) {
                    // Clear previous suggestions
                    tagSuggestions.innerHTML = '';

                    // สำหรับการพิมพ์แค่ตัวเดียวหรือไม่มีการพิมพ์เลย
                    if (!inputValue) {
                        // แสดง tags ยอดนิยม 5 อันแรก หรือ tags ทั้งหมดถ้ามีน้อยกว่า 5
                        const popularTags = allTags.slice(0, Math.min(5, allTags.length));

                        if (popularTags.length > 0) {
                            // แสดงหัวข้อ
                            const header = document.createElement('div');
                            header.className = 'list-group-item disabled text-muted small';
                            header.textContent = 'Tags ยอดนิยม:';
                            tagSuggestions.appendChild(header);

                            // สร้างรายการ tags
                            popularTags.forEach(tag => {
                                if (!tags.includes(tag)) {
                                    const item = document.createElement('button');
                                    item.type = 'button';
                                    item.className = 'list-group-item list-group-item-action';
                                    item.textContent = tag;

                                    item.addEventListener('click', () => {
                                        addTag(tag);
                                    });

                                    tagSuggestions.appendChild(item);
                                }
                            });

                            tagSuggestions.classList.remove('d-none');
                        } else {
                            tagSuggestions.classList.add('d-none');
                        }
                        return;
                    }

                    // Filter tags that match input (แม้แต่แค่หนึ่งตัวอักษร)
                    const filteredTags = allTags.filter(tag =>
                        tag.toLowerCase().includes(inputValue.toLowerCase()) &&
                        !tags.includes(tag)
                    );

                    if (filteredTags.length === 0) {
                        // ถ้าไม่พบ tag ที่ตรงกับการค้นหา ให้แสดงทางเลือกในการสร้าง tag ใหม่
                        const createItem = document.createElement('button');
                        createItem.type = 'button';
                        createItem.className = 'list-group-item list-group-item-action text-primary';
                        createItem.innerHTML = `<i class="fas fa-plus-circle me-2"></i>แท็ก "<strong>${inputValue}</strong>"`;

                        createItem.addEventListener('click', () => {
                            addTag(inputValue);
                        });

                        tagSuggestions.appendChild(createItem);
                        tagSuggestions.classList.remove('d-none');
                    } else {
                        // เรียงลำดับผลการค้นหาโดยให้ที่ขึ้นต้นด้วยตัวอักษรที่พิมพ์มาก่อน
                        filteredTags.sort((a, b) => {
                            const aStartsWith = a.toLowerCase().startsWith(inputValue.toLowerCase());
                            const bStartsWith = b.toLowerCase().startsWith(inputValue.toLowerCase());

                            if (aStartsWith && !bStartsWith) return -1;
                            if (!aStartsWith && bStartsWith) return 1;
                            return a.localeCompare(b);
                        });

                        // แสดงผลการค้นหา
                        filteredTags.forEach(tag => {
                            const item = document.createElement('button');
                            item.type = 'button';
                            item.className = 'list-group-item list-group-item-action';

                            // ไฮไลต์ตัวอักษรที่ตรงกัน
                            const index = tag.toLowerCase().indexOf(inputValue.toLowerCase());
                            if (index >= 0) {
                                const before = tag.substring(0, index);
                                const match = tag.substring(index, index + inputValue.length);
                                const after = tag.substring(index + inputValue.length);
                                item.innerHTML = `${before}<strong class="text-primary">${match}</strong>${after}`;
                            } else {
                                item.textContent = tag;
                            }

                            item.addEventListener('click', () => {
                                addTag(tag);
                            });

                            tagSuggestions.appendChild(item);
                        });

                        // เพิ่มตัวเลือกสร้าง tag ใหม่ถ้ากรณีที่ไม่มี tag ตรงกับที่พิมพ์ทั้งหมด
                        if (!filteredTags.some(tag => tag.toLowerCase() === inputValue.toLowerCase())) {
                            const createItem = document.createElement('button');
                            createItem.type = 'button';
                            createItem.className = 'list-group-item list-group-item-action text-primary';
                            createItem.innerHTML = `<i class="fas fa-plus-circle me-2"></i>สร้างแท็ก "<strong>${inputValue}</strong>"`;

                            createItem.addEventListener('click', () => {
                                addTag(inputValue);
                            });

                            tagSuggestions.appendChild(createItem);
                        }

                        tagSuggestions.classList.remove('d-none');
                    }
                }

                // Add tag when pressing Enter
                tagInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault(); // Prevent form submission

                        // If a suggestion is selected, use that
                        const selectedSuggestion = tagSuggestions.querySelector('.active');
                        if (selectedSuggestion && !tagSuggestions.classList.contains('d-none')) {
                            addTag(selectedSuggestion.textContent);
                        } else {
                            // Otherwise use the input value
                            const tagName = this.value.trim();
                            addTag(tagName);
                        }
                    }
                });

                // Navigate through suggestions with arrow keys
                tagInput.addEventListener('keydown', function (e) {
                    if (tagSuggestions.classList.contains('d-none')) return;

                    const items = tagSuggestions.querySelectorAll('.list-group-item');
                    let activeItem = tagSuggestions.querySelector('.active');
                    let activeIndex = Array.from(items).indexOf(activeItem);

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        if (activeItem) {
                            activeItem.classList.remove('active');
                            activeIndex = (activeIndex + 1) % items.length;
                        } else {
                            activeIndex = 0;
                        }
                        items[activeIndex].classList.add('active');
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        if (activeItem) {
                            activeItem.classList.remove('active');
                            activeIndex = (activeIndex - 1 + items.length) % items.length;
                        } else {
                            activeIndex = items.length - 1;
                        }
                        items[activeIndex].classList.add('active');
                    } else if (e.key === 'Escape') {
                        tagSuggestions.classList.add('d-none');
                    }
                });

                // Show suggestions when typing
                tagInput.addEventListener('input', function () {
                    showSuggestions(this.value.trim());
                });

                // Hide suggestions when clicking outside
                document.addEventListener('click', function (e) {
                    if (!tagInput.contains(e.target) && !tagSuggestions.contains(e.target)) {
                        tagSuggestions.classList.add('d-none');
                    }
                });

                // Add tag when clicking the Add button
                addTagBtn.addEventListener('click', function () {
                    const tagName = tagInput.value.trim();
                    addTag(tagName);
                });

                // Initialize with existing tags
                tags.forEach(tagName => {
                    tagsContainer.appendChild(createTagElement(tagName));
                });
                // Initialize the hidden input
                updateTagsInput();
            });

        </script>
    @endsection

</body>

</html>