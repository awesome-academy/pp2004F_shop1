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
        <div class="col-xs-6">
            <form action="{{ route('admin.option.save', $option->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="option-alter">
                    <div class="box box-warning">
                        <div class="box-header"><span class="lead">Alter Option: {{ __($option->key) }}</span></div>
                        <div class="box-body">
                            @if (! in_array($option->type, [6, 7]))
                            <div class="form-group">
                                <h4 for="" class="control-label">Choose option type</h4>
                                <select name="type" id="option_type" class="form-control">
                                    <option value="">--- Choose an option type</option>
                                    @forelse ($types as $key => $type)
                                    @if ($key == 'select' || $key == 'checkbox') @continue @endif
                                    <option value="{{ $type }}" {{ $type == $option->type ? 'selected' : '' }}>{{ ucwords($key) }}</option>
                                    @empty
                                    <option value="">There is no option</option>
                                    @endforelse
                                </select>
                            </div>
                            @else
                            <div class="form-group" id="add-option">
                                <div class="clearfix">
                                    <h4 class="pull-left">Add more option item</h4>
                                    <a class="btn btn-primary pull-right btn-add-option-item"><i class="fa fa-plus"></i> Add an Item</a>
                                </div>
                                <div class="option-wrapper">
                                    @if (!empty($items))
                                        @foreach($items as $key => $item)
                                            @php
                                                $id = $loop->index + 1;
                                            @endphp
                                            <div class="row option-item">
                                                <div class="col-xs-6">
                                                    <label for="">Option Title {{ $id }}</label>
                                                    <input type="text" value="{{ $item->value }}" class="form-control" readonly>
                                                </div>
                                                <div class="col-xs-6">
                                                    <label for="">Option Value {{ $id }}</label>
                                                    <input type="text" value="{{ $item->key }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Change</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function(){
            $('#option_type').on('change', function(){
                if ($(this).val() == 6 || $(this).val() == 7) {
                    $('#add-option').removeClass('hidden');
                } else {
                    $('#add-option').addClass('hidden');
                }
            });

            $('.btn-add-option-item').click(function(){
                var pos = $('.option-item').length + 1;
                $item =     "<div class='row option-item'>" +
                                "<div class='col-xs-6'>" +
                                    "<label for=''>Option Title " + pos + "</label>" +
                                    "<input type='text' name='new[" + pos + "][title]' class='form-control'>" +
                                "</div>" +
                                "<div class='col-xs-6'>" +
                                    "<label for=''>Option Value " + pos + "</label>" +
                                    "<input type='text' name='new[" + pos + "][value]' class='form-control'>" +
                                "</div>" +
                            "</div>";
                $('.option-wrapper').append($item);
            });
        });
    </script>
@endpush
