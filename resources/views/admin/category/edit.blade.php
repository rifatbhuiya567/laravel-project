@extends('layouts.admin')

@push('header_css')
<style>
    .edit-category-img img {
        height: 50px;
        width: 50px;
        background-color: #f2f2f2;
        box-shadow: .5px .5px 3px 0 rgba(0, 0, 0, 0.3);
        border-radius: 50%
    }   
</style>
@endpush

@section('page-content')
<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h4>Edit Category :</h4>
            </div>
            <div class="card-header">
                @if (session('category_updated'))
                    <div class="alert alert-success">{{session('category_updated')}}</div>
                @endif
                <form action="{{route('update.category', $detail->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" value="{{$detail->category_name}}" name="category_name">
                        @error('category_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Category Icon</label>
                        <input type="file" class="form-control" name="category_icon">
                        @error('category_icon')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        <div class="my-2 edit-category-img">
                            <img src="{{asset('uploads/category_icon')}}/{{$detail->category_icon}}" alt="{{$detail->category_icon}}">
                        </div>
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary w-100">Edit Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection