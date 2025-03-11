@extends('layouts.layout')
@section('content')
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: "Noto Sans Thai";
            
        }

        .title {
            font-size: 32px;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .img-container {
            width: 170px;
            max-width: 170px;
            height: 120px;
            max-height: 120px;
            overflow: hidden;
        }

        .image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.8s ease;
        }

        .image:hover {
            scale: 1.2;
            opacity: 0.8;
        }

        .image-modal {
            top: 0;
        }

        .px {
            padding-left: 120px;
            padding-right: 120px;
        }

        .info {
            font-size: 14px;
            opacity: 90%;
        }

        .cover-image {
            width: 100%;
            height: 40vw;
            object-fit: cover;
        }

        body.modal-open {
            overflow: hidden;
        }

        .modal-dialog {
            max-width: 80vw;
            max-height: 50vh;
            margin: 1rem auto;
        }


        .blur {
            backdrop-filter: blur(5px);
        }

        p {
            font-family: "Noto Sans Thai", "Kanit", sans-serif !important;
        }

        .detail {
            font-size: 18px;
            white-space: pre-wrap;
            font-family: "Noto Sans Thai", "Kanit", sans-serif !important;
        }

    </style>

    <body>
        <div class="justify-content-center">
            <img src="{{$highlight->cover_image}}" class="cover-image" alt="Cover Image">
        </div>
        <div class="container mt-3 px">
            <div>

                <div>
                    <h1 class="title">{{ $highlight->title }}</h1>
                </div>
                <hr>
                <div class="my-4">
                    <p class="info" id="creationInfo">{{trans('message.publish')}} :
                        {{$highlight->created_at->format('Y-m-d H:i')}} {{trans('message.by')}} {{$highlight->creator}}
                    </p>
                    <p class="info" id="tagsInfo">{{trans('message.tags')}} :
                        @foreach($highlight->tags as $tag)
                            <a href="highlights/tag/{{$tag->name}}" id="tagLink-{{$tag->name}}">
                                <i class="fas fa-tag"></i>{{$tag->name}}</a>
                        @endforeach
                    </p>
                    <pre class="detail">{!! $highlight->detail !!}</pre>
                </div>
                <hr>
                <i> Gallery </i>
                <div class="py-2 col-12">
                    <div class="px-2 container-fluid">
                        <div class="row">
                            @foreach($highlight->images as $image)
                                <!-- image -->
                                <div class="col-sm-12 col-md-6 col-lg-2 p-2 img-container">
                                    <img src="{{$image->image_path}}" id="image-{{$image->id}}" class="image"
                                        data-bs-toggle="modal" data-bs-target="#imageModal{{ $image->id }}"
                                        alt="highlight image">
                                </div>

                                <!-- modal -->
                                <div class="modal fade overflow-hidden blur" id="imageModal{{ $image->id }}" tabindex="-1"
                                    aria-labelledby="imageModalLabel{{ $image->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div>
                                            <img src="{{ $image->image_path }}" class="img-fluid rounded" alt="full image">
                                            <button type="button"
                                                class="btn-close btn-close-white position-absolute top-0 end-0 m-2"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection