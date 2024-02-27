<?php

namespace App\Http\Requests\KhuVuc;

use Illuminate\Foundation\Http\FormRequest;

class NhapKhuVucRequest extends FormRequest
{
    public function authorize()
    {
        return True;
    }

    public function rules()
    {
        return [
            'ten_khu'           => 'required|min:4|max:30',
            'slug_khu'          => 'required|min:4|unique:khuvucs,slug_khu',
            'tinh_trang_kv'     => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'ten_khu.required'         => 'Vui lòng nhập tên khu vực',
            'ten_khu.min'              => 'Tên khu ít nhất 5 ký tự',
            'ten_khu.max'              => 'Tên khu tối đa 30 ký tự',
            'slug_khu.required'        => 'Vui lòng nhập slug khu vực',
            'tinh_trang_kv.required'   => 'Vui lòng nhập đúng tình trạng',
        ];
    }
}

