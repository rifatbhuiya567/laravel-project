@extends('layouts.admin')

@push('header_css')
<style>
    .sub .card .card-body {
        padding: 0.5rem 0.5rem;
    }
</style>
@endpush

@section('page-content')
<div class="row">
    <div class="col-lg-8">
        <div class="card px-2">
            <div class="card-header">
                <h4>All Sub Categories :</h4>
            </div>
            <div class="row">
                @forelse ($categories as $category)
                <div class="col-lg-6 pt-2 pb-2 sub">
                    <div class="card">
                        <div class="card-header">
                            <h5><b>{{$category->category_name}}</b></h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Icon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse (App\Models\SubCategory::where('category_id', $category->id)->get() as $sl => $subcategory)
                                    <tr>
                                        <td>{{$sl+1}}</td>
                                        <td>{{$subcategory->sub_category_name}}</td>
                                        <td>
                                            <img src="{{asset('uploads/sub_category_icon')}}/{{$subcategory->sub_category_icon}}" alt="">
                                        </td>
                                        <td>
                                            <a data-toggle="tooltip" data-placement="top" title="edit" href="{{route('edit.sub.category', $subcategory->id)}}" class="btn btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <button data-toggle="tooltip" data-placement="top" title="delete" data-link="{{route('delete.sub.category', $subcategory->id)}}" class="btn btn-danger btn-icon del_btn">
                                                <i data-feather="trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="alert alert-secondary text-center">No Sub Category Found!</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="alert alert-secondary text-center w-100 mx-5 mt-2">No Sub Category Found!</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Add new sub category :</h4>
            </div>
            <div class="card-body">
                <form action="{{route('add.sub.category')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (session('sub_category_added'))
                        <div class="alert alert-success">{{session('sub_category_added')}}</div>
                    @endif
                    <div class="mb-2">
                        <label class="form-label">Category Name</label>
                        <select name="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Sub Category Name</label>
                        <input type="text" class="form-control" placeholder="Subcategory name" value="{{old('sub_category')}}" name="sub_category">
                        @error('sub_category')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if (session('not_exist'))
                            <strong class="text-danger">{{session('not_exist')}}</strong>
                        @endif
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Sub Category Icon</label>
                        <input type="file" class="form-control" name="sub_category_icon">
                        @error('sub_category_icon')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Sub Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer_script')
<script>
    var btn = document.querySelectorAll('.del_btn');

    $(btn).click(function() {
        var link = $(this).attr('data-link');

        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        })
    })
</script>
@if (session('sub_deleted'))
<script>
    Swal.fire(
    'Deleted!',
    '{{session('sub_deleted')}}',
    'success'
    )
</script>
@endif
@endpush