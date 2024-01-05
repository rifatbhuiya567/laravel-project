@extends('layouts.admin')

@push('header_css')
<style>
    .edit-subcategory-img img {
        height: 50px;
        width: 50px;
        background-color: #f2f2f2;
        box-shadow: .5px .5px 3px 0 rgba(0, 0, 0, 0.3);
        border-radius: 50%
    }   
</style>
@endpush

@section('page-content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Edit sub category :</h4>
            </div>
            <div class="card-body">
                @if (session('sub_updated'))
                    <div class="alert alert-success">{{session('sub_updated')}}</div>
                @endif
                <form action="{{route('update.sub.category', $subcategories->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (session('sub_category_added'))
                        <div class="alert alert-success">{{session('sub_category_added')}}</div>
                    @endif
                    <div class="mb-2">
                        <label class="form-label">Category Name</label>
                        <select name="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option {{$category->id == $subcategories->category_id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Sub Category Name</label>
                        <input type="text" class="form-control" placeholder="Subcategory name" value="{{$subcategories->sub_category_name}}" name="sub_category">
                        @error('sub_category')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Sub Category Icon</label>
                        <input type="file" class="form-control" name="sub_category_icon">
                        @error('sub_category_icon')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        <div class="mt-3 edit-subcategory-img">
                            <img width="60" src="{{asset('uploads/sub_category_icon')}}/{{$subcategories->sub_category_icon}}" alt="{{$subcategories->sub_category_icon}}"/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Edit Sub Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection