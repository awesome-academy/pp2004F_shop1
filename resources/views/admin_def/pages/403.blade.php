@extends('admin_master_def')

@section('title', '| Forbidden 403')

@section('content')
<section class="content">
    <div class="error-page">
        <h2 class="headline text-danger"> 403</h2>
        <div class="error-content" style="transform: translateY(38px)">
            <h3><i class="fa fa-warning text-danger"></i> Oops! Forbidden Content.</h3>
            <p>
                Permission denied! You do not have permission to do this action.
                Meanwhile, you may <a href="{{ url('admin') }}">return to dashboard</a>.
            </p>
        </div>
    </div>
</section>
@endsection
