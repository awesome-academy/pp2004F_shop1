<?php

if (! function_exists('vnd_format')) {
    function vnd_format($price, $quantity= 1, $multiply = 1000)
    {
        return number_format(($price * $quantity * $multiply), 0, ',', '.');
    }
}

if (! function_exists('getThumb')) {
    function getThumb($src) {
        return preg_replace('#(.*)(\/)(.*)$#', '$1/thumbs/$3', $src);
    }
}

if (! function_exists('view403')) {
    function view403()
    {
        return view('admin_def.pages.403');
    }
}

if (! function_exists('render_option')) {
    function render_option($option, $items = null, $old_value = null, $error = null)
    {
        switch ($option->type) {
            case 4: // type = textarea
                echo "<textarea name='option[{$option->key}]' class='form-control'>{$option->value}</textarea>";
                break;
            case 5: // type = image
                echo    "<div class='input-group'>
                            <div class='input-group-btn'>
                                <a data-input='{$option->key}' data-preview='{$option->key}_holder' class='btn-lfm btn btn-default text-white'>
                                    <i class='fa fa-picture-o'></i> Choose
                                </a>
                            </div>
                            <input id='{$option->key}' class='form-control' type='text' name='option[{$option->key}]' readonly
                                value='" . (!empty($old_value) ? $old_value : $option->value) . "'>
                        </div>
                        <div id='{$option->key}_holder' style='margin-top:15px; max-height:100px;'>
                            <img src='" . (!empty($old_value) ? $old_value : $option->value) . "' style='height: 6rem'>
                        </div>" .
                        ( !empty($error) ? 
                        "<div class='help-block'>
                            {$error}
                        </div>" : '' );
                break;
            case 6: // type = select
                $option_items = '';
                foreach ($items as $item) {
                    $select_att = ($item->key == $option->value) ? 'selected' : '';
                    $option_items .= "<option value='{$item->key}' {$select_att}>{$item->value}</option>";
                }
                echo    "<select name='option[$option->key]' class='form-control'>
                            <option value=''>--- Choose an option</option>
                            " . $option_items . "
                        </select>    
                        ";
                break;
            case 7: // type = checkbox
                if (!empty($option->value)) {
                    $selected = get_object_vars(json_decode($option->value));
                }
                foreach ($items as $item) {
                    $check_att = (!empty($selected) && in_array($item->value, $selected)) ? 'checked' : '';
                    echo    "<div class='col-xs-4'>
                                <input type='checkbox' name='option[$option->key][{$item->key}]' value='{$item->value}' id='{$item->key}' {$check_att}>
                                <label for='{$item->key}'>{$item->value}</label>
                            </div>
                            ";
                }
                break;
            default: // type = text
                echo "<input type='text' name='option[{$option->key}]' value='{$option->value}' class='form-control'>";
                break;
        }
    }
}
