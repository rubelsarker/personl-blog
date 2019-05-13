@extends('layouts.backend.app')
@section('title','Subscriber List')
@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{url('')}}/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
@endpush
@section('content')
    <div class="container-fluid">


        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            All Subscribers
                            <span class="badge bg-blue">{{$subscribers->count()}}</span>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>


                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($subscribers as $key=>$subscriber)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$subscriber->email}}</td>
                                        <td>{{$subscriber->created_at}}</td>
                                        <td>{{$subscriber->updated_at}}</td>
                                        <td class="text-center">

                                            <button class="btn btn-danger waves-effect" type="button"
                                            onclick="deleteSubscriber({{$subscriber->id}})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="delete-form-{{$subscriber->id}}" action="{{route('admin.subscriber.destroy',$subscriber->id)}}" method="post" style="display: none">
                                                @csrf
                                                @method('DELETE')

                                            </form>

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
        <!-- #END# Exportable Table -->
    </div>
@endsection
@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{url('')}}/assets/backend/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="{{url('')}}/assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="{{url('')}}/assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="{{url('')}}/assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="{{url('')}}/assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="{{url('')}}/assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="{{url('')}}/assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="{{url('')}}/assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="{{url('')}}/assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <script src="{{url('')}}/assets/backend/js/pages/tables/jquery-datatable.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        function deleteSubscriber(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+ id ).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush


{{--@extends('layouts.backend.app')--}}
{{--@section('title','')--}}
{{--@push('css')--}}
{{--@endpush--}}
{{--@section('content')--}}
{{--@endsection--}}
{{--@push('js')--}}
{{--@endpush--}}