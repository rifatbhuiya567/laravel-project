@extends('layouts.admin')

@section('page-content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>All Categories :</h4>
            </div>
            <div class="card-body">
                @if (session('soft_delete'))
                    <div class="alert alert-success">{{session('soft_delete')}}</div>
                @endif
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $sl=>$category)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>
                                <img src="{{asset('uploads/category_icon')}}/{{$category->category_icon}}" alt="{{$category->category_icon}}">
                            </td>
                            <td>
                                <b>{{$category->category_name}}</b>
                            </td>
                            <td>
                                <a data-toggle="tooltip" data-placement="top" title="edit" href="{{route('edit.category', $category->id)}}" class="btn btn-primary btn-icon">
                                    <i data-feather="edit"></i>
                                </a>
                                <a data-toggle="tooltip" data-placement="top" title="delete" href="{{route('soft.delete.category', $category->id)}}" class="btn btn-danger btn-icon">
                                    <i data-feather="trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="alert alert-secondary">No Category found!</div>
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
                <h4>Add Category :</h4>
            </div>
            <div class="card-body">
                @if (session('category_added'))
                    <div class="alert alert-success">{{session('category_added')}}</div>
                @endif
                <form action="{{route('add.category')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" placeholder="Category Name!" class="form-control" value="{{old('category_name')}}">
                        @error('category_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Category Icon</label>
                        <input type="file" name="category_icon" placeholder="Category Icon!" class="form-control">
                        @error('category_icon')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary w-100">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection