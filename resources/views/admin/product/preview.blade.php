@extends('layouts.admin')

@push('header_css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <style>
        .toggle-on.btn {
            padding-right: 26px;
        }

        .toggle-on {
            background-color: #727cf5
        }

        .toggle-off {
            background: #f1f1f1
        }

        .toggle-off.btn {
            padding-left: 14px;
        }

        .toggle-handle {
            background: #d3d3d3;
        }

        .toggle .btn {
            line-height: 1.3;
        }

        .status-alert {
            display: none
        }
    </style>
@endpush

@section('alert')
    <div class="alert alert-success status-alert">
        <div class="status-alert-message"></div>
    </div>
@endsection

@section('page-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>All Products :</h4>
                    <a href="{{ route('product') }}" class="btn btn-primary">Add new prodcut</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Sub Category</th>
                                <th>Name</th>
                                <th>Discount Price</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session('product_delete'))
                                <div class="alert alert-success">{{ session('product_delete') }}</div>
                            @endif
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        @foreach (App\Models\SubCategory::where('id', $product->sub_category_id)->get() as $sub)
                                            {{ $sub->sub_category_name }}
                                        @endforeach
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->after_discount_price }}</td>
                                    <td>
                                        <img src="{{ asset('uploads/product/preview') }}/{{ $product->product_image }}"
                                            alt="" />
                                    </td>
                                    <td>
                                        <input type="checkbox" {{ $product->status == 1 ? 'checked' : '' }}
                                            data-toggle="toggle" class="tgl" value="{{ $product->status }}"
                                            data-id="{{ $product->id }}">
                                    </td>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="inventory"
                                            href="{{ route('add.inventory', $product->id) }}"
                                            class="btn btn-secondary btn-icon">
                                            <i data-feather="layers"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="top" title="full details"
                                            href="{{ route('view.full.product', $product->id) }}"
                                            class="btn btn-primary btn-icon">
                                            <i data-feather="eye"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="top" title="delete"
                                            href="{{ route('delete.product', $product->id) }}"
                                            class="btn btn-danger btn-icon">
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
    </div>
@endsection

@push('footer_script')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        var statusAlert = document.querySelector('.status-alert'),
            statusMessage = document.querySelector('.status-alert-message');

        $('.tgl').on('change', function() {
            var id = $(this).attr('data-id');

            if ($(this).val() == 0) {
                $(this).val(1)
            } else {
                $(this).val(0)
            }

            var val = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/product_status",
                type: "POST",
                data: {
                    'id': id,
                    'val': val
                },
                success: function(data) {
                    statusMessage.innerHTML = 'Status updated!';
                    statusAlert.style.display = 'block';
                    $(statusAlert).fadeOut(5000);
                }
            });
        })
    </script>
@endpush
