@extends('layouts.admin')

@section('page-content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>All Brands :</h4>
            </div>
            <div class="card-body">
                @if (session('brand_deleted'))
                    <div class="alert alert-success">{{session('brand_deleted')}}</div>
                @endif
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $sl => $brand)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$brand->brand_name}}</td>
                            <td>
                                <img src="{{asset('uploads/brand_images')}}/{{$brand->brand_image}}" alt="{{$brand->brand_image}}"/>
                            </td>
                            <td>
                                <a href="{{route('delete.brand', $brand->id)}}" title="delete" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="mt-2 alert alert-secondary text-center">No Brand Data Found!</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Add New Brnad :</h4>
            </div>
            <div class="card-body">
                @if (session('add_brand'))
                    <div class="alert alert-success">{{session('add_brand')}}</div>
                @endif
                <form action="{{route('add.brand')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Brand Name</label>
                        <input type="text" name="brand_name" class="form-control" value="{{old('brand_name')}}" placeholder="Enter a brand name..">
                        @error('brand_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Brand Image</label>
                        <input type="file" name="brand_image" class="form-control">
                        @error('brand_image')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add New Brand</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection