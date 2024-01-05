@extends('layouts.admin')
@push('header_css')
<style>
    .checked-btns {
        display: none;
    }
</style>
@endpush

@section('page-content')
<div class="row">
    <div class="col-lg-10 m-auto">
        <form action="{{route('checked.trash')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4>Trash Categories :</h4>
                </div>
                <div class="card-body">
                    @if (session('restore'))
                        <div class="alert alert-success">{{session('restore')}}</div>
                    @endif
                    @if (session('trash_delete'))
                        <div class="alert alert-success">{{session('trash_delete')}}</div>
                    @endif
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input all-checked">
                                            All
                                            <i class="input-frame"></i>
                                        </label>
                                    </div>
                                </th>
                                <th>SL</th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $sl=>$category)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input input-checked" name="category_id[]" value="{{$category->id}}">
                                        <i class="input-frame"></i></label>
                                    </div>
                                </td>
                                <td>{{$sl+1}}</td>
                                <td>
                                    <img src="{{asset('uploads/category_icon')}}/{{$category->category_icon}}" alt="{{$category->category_icon}}">
                                </td>
                                <td>
                                    <b>{{$category->category_name}}</b>
                                </td>
                                <td>
                                    <a data-toggle="tooltip" data-placement="top" title="restore" href="{{route('restore.category', $category->id)}}" class="btn btn-success btn-icon">
                                        <i data-feather="rotate-cw"></i>
                                    </a>
                                    <a data-toggle="tooltip" data-placement="top" title="delete" href="{{route('trash.delete', $category->id)}}" class="btn btn-danger btn-icon">
                                        <i data-feather="trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-secondary">No trash found!</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer checked-btns">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success mr-2" name="btns" value="restore">Restore Checked</button>
                        <button type="submit" class="btn btn-danger" name="btns" value="delete">Delete Checked</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('footer_script')
<script>
    let check = () => {
        let allChecked = document.querySelector('.all-checked'),
        inputChecked = document.querySelectorAll('.input-checked'),
        checkedBtns = document.querySelector('.checked-btns');

        $(inputChecked).on('click', function() {
            if(this.checked) {
                checkedBtns.style.display = 'block'
            }else { 
                checkedBtns.style.display = 'none'
            }
        })

        $(allChecked).on('click', function(){
            if(this.checked) {
                $(inputChecked).prop("checked",true)
                checkedBtns.style.display = 'block'
            }else {
                $(inputChecked).prop("checked",false)
                checkedBtns.style.display = 'none'
            }
        })
    }
    check();
</script>
@endpush