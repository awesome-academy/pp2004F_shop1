@extends('admin_master_def')

@section('title', '| Options')

@section('content')
    <div class="options clearfix">
        <div class="col-xs-12">
            <h3>Options
                <span class="btn-group pull-right">
                    <a href="{{ route('admin.option.index') }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Back</a>
                </span>
            </h3>
        </div>
        <div class="col-xs-8">
            <form action="{{ route('admin.option.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @if (!empty($groups))
                            @foreach ($groups as $group)
                                <li @if ($loop->index == 0) {{ 'class=active' }} @endif><a href="#tab_{{ $group->id }}" 
                                    data-toggle="tab" aria-expanded="true"><span class="lead">{{ __($group->key) }}</span></a></li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="tab-content">
                        @if (!empty($groups))
                            @foreach ($groups as $group)
                                @if ($loop->index == 0)
                                    <div class="tab-pane{{ $loop->index == 0 ? ' active' : '' }}" id="tab_{{ $group->id }}">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Option Key</th>
                                                <th>Value</th>
                                            </tr>
                                            @if (count($options) > 0)
                                            @foreach($options as $option)
                                                @php
                                                    $option_items = ($option->type === 6 || $option->type === 7) ? $items->where('parent_id', $option->id) : null;
                                                @endphp
                                            <tr>
                                                <td>{{ __($option->key) }}</td>
                                                <td>{{ render_option($option, $option_items, null, null) }}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                @continue
                                @endif
                                <div class="tab-pane{{ $loop->index == 0 ? ' active' : '' }}" id="tab_{{ $group->id }}">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Option Key</th>
                                                <th>Value</th>
                                            </tr>
                                            @if (!empty($options))
                                                @foreach ($options->where('option_group', $group->id) as $key => $option)
                                                    <tr>
                                                        <th>{{ __($option->key) }}</th>
                                                        <td><input type="text" name="" class="form-control" value="{{ $group->value }}"></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="clearfix" style="padding-bottom: 30px">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-save"></i> Update Options</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
  <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/72px color.png') }}">
@endpush

@push('lib-js')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script>
        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}
    </script>
@endpush

@push('js')
     <script>
        var route_prefix = "/filemanager";
        $('.btn-lfm').filemanager('image', {prefix: route_prefix});
    </script>
@endpush
