<?php

namespace App\Support\Form;

class FileForm implements IForm
{
    public static function render($name, $data, $params)
    {
        return view('support.form.file', [
            'name'   => $name,
            'accept' => @$data->accept,
        ]);
    }
}