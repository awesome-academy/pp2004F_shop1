@extends('admin_master_def')

@section('title', '| Options')

@section('content')
<div class="clearfix">
    <div class="col-xs-12">
        <h3>Options</h3>
    </div>
    <div class="col-xs-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @if (!empty($groups))
                @foreach ($groups as $group)
                <li @if ($loop->index == 0) {{ 'class=active' }} @endif><a href="#tab_{{ $group->id }}" data-toggle="tab" aria-expanded="true"><span class="lead">{{ __($group->key) }}</span></a></li>
                @endforeach
                @endif
            </ul>
            <div class="tab-content">
                @if (!empty($groups))
                @foreach ($groups as $group)
                <div class="tab-pane{{ $loop->index == 0 ? ' active' : '' }}" id="tab_{{ $group->id }}">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">Option Key</th>
                                <th>Value</th>
                                <th width="100px"></th>
                            </tr>
                            @if (!empty($options))
                            @foreach ($options->where('parent_id', $group->id) as $key => $option)
                            <tr>
                                <th width="30%">{{ __($option->key) }}</th>
                                <td>@if ($option->type == $types['image'])
                                    <img src="{{ $option->value }}" class="img-thumbnail" style="max-width: 160px">
                                    @elseif ($option->type == $types['select'])
                                        {{ $options->where('key', $option->value)->first()->value }}
                                    @elseif ($option->type == 7)
                                        @php
                                            $items = json_decode($option->value);
                                        @endphp
                                        <div class="row">
                                        @foreach($items as $key => $value)
                                            <div class="col-xs-4">
                                                <i class="fa fa-check-square text-green"></i> {{ $value }}
                                            </div>
                                        @endforeach
                                        </div>
                                    @else
                                        {{ __($option->value) }}
                                    @endif
                                </td>
                                <td><a href="{{ route('admin.option.alter', $option->id) }}" class="btn btn-default btn-sm">Alter Option</a></td>
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
                <a href="{{ route('admin.option.edit') }}" class="btn btn-lg btn-warning"><i class="fa fa-edit"></i> Edit Options</a>
            </div>
        </div>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="box box-default">
            <div class="box-header">
                <span class="lead">Create New Option</span>
            </div>
            <div class="box-body">
                <form action="{{ route('admin.option.store') }}" method="POST">
                    @csrf
                    @method("POST")
                    <div class="form-group">
                        <label for="" class="label-control">Option Key</label>
                        <input type="text" name="key" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="label-control">Choose an Option Type</label>
                        <select name="type" id="select-option-type" class="form-control">
                            <option value="">--- Choose an Option Type</option>
                            @if (!empty($types))
                                @foreach ($types as $key_type => $type)
                                <option value="{{$type}}">{{ ucwords($key_type) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group hidden">
                        <label for="" class="label-control">Choose an Option Group</label>
                        <select name="option_group" id="select-option-group" class="form-control">
                            <option value="">--- Choose an Option group</option>
                            @if (!empty($groups))
                            @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ __($group->key) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create Option</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(function(){
            $('#select-option-type').on('change', function(){
                $selectOptionGroup = $('#select-option-group');
                $selectOptionGroup.val(null);
                if ($(this).val() == 1) {
                    $selectOptionGroup.parent().removeClass('hidden');
                } else {
                    $selectOptionGroup.parent().addClass('hidden');
                }
            });
        });
    </script>
@endpush
