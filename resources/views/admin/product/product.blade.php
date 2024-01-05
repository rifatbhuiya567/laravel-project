@extends('layouts.admin')

@push('header_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>
        .btn.btn-sm,
        .btn-group-sm>.btn,
        .fc .btn-group-sm>.fc-button,
        .swal2-modal .swal2-actions .btn-group-sm>button,
        .wizard>.actions .btn-group-sm>a,
        .wizard>.actions .disabled .btn-group-sm>a,
        .fc .btn-sm.fc-button,
        .swal2-modal .swal2-actions button.btn-sm,
        .wizard>.actions a.btn-sm {
            font-size: 0.5rem;
        }

        .note-editable {
            height: 160px;
        }

        #preview {
            display: none;
        }

        .upload__inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;

        }

        .upload__btn {
            display: inline-block;
            font-weight: 400;
            color: #919191;
            text-align: center;
            width: 100%;
            padding: 5px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 14px;
            border: 1px solid #e8ebf1;
        }

        .upload__btn-box {
            margin-bottom: 10px;
        }

        .upload__img-wrap {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .upload__img-box {
            width: 100px;
            padding: 0 10px;
            margin-bottom: 12px;
        }

        .upload__img-close {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 4px;
            right: 4px;
            text-align: center;
            line-height: 20px;
            z-index: 1;
            cursor: pointer;
        }

        .upload__img-close:after {
            content: "✖";
            font-size: 14px;
            color: white;
        }

        .img-bg {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            padding-bottom: 100%;
        }

        /* background-color: #e4e4e4; */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #727cf5;
        }
    </style>
@endpush

@section('page-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Add New Product:</h4>
                    <a href="{{ route('preview.product') }}" class="btn btn-primary">Preview All Prodcut</a>
                </div>
                <div class="card-body">
                    @if (session('product_add'))
                        <div class="alert alert-success">{{ session('product_add') }}</div>
                    @endif
                    <form action="{{ route('add.product') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-control all_category">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <label class="form-label">Sub Category</label>
                                    <select name="sub_category" class="form-control all_subcategory">
                                        <option value="">Select sub category</option>
                                    </select>
                                    @error('sub_category')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <label class="form-label">Brand Name</label>
                                    <select name="brand" class="form-control">
                                        <option value="">Select brand name</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="product_name"
                                        placeholder="Enter a product name" value="{{ old('product_name') }}">
                                    @error('product_name')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <label class="form-label">Product Price</label>
                                    <input type="number" class="form-control" name="product_price"
                                        placeholder="Enter a product price.. /=" value="{{ old('product_price') }}">
                                    @error('product_price')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <label class="form-label">Discount Price</label>
                                    <input type="number" class="form-control" name="discount_price"
                                        placeholder="Enter a discount price.. %" value="{{ old('discount_price') }}">
                                    @error('discount_price')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label class="form-label">Product Image</label>
                                    <input type="file" class="form-control" name="product_image" id="upload">
                                    @error('product_image')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                    <div class="my-2">
                                        <img id="preview" alt="your image" height="100" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label class="form-label">Product Gallery Images</label>
                                    <div class="upload__box">
                                        <div class="upload__btn-box">
                                            <label class="upload__btn">
                                                <p>Upload images from here..</p>
                                                <input type="file" multiple="" data-max_length="20"
                                                    class="upload__inputfile" name="gallery_images[]">
                                            </label>
                                        </div>
                                        <div class="upload__img-wrap"></div>
                                    </div>
                                    @error('gallery_images')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label class="form-label">Product Tags</label>
                                    <select class="tags" name="tags[]" multiple="multiple">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
                                        @endforeach
                                    </select>
                                    @error('tags')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" placeholder="Write a short description.."></textarea>
                                    @error('short_description')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <label class="form-label">Long Description</label>
                                    <textarea name="long_description" id="summernote1" class="form-control resize-y"></textarea>
                                    @error('long_description')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <label class="form-label">Additional Information</label>
                                    <textarea name="additional" id="summernote2" class="form-control resize-y"></textarea>
                                    @error('additional')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 m-auto">
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary w-100">Add New Product</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer_script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.tags').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#summernote1').summernote();
            $('#summernote2').summernote();
        });
    </script>
    <script>
        var upload = document.querySelector('#upload'),
            preview = document.querySelector('#preview');

        upload.addEventListener('change', function() {
            preview.style.display = 'block';
            preview.src = window.URL.createObjectURL(this.files[0])
        });
    </script>
    <script>
        jQuery(document).ready(function() {
            ImgUpload();
        });

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            $('.upload__inputfile').each(function() {
                $(this).on('change', function(e) {
                    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                    var maxLength = $(this).attr('data-max_length');

                    var files = e.target.files;
                    var filesArr = Array.prototype.slice.call(files);
                    var iterator = 0;
                    filesArr.forEach(function(f, index) {

                        if (!f.type.match('image.*')) {
                            return;
                        }

                        if (imgArray.length > maxLength) {
                            return false
                        } else {
                            var len = 0;
                            for (var i = 0; i < imgArray.length; i++) {
                                if (imgArray[i] !== undefined) {
                                    len++;
                                }
                            }
                            if (len > maxLength) {
                                return false;
                            } else {
                                imgArray.push(f);

                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    var html =
                                        "<div class='upload__img-box'><div style='background-image: url(" +
                                        e.target.result + ")' data-number='" + $(
                                            ".upload__img-close").length + "' data-file='" + f
                                        .name +
                                        "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                    imgWrap.append(html);
                                    iterator++;
                                }
                                reader.readAsDataURL(f);
                            }
                        }
                    });
                });
            });

            $('body').on('click', ".upload__img-close", function(e) {
                var file = $(this).parent().data("file");
                for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i].name === file) {
                        imgArray.splice(i, 1);
                        break;
                    }
                }
                $(this).parent().parent().remove();
            });
        }
    </script>
    <script>
        var allCategory = document.querySelector('.all_category'),
            allSubCategory = document.querySelector('.all_subcategory');

        allCategory.addEventListener('change', function() {
            var value = this.value;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/subcategory",
                type: "POST",
                data: {
                    "category_id": value
                },
                success: function(data) {
                    allSubCategory.innerHTML = data
                }
            });
        });
    </script>
@endpush
