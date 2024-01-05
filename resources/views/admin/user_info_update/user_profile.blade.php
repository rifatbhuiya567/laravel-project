@extends('layouts.admin')

@section('page-content')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Basic Info :</h4>
            </div>
            <div class="card-body">
                @if (session('info_updated'))
                    <div class="alert alert-success">{{session('info_updated')}}</div>
                @endif
                <form class="forms-sample" action="{{route('basic.update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="name"  placeholder="Username" value="{{Auth::user()->name}}">
                    </div>
                    <div class="form-group">
                        <label for="useremail">Email address</label>
                        <input type="email" class="form-control" id="useremail" name="email" placeholder="Email" value="{{Auth::user()->email}}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save chnages</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Password Update :</h4>
            </div>
            <div class="card-body">
                @if (session('password_update'))
                    <div class="alert alert-success">{{session('password_update')}}</div>
                @endif
                <form class="forms-sample" action="{{route('password.update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="password" class="form-control" name="current_password"  placeholder="Current Password">
                        @error('current_password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if (session('wrong_password'))
                            <strong class="text-danger">{{session('wrong_password')}}</strong>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password"  placeholder="New Password">
                        @error('password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation"  placeholder="Confirm New Password">
                        @error('password_confirmation')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save chnages</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Photo :</h4>
            </div>
            <div class="card-body">
                @if (session('uploaded'))
                    <div class="alert alert-success">{{session('uploaded')}}</div>
                @endif
                <form class="forms-sample" action="{{route('photo.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" type="file" name="photo" onchange="document.getElementById('photo').src = window.URL.createObjectURL(this.files[0])">
                        @error('photo')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        <div class="mt-2">
                            <img id="photo" src="{{asset('uploads/users_photo')}}/{{Auth::user()->photo}}" alt="your image" style="width: 100%; height: 100%;"/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save chnages</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection