@extends('layouts.admin')

@section('page-content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Colors List:</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Color Name</th>
                                <th>Color</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $color)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $color->color_name }}</td>
                                    <td>
                                        <span
                                            style="display: inline-block; height: 20px; width: 40px; background-color: {{ $color->color_code == 'NA' ? '' : $color->color_code }};">{{ $color->color_code == 'NA' ? 'NA' : '' }}</span>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Size list:</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Size name</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sizes as $size)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $size->size }}</td>
                                    <td>
                                        <a href="" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Tag list:</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Tag name</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tag)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $tag->tag }}</td>
                                    <td>
                                        <a href="" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Add Color</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('color.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <input type="text" placeholder="Write color name.." class="form-control" name="color_name">
                            @error('color_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <input type="text" placeholder="Write color hex # value.." class="form-control"
                                name="color_code">
                            @error('color_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary w-100">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Add Size</h4>
                </div>
                <div class="card-body">
                    @if (session('size_added'))
                        <div class="alert alert-success">{{ session('size_added') }}</div>
                    @endif
                    <form action="{{ route('size.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            @error('category_id')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <input type="text" name="size" placeholder="Add size.." class="form-control">
                            @error('size')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary w-100">Add Size</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Add Tags</h4>
                </div>
                <div class="card-body">
                    @if (session('tag_added'))
                        <div class="alert alert-success">{{ session('tag_added') }}</div>
                    @endif
                    <form action="{{ route('tags.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="tag" placeholder="Add tag.." class="form-control">
                            @error('tag')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary w-100">Add Size</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
