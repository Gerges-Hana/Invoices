@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@section('title')
    الاقسام
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                المنتج</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('Add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<!-- row -->
<div class="row">


    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                        data-toggle="modal" href="#exampleModal">اضافة منتج</a>

                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم المنتج</th>
                                <th class="border-bottom-0">اسم القسم</th>
                                <th class="border-bottom-0">الوصف</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($products as $product)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $product->Product_name }}</td>
                                    <td>{{ $product->section?->section_name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>

                                        <button class="btn btn-outline-success btn-sm"
                                            data-name="{{ $product->Product_name }}" data-pro_id="{{ $product->id }}"
                                            data-section_name="{{ $product->section?->section_name }}"
                                            data-description="{{ $product->description }}" data-toggle="modal"
                                            data-target="#edit_Product">تعديل</button>





                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-id="{{ $product->id }}"
                                            data-Product_name="{{ $product->Product_name }}"
                                            data-section_name="{{ $product->section_name }}"
                                            data-toggle="modal"
                                            href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>


                                        <a class="modal-effect btn btn-sm btn-success" data-effect="effect-scale"
                                            data-id="{{ $product->id }}"
                                            data-section_name="{{ $product->section_name }}"
                                            data-description="{{ $product->description }}"
                                            data-created_by="{{ $product->created_by }}" data-toggle="modal"
                                            href="#modaldemo99" title="عرض"><i class="las la-eye"></i>




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




</div>
<!-- End Basic modal -->
<!-- add -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة منتج</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('products.store') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المنتج</label>
                        <input type="text" class="form-control" id="Product_name" name="Product_name" required>
                    </div>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                    <select name="section_id" id="section_id" class="form-control" required>
                        <option value="" selected disabled> --حدد القسم--</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">ملاحظات</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">تاكيد</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- تعديل القسم  --}}
<!-- edit -->
<div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action='products/update' method="post">
                {{ method_field('patch') }}
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="form-group">
                        <label for="title">اسم المنتج :</label>

                        <input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">

                        <input type="text" class="form-control" name="Product_name" id="Product_name">
                    </div>

                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                    <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                        @foreach ($sections as $section)
                            <option>{{ $section->section_name }}</option>
                        @endforeach
                    </select>

                    <div class="form-group">
                        <label for="des">ملاحظات :</label>
                        <textarea name="description" cols="20" rows="5" id='description' class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- delete -->
<div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف المنتج</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="products/destroy" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متاكد من عملية الحذف ؟</p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <input class="form-control" name="Product_name" id="Product_name" type="text" readonly>
                    <input class="form-control" name="section_name" id="section_name" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- عرص القسم  --}}
<!-- show -->
<div class="modal" id="modaldemo99">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">عرض القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <p>معلومات اضافيه عن القسم </p><br>
                <input type="hidden" name="id" id="id" value="">
                <label for="section_name">اسم القسم</label>
                <input class="form-control" name="section_name" id="section_name" type="text" readonly>
                <br>
                <label for="description"> الوصف</label>
                <input class="form-control" name="description" id="description" type="text" readonly>
                <br>
                <label for="created_by">المنشأ</label>
                <input class="form-control" name="created_by" id="created_by" type="text" readonly>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
            </div>
        </div>

    </div>
</div>

{{-- <!-- show -->
<div class="modal" id="modaldemo66">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">عرض القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>

                <div class="modal-body">
                    <p>معلومات اضافيه عن القسم </p><br>
                    <input type="hidden" name="id" id="id" value="">
                    <label for="section_name">اسم القسم</label>
                    <input class="form-control" name="section_name" id="section_name" type="text" readonly value="{{ old($id->section_name) }}>
                    <br>
                    <label for="description"> الوصف</label>
                    <input class="form-control" name="description" id="description" type="text" readonly value="{{ old($id->description) }}">
                     <br>
                    <label for="created_by">المنشأ</label>
                    <input class="form-control" name="created_by" id="created_by" type="text" readonly value="{{ old($id->created_by) }}"">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                </div>

        </div>

    </div>
</div> --}}



<!-- row closed -->

<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>

<script>
    // تعديل
    $('#edit_Product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var Product_name = button.data('name')
            var section_name = button.data('section_name')
            var pro_id = button.data('pro_id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #Product_name').val(Product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #pro_id').val(pro_id);
        })
</script>

<script>
    // عرض
    $('#modaldemo99').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var section_name = button.data('section_name')
        var description = button.data('description')
        var created_by = button.data('created_by')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
        modal.find('.modal-body #created_by').val(created_by);
    })
</script>

<script>
    // حذف
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var section_name = button.data('section_name')
        var Product_name = button.data('Product_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #Product_name').val(Product_name);
    })
</script>

@endsection
