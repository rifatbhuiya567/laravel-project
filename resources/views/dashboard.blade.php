@extends('layouts.admin')

@section('page-content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-3 mb-md-0">Hello, <span style="color: dodgerblue">{{Auth::user()->name}}</span> - Welcome to Dashboard</h4>
            </div>
        </div>
    </div>
</div>
@endsection