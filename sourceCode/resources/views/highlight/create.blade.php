<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create Highlight</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h2 class="mb-4">สร้าง Highlight ใหม่</h2>

            <form action="{{ route('highlight.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label"><span style="color: red;">*</span> ชื่อ</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                        required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Detail -->
                <div class="mb-3">
                    <label for="detail" class="form-label"><span style="color: red;">*</span> คำอธิบาย</label>
                    <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" rows="8"
                        style="height: 200px; resize: vertical;" required></textarea>
                    @error('detail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Cover Image Upload -->
                <div class="mb-3">
                    <label for="cover_image" class="form-label">
                        <span class="text-red-500">*</span> อัปโหลดภาพปก (ขนาดแนะนำ 1600 x 900)
                    </label>

                    <!-- Image Upload Box -->
                    <div class="relative border-dashed border-2 border-gray-400 rounded-lg p-8 text-center cursor-pointer hover:border-blue-500 transition-all"
                        id="uploadBox">
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" required
                            class="absolute inset-0 opacity-0 cursor-pointer">

                        <!-- Upload Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-black-400 mx-auto mb-2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>

                        <!-- Instruction Text -->
                        <p class="text-grey-600"><span class="text-black-500 font-bold">คลิกเพื่ออัปโหลดรูป</span> PNG,
                            JPeg, SVG (ขนาดแนะนำ 1600 x 900)</p>

                        <!-- Image Preview (Initially hidden) -->
                        <img id="coverPreview" src="#" alt="Cover Preview" class="w-128 h-64 rounded-lg hidden p-0">
                    </div>

                    <!-- Error Message -->
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

                <!-- Tags Input -->
                <div class="mb-3">
                    <label for="tag-input" class="form-label"><span style="color: red;">*</span> เพิ่มแท็ก</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" style="height:100%" id="tag-input"
                            placeholder="พิมพ์ Tag แล้วกด Enter เพื่อเพิ่ม" autocomplete="off">
                        <button class="btn btn-outline-secondary" type="button" id="add-tag-btn">เพิ่ม</button>
                    </div>

                    <div id="tag-suggestions" class="list-group position-absolute d-none"
                        style="z-index: 1000; width: 95%;"></div>
                    <div id="tags-container" class="d-flex flex-wrap gap-2 mb-2">
                        <!-- Tags will be displayed here -->
                    </div>

                    <!-- เพิ่ม debug output -->
                    <div class="small text-muted mt-1">แท็กที่ถูกเลือก: <span id="debug-tags"></span></div>
                    <input type="hidden" name="tags_json" id="tags-input">
                    @error('tags')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">สร้าง Highlight</button>
                <a href="{{ route('highlight.index') }}" class="btn btn-secondary">ยกเลิก</a>
            </form>
        </div>
    @endsection

    <!-- ใช้ชื่อ section ที่ถูกต้อง: javascript -->
    @section('javascript')
        <script>
            document.getElementById('cover_image').addEventListener('change', function (event) {
                let coverPreview = document.getElementById('coverPreview');
                let uploadBox = document.getElementById('uploadBox'); // Get the upload box

                if (event.target.files.length > 0) {
                    let file = event.target.files[0];
                    coverPreview.src = URL.createObjectURL(file);  // Set the image source
                    coverPreview.classList.remove('hidden');  // Show the image preview

                    // Hide dashed border, icon, and text after file selection
                    uploadBox.classList.remove('border-dashed', 'border-2', 'border-gray-400');  // Remove dashed border
                    uploadBox.querySelector('svg').classList.add('hidden');  // Hide the upload icon
                    uploadBox.querySelector('p').classList.add('hidden');  // Hide the instruction text
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

            // Tags Manager with Autocomplete
            document.addEventListener('DOMContentLoaded', function () {
                const tagInput = document.getElementById('tag-input');
                const addTagBtn = document.getElementById('add-tag-btn');
                const tagsContainer = document.getElementById('tags-container');
                const tagsInputField = document.getElementById('tags-input');
                const tagSuggestions = document.getElementById('tag-suggestions');
                const debugTags = document.getElementById('debug-tags');

                let tags = [];
                let allTags = [];

                // ดึงข้อมูล tags ทั้งหมดจาก API
                fetch('{{ route("tags.list") }}')
                    .then(response => {
                        console.log('Raw response:', response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('API Response data:', data);
                        allTags = data.map(tag => tag.name);
                        console.log('Extracted tag names:', allTags);
                    })
                    .catch(error => {
                        console.error('Error fetching tags:', error);
                    });

                // Function to update the hidden input with all tags
                function updateTagsInput() {
                    tagsInputField.value = JSON.stringify(tags);
                    // เพิ่มการแสดงผลเพื่อ debug
                    debugTags.textContent = tags.join(', ');
                    console.log('Updated tags:', tags);
                    console.log('Hidden input value:', tagsInputField.value);
                }

                // Function to add a new tag
                function addTag(tagName) {
                    tagName = tagName.replace(/\s+/g, '');
                    if (tagName && !tags.includes(tagName)) {
                        tags.push(tagName);

                        // Create tag element
                        const tagElement = document.createElement('div');
                        tagElement.className = 'badge bg-primary me-1 mb-1 p-2';
                        tagElement.style.position = 'relative';

                        tagElement.innerHTML = `
                                                                                                            ${tagName}
                                                                                                            <button type="button" class="btn-close btn-close-white ms-2" 
                                                                                                                    style="font-size: 0.5rem;" aria-label="Close"></button>
                                                                                                        `;

                        // Add click event to remove tag
                        tagElement.querySelector('.btn-close').addEventListener('click', function () {
                            tags = tags.filter(t => t !== tagName);
                            tagElement.remove();
                            updateTagsInput();
                        });

                        tagsContainer.appendChild(tagElement);
                        updateTagsInput();
                    }

                    tagInput.value = '';
                    tagInput.focus();
                    tagSuggestions.classList.add('d-none');
                }

                // Function to show tag suggestions - ปรับปรุงแล้ว
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
                        createItem.innerHTML = `<i class="fas fa-plus-circle me-2"></i>สร้าง tag "<strong>${inputValue}</strong>"`;

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
                            createItem.innerHTML = `<i class="fas fa-plus-circle me-2"></i>สร้าง tag "<strong>${inputValue}</strong>"`;

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

                // เพิ่ม event focus เพื่อแสดง suggestions เมื่อ input ได้รับ focus
                tagInput.addEventListener('focus', function () {
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

                // เพิ่ม event listener สำหรับ form submit เพื่อตรวจสอบค่าก่อนส่ง
                const form = document.querySelector('form');
                form.addEventListener('submit', function (e) {
                    console.log('Form submitted. Tags value:', tagsInputField.value);
                });

                // Initialize the hidden input
                updateTagsInput();
            });
        </script>
    @endsection
</body>

</html>