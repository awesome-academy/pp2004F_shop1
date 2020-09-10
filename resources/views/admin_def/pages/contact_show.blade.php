@extends('admin_master_def')

@section('title', '| Contact Details')

@section('content')
    <div class="col-xs-12">
        <h3>Contact Details: {{ $contact->name }}
            <span class="btn-group pull-right">
                <a href="{{ route('admin.contact.index') }}" class="btn btn-default"><i class="fa fa-refresh"></i> Back</a>
                <button class="btn btn-default" id="btn-brand-edit"><i class="fa fa-edit"></i> Edit</button>
                <label for="btn-brand-delete" class="btn btn-default"><i class="fa fa-trash"></i> Delete</label>
            </span>
        </h3>
        <h4 style="margin-top: 20px">Details</h4>
        <div class="row">
            <div class="col-xs-6">
                <div class="box box-warning">
                    <div class="box-body">
                        <table id="table-brand-details" class="table">
                            <thead>
                            <tr>
                                <th width="30%">Column</th>
                                <th>Value</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Contact Name</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->subject }}</td>
                                    <td>{{ $contact->message }}</td>
                                </tr>
        {{--                        <tr>--}}
        {{--                            <td></td>--}}
        {{--                            <td>{{ $contact->email }}</td>--}}
        {{--                            <td>{{ $contact->subject }}</td>--}}
        {{--                            <td>{{ $contact->message }}</td>--}}
        {{--                        </tr>--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin_def.layouts.modal')
@endsection

@push('lib-css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@push('lib-js')
    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endpush

@push('js')
    <script>
        $('#table-brand-details').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'columns'     : [
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
                {orderable: true},
            ],
            order: [0, 'desc'],
        });
        $('#btn-brand-edit').click(function(){
            $('.modal').modal('show');
        });
    </script>
@endpush
