@extends('admin_master_def')

@section('title', '| Brand List')

@section('content')
    <div class="col-xs-12">
        <h3>Contact List</h3>
        <div class="row">
            <div class="col-xs-12 col-md-9">
                <div class="box box-warning">
                    <div class="box-body">
                        <table id="table-contacts" class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th width="50px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->subject }}</td>
                                    <td>{{ $contact->message }}</td>
                                    <td>
                                        <a href="{{ route('admin.contact.show', $contact->id) }}" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
{{--            <div class="col-xs-12 col-md-3">--}}
{{--                <div class="box box-default">--}}
{{--                    <div class="box-header">--}}
{{--                        <p class="lead">Add New Contact</p>--}}
{{--                    </div>--}}
{{--                    <div class="box-body">--}}
{{--                        <form action="{{ route('admin.contact.store') }}" method="POST">--}}
{{--                            @csrf--}}
{{--                            @method('POST')--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="" class="control-label">Contact Name</label>--}}
{{--                                <input type="text" name="name" id="" class="form-control">--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Add Contact</button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
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
        $('#table-brands').DataTable({
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
                {orderable: false},
            ],
            order: [1, 'desc'],
        });
    </script>
@endpush
