@extends('admin_master_def')

@section('title', '| Create New Product')

@section('content')
@php
    $scr_tech = "properties[1.screen][1.tech]";
    $scr_res = "properties[1.screen][2.resolution]";
    $scr_width = "properties[1.screen][3.width]";
    $main_cam_res = "properties[2.main_cam][1.resolution]";
    $main_cam_quality = "properties[2.main_cam][2.quality]";
    $main_cam_flash = "properties[2.main_cam][3.flash]";
    $main_cam_features = "properties[2.main_cam][4.features]";
    $front_cam_res = "properties[3.front_cam][1.resolution]";
    $front_cam_video_call = "properties[3.front_cam][2.video_call]";
    $front_cam_features = "properties[3.front_cam][3.features]";
    $hardware_os = "properties[4.hardware][1.os]";
    $hardware_chip = "properties[4.hardware][2.chipset]";
    $hardware_cpu = "properties[4.hardware][3.cpu]";
    $hardware_vga = "properties[4.hardware][4.vga]";
    $memory_ram = "properties[5.memory][1.ram]";
    $memory_rom = "properties[5.memory][2.rom]";
    $memory_card = "properties[5.memory][3.memory_card]";
    $physical_design = "properties[6.physical][1.design]";
    $physical_material = "properties[6.physical][2.material]";
    $physical_dimension = "properties[6.physical][3.dimension]";
    $physical_weight = "properties[6.physical][4.weight]";
    $battery_type = "properties[7.battery][1.type]";
    $battery_capacity = "properties[7.battery][2.capa]";
    $battery_tech = "properties[7.battery][3.tech]";
    $others_date_debut = "properties[8.others][1.date_debut]";
@endphp
<form action="{{ route('admin.product.store') }}" method="POST" class="clearfix">
    <div class="col-xs-12">
        <h3>Create New Product</h3>
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="box box-warning">
                    <div class="box-header">
                        <span class="lead">Product Primary Info</span>
                    </div>
                    <div class="box-body">
                        <div class="product-create">
                            @csrf
                            @method('POST')
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="" class="control-label">Product Name</label>
                                <input type="text" name="name" class="form-control" 
                                    @if(!empty(old('name'))) value="{{ old('name') }} @endif">
                                @error('name')
                                <div class="help-block">
                                    {{ $errors->first('name') }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group{{ $errors->has('product_code') ? ' has-error' : '' }}">
                                <label for="" class="control-label">Product Code</label>
                                <input type="text" name="product_code" class="form-control" 
                                    @if(!empty(old('product_code'))) value="{{ old('product_code') }} @endif">
                                @error('product_code')
                                <div class="help-block">
                                    {{ $errors->first('product_code') }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group{{ $errors->has('quantity_in_stock') ? ' has-error' : '' }}">
                                <label for="" class="control-label">Quantity in Stock</label>
                                <input type="number" name="quantity_in_stock" class="form-control" 
                                    @if(!empty(old('quantity_in_stock'))) value="{{ old('quantity_in_stock') }} @endif">
                                @error('quantity_in_stock')
                                <div class="help-block">
                                    {{ $errors->first('quantity_in_stock') }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group{{ $errors->has('excerpt') ? ' has-error' : '' }}">
                                <label for="" class="control-label">Excerpt</label>
                                <textarea name="excerpt" class="form-control" 
                                    rows="3">@if(!empty(old('excerpt'))) {{ old('excerpt') }} @endif</textarea>
                                @error('excerpt')
                                <div class="help-block">
                                    {{ $errors->first('excerpt') }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="" class="control-label">Description</label>
                                <textarea id="prod_description" name="description" class="form-control" 
                                    rows="30">@if(!empty(old('description'))) {{ old('description') }} @endif</textarea>
                                @error('description')
                                <div class="help-block">
                                    {{ $errors->first('description') }}
                                </div>
                                @enderror
                            </div>
                            <div class="row form-group{{ $errors->has('brand_id') ? ' has-error' : '' }}">
                                <label for="" class="control-label col-xs-12 col-md-3">Brand</label>
                                <div class="col-xs-12 col-md-9">
                                    <select name="brand_id" id="" class="form-control">
                                        <option value="">--- Please choose a Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" 
                                                @if(!empty(old('brand_id')) && $brand->id == old('brand_id')) {{ 'selected' }}@endif>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <div class="help-block">
                                        {{ $errors->first('brand_id') }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group{{ $errors->has('buy_price') ? ' has-error' : '' }}">
                                <label for="" class="control-label col-xs-12 col-md-3">Import Price</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="input-group">
                                        <input type="number" name="buy_price" class="form-control" min="0"
                                            @if(!empty(old('buy_price'))) value="{{ old('buy_price') }}" @endif>
                                        <div class="input-group-addon"><b>.000</b></div>
                                        <span class="input-group-addon">VNĐ</span>
                                    </div>
                                    @error('buy_price')
                                    <div class="help-block">
                                        {{ $errors->first('buy_price') }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group{{ $errors->has('current_price') ? ' has-error' : '' }}">
                                <label for="" class="control-label col-xs-12 col-md-3">Current Price</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="input-group">
                                        <input type="number" name="current_price" class="form-control" min="0"
                                            @if(!empty(old('current_price'))) value="{{ old('current_price') }}" @endif>
                                        <div class="input-group-addon"><b>.000</b></div>
                                        <span class="input-group-addon">VNĐ</span>
                                    </div>
                                    @error('current_price')
                                    <div class="help-block">
                                        {{ $errors->first('current_price') }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label class="control-label col-xs-12 col-md-3">Product Images</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-default text-white">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </div>
                                        <input id="thumbnail" class="form-control" type="text" name="image" readonly
                                            @if(!empty(old('image'))) value="{{ old('image') }}" @endif>
                                    </div>
                                    <div id="holder" style="margin-top:15px; max-height:100px;">
                                        @if(!empty(old('image'))) <img src="{{ old('image') }}" style="height: 6rem"> @endif
                                    </div>
                                    @error('image')
                                    <div class="help-block">
                                        {{ $errors->first('image') }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-md-9 col-md-offset-3">
                                    <button class="btn btn-lg btn-success"><i class="fa fa-save"></i> Create Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="box box-info">
                    <div class="box-header">
                        <span class="lead">Product Specs</span>
                    </div>
                    <div class="box-body">
                        <div class="row form-group{{ $errors->has("$scr_tech") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Screen tech</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$scr_tech}}" class="form-control" 
                                    @if(!empty(old("$scr_tech"))) value="{{ old("$scr_tech") }} @endif">
                                @error("$scr_tech")
                                <div class="help-block">
                                    {{ $errors->first("$scr_tech") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$scr_res") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Screen Resolution</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$scr_res}}" class="form-control" 
                                    @if(!empty(old("$scr_res"))) value="{{ old("$scr_res") }} @endif">
                                @error("$scr_res")
                                <div class="help-block">
                                    {{ $errors->first("$scr_res") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$scr_width") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Screen Width</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$scr_width}}" class="form-control" 
                                    @if(!empty(old("$scr_width"))) value="{{ old("$scr_width") }} @endif">
                                @error("$scr_width")
                                <div class="help-block">
                                    {{ $errors->first("$scr_width") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$main_cam_res") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Main Camera Resolution</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$main_cam_res}}" class="form-control" 
                                    @if(!empty(old("$main_cam_res"))) value="{{ old("$main_cam_res") }} @endif">
                                @error("$main_cam_res")
                                <div class="help-block">
                                    {{ $errors->first("$main_cam_res") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$main_cam_quality") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Main Camera Quality</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$main_cam_quality}}" class="form-control" 
                                    @if(!empty(old("$main_cam_quality"))) value="{{ old("$main_cam_quality") }} @endif">
                                @error("$main_cam_quality")
                                <div class="help-block">
                                    {{ $errors->first("$main_cam_quality") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$main_cam_flash") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Main Camera Flash</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$main_cam_flash}}" class="form-control" 
                                    @if(!empty(old("$main_cam_flash"))) value="{{ old("$main_cam_flash") }} @endif">
                                @error("$main_cam_flash")
                                <div class="help-block">
                                    {{ $errors->first("$main_cam_flash") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$main_cam_features") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Main Camera Features</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$main_cam_features}}" class="form-control" 
                                    @if(!empty(old("$main_cam_features"))) value="{{ old("$main_cam_features") }} @endif">
                                @error("$main_cam_features")
                                <div class="help-block">
                                    {{ $errors->first("$main_cam_features") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$front_cam_res") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Front Camera Resolution</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$front_cam_res}}" class="form-control" 
                                    @if(!empty(old("$front_cam_res"))) value="{{ old("$front_cam_res") }} @endif">
                                @error("$front_cam_res")
                                <div class="help-block">
                                    {{ $errors->first("$front_cam_res") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$front_cam_video_call") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Front Camera Video Call</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$front_cam_video_call}}" class="form-control" 
                                    @if(!empty(old("$front_cam_video_call"))) value="{{ old("$front_cam_video_call") }} @endif">
                                @error("$front_cam_video_call")
                                <div class="help-block">
                                    {{ $errors->first("$front_cam_video_call") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$front_cam_features") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Features</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$front_cam_features}}" class="form-control" 
                                    @if(!empty(old("$front_cam_features"))) value="{{ old("$front_cam_features") }} @endif">
                                @error("$front_cam_features")
                                <div class="help-block">
                                    {{ $errors->first("$front_cam_features") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$hardware_os") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Operator System</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$hardware_os}}" class="form-control" 
                                    @if(!empty(old("$hardware_os"))) value="{{ old("$hardware_os") }} @endif">
                                @error("$hardware_os")
                                <div class="help-block">
                                    {{ $errors->first("$hardware_os") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$hardware_chip") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Chipset</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$hardware_chip}}" class="form-control" 
                                    @if(!empty(old("$hardware_chip"))) value="{{ old("$hardware_chip") }} @endif">
                                @error("$hardware_chip")
                                <div class="help-block">
                                    {{ $errors->first("$hardware_chip") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$hardware_cpu") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">CPU</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$hardware_cpu}}" class="form-control" 
                                    @if(!empty(old("$hardware_cpu"))) value="{{ old("$hardware_cpu") }} @endif">
                                @error("$hardware_cpu")
                                <div class="help-block">
                                    {{ $errors->first("$hardware_cpu") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$hardware_vga") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">VGA</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$hardware_vga}}" class="form-control" 
                                    @if(!empty(old("$hardware_vga"))) value="{{ old("$hardware_vga") }} @endif">
                                @error("$hardware_vga")
                                <div class="help-block">
                                    {{ $errors->first("$hardware_vga") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$memory_ram") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Ram</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$memory_ram}}" class="form-control" 
                                    @if(!empty(old("$memory_ram"))) value="{{ old("$memory_ram") }} @endif">
                                @error("$memory_ram")
                                <div class="help-block">
                                    {{ $errors->first("$memory_ram") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$memory_rom") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Rom</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$memory_rom}}" class="form-control" 
                                    @if(!empty(old("$memory_rom"))) value="{{ old("$memory_rom") }} @endif">
                                @error("$memory_rom")
                                <div class="help-block">
                                    {{ $errors->first("$memory_rom") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$memory_card") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Memory Card</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$memory_card}}" class="form-control" 
                                    @if(!empty(old("$memory_card"))) value="{{ old("$memory_card") }} @endif">
                                @error("$memory_card")
                                <div class="help-block">
                                    {{ $errors->first("$memory_card") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$physical_design") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Design</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$physical_design}}" class="form-control" 
                                    @if(!empty(old("$physical_design"))) value="{{ old("$physical_design") }} @endif">
                                @error("$physical_design")
                                <div class="help-block">
                                    {{ $errors->first("$physical_design") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$physical_material") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Material</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$physical_material}}" class="form-control" 
                                    @if(!empty(old("$physical_material"))) value="{{ old("$physical_material") }} @endif">
                                @error("$physical_material")
                                <div class="help-block">
                                    {{ $errors->first("$physical_material") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$physical_dimension") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Dimension</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$physical_dimension}}" class="form-control" 
                                    @if(!empty(old("$physical_dimension"))) value="{{ old("$physical_dimension") }} @endif">
                                @error("$physical_dimension")
                                <div class="help-block">
                                    {{ $errors->first("$physical_dimension") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$physical_weight") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Weight</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$physical_weight}}" class="form-control" 
                                    @if(!empty(old("$physical_weight"))) value="{{ old("$physical_weight") }} @endif">
                                @error("$physical_weight")
                                <div class="help-block">
                                    {{ $errors->first("$physical_weight") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$battery_type") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Type</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$battery_type}}" class="form-control" 
                                    @if(!empty(old("$battery_type"))) value="{{ old("$battery_type") }} @endif">
                                @error("$battery_type")
                                <div class="help-block">
                                    {{ $errors->first("$battery_type") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$battery_capacity") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Capacity</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$battery_capacity}}" class="form-control" 
                                    @if(!empty(old("$battery_capacity"))) value="{{ old("$battery_capacity") }} @endif">
                                @error("$battery_capacity")
                                <div class="help-block">
                                    {{ $errors->first("$battery_capacity") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$battery_tech") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">tech</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$battery_tech}}" class="form-control" 
                                    @if(!empty(old("$battery_tech"))) value="{{ old("$battery_tech") }} @endif">
                                @error("$battery_tech")
                                <div class="help-block">
                                    {{ $errors->first("$battery_tech") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group{{ $errors->has("$others_date_debut") ? ' has-error' : '' }}">
                            <label for="" class="control-label col-xs-12 col-lg-4">Date Debut</label>
                            <div class="col-xs-12 col-lg-8">
                                <input type="text" name="{{$others_date_debut}}" class="form-control" 
                                    @if(!empty(old("$others_date_debut"))) value="{{ old("$others_date_debut") }} @endif">
                                @error("$others_date_debut")
                                <div class="help-block">
                                    {{ $errors->first("$others_date_debut") }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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
        CKEDITOR.replace('prod_description', {
            height: 450,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}'
        });
        $('#lfm').filemanager('image', {prefix: route_prefix});
    </script>
@endpush
