@extends('admin._layouts.index')
@section('title','Ngôn ngữ hệ thống')
@section('content')

    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 style="font-family: Arial, Helvetica, sans-serif" class="m-subheader__title m-subheader__title--separator"> {{__('Ngôn ngữ hệ thống')}} </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="{{route('dashboard.index')}}" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator mr-3">-  </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text"> {{__('Ngôn ngữ hệ thống')}} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="m-subheader">
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{__('Danh sách ngôn ngữ')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{route('language-nation.create')}}" class="btn btn-success m-btn m-btn--custom m-btn--icon">
                        <span>
                            <i class="la la-calendar-check-o"></i>
                            <span> {{__('Thêm ngôn ngữ')}} </span>
                        </span>
                    </a>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-section" >
                    @if(count($errors)>0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>
                            @foreach($errors->all() as $err)
                                <strong>{{__('Thông báo')}} !</strong> {{$err}}<br>
                            @endforeach
                        </div>
                    @endif
                    <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer text-center" role="grid" id="table_main">
                        <thead> 
                            <tr>
                                <th>ID</th>
                                <th> {{__('Quốc gia')}} </th>
                                <th> {{__('Hình ảnh')}} </th>
                                <th> {{__('Mô tả')}} </th>
                                <th> {{__('Hành động')}} </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!--end::Form-->
        </div>
        </div>
        <!-- END: Subheader -->
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{__('Xóa ngôn ngữ')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{__('Bạn có muốn xóa')}} ?
                </div>
                <div class="modal-footer">
                    <form id="form-delete" role="form" method="POST" enctype="multipart/form-data" action="">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{__('Quay lại')}} </button>
                        <button type="submit" class="btn btn-primary"> {{__('Xóa')}} </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function(){

            $('#exampleModal').on('show.bs.modal', function(e) {
                var action=$( e.relatedTarget).data('action');
                $('#form-delete').attr('action',action );
            });
        });

        var datatable;
        jQuery(document).ready(function (){
        datatable = $('#table_main').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('language-nation.index') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'image', title: 'Hình ảnh',
                        render: function ( data, type, row ) {
						if(row.image=="" || row.image==null){
							return  "<img class=\"image-item\" src=\"/assets/backend/images/empty-photo.jpg\" style=\"max-width: 50px;max-height: 50px\">";
						}
						else{
							return  "<a target='_blank' class=\"text-pop-link\" href="+row.image+"><img class=\"text-pop-link\" src=\""+row.image+"\" style=\"max-width: 50px;max-height: 50px\">";
						}
					}
                     },
                     { data: 'description', name: 'description' },
                    { data: 'action', name:'action' } 
                ]
            });
        })

    </script>
@stop
