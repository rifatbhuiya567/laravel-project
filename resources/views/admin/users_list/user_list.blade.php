@extends('layouts.admin')

@push('header_css')  
<style>
    .password {
        position: relative;
        top: 0;
        left: 0;
    }

    .show_eye,
    .hide_eye,
    .hide_eye2 {
        position: absolute;
        top: 40px;
        right: 8px;
        cursor: pointer;
        opacity: .6;
    }

    .hide_eye,
    .hide_eye2 {
        display: none;
    }
</style>
@endpush

@section('page-content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>User List :</h4>
            </div>
            <div class="card-body">
                @if (session('user_delete'))
                    <div class="alert alert-success">{{session('user_delete')}}</div>
                @endif
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $sl=>$user )
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if ($user->photo == null)
                                    <img src="{{ Avatar::create($user->name)->toBase64() }}" alt="profile"/>
                                @else 
                                    <img src="{{asset('uploads/users_photo')}}/{{$user->photo}}" />
                                @endif
                            </td>
                            <td>
                                <a href="{{route('user.delete',  $user->id)}}" class="btn btn-danger btn-icon">
                                    <i data-feather="trash"></i>
                                </a>
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
                <h4>Add User :</h4>
            </div>
            <div class="card-body">
                @if (session('user_add'))
                    <div class="alert alert-success">{{session('user_add')}}</div>
                @endif
                <form action="{{route('add.user')}}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" placeholder="Enter name!" value="{{old('name')}}" class="form-control">
                        @error('name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" placeholder="Enter email!" value="{{old('email')}}" class="form-control">
                        @error('email')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2 password">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" placeholder="Enter password!" value="{{old('password')}}" class="form-control" id="password">
                        <i class="fa-solid fa-eye show_eye" id="pass_eye"></i>
                        <i class="fa-solid fa-eye-slash hide_eye"></i>
                        @error('password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-2 password">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="Enter confirm password!" value="{{old('confirm_password')}}" class="form-control" id="confirm_password">
                        <i class="fa-solid fa-eye show_eye" id="con_pass_eye"></i>
                        <i class="fa-solid fa-eye-slash hide_eye2"></i>
                        @error('confirm_password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if (session('not_match'))
                            <strong class="text-danger">{{session('not_match')}}</strong>
                        @endif
                    </div>
                    <div class="mb-2">
                        <button type="submit" id="btn" class="w-100 btn btn-primary">Add new user</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer_script')
<script>
    let showHide = () => {
        var password = document.getElementById('password'),
            confirm_password = document.getElementById('confirm_password'),
            password_eye = document.getElementById('pass_eye'),
            confirm_password_eye = document.getElementById('con_pass_eye'),
            hide_eye = document.querySelector('.hide_eye'),
            hide_eye2 = document.querySelector('.hide_eye2');

        $(password_eye).click(function() {
            if(password.type == 'password') {
                password.type = 'text';
                hide_eye.style.display = 'block'
            }
        })

        $(hide_eye).click(function() {
            if(password.type == 'text') {
                password.type = 'password';
                hide_eye.style.display = 'none'
            }
        })

        $(confirm_password_eye).click(function() {
            if(confirm_password.type == 'password') {
                confirm_password.type = 'text'
                hide_eye2.style.display = 'block'
            }
        })

        $(hide_eye2).click(function() {
            if(confirm_password.type == 'text') {
                confirm_password.type = 'password';
                hide_eye2.style.display = 'none'
            }
        })
    }
    showHide();
</script>
@endpush