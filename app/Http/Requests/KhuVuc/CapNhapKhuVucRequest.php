<?php

namespace App\Http\Requests\KhuVuc;

use Illuminate\Foundation\Http\FormRequest;

class CapNhapKhuVucRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'id'                => 'required|exists:khuvucs,id',
            'ten_khu'           => 'required|min:4|max:30',
            'slug_khu'          => 'required|min:4|unique:khuvucs,slug_khu,' .$this->id,
            'tinh_trang_kv'     => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                     => 'Khu vực không tồn tại',
            'ten_khu.required'         => 'Vui lòng nhập tên khu vực',
            'ten_khu.min'              => 'Tên khu ít nhất 5 ký tự',
            'ten_khu.max'              => 'Tên khu tối đa 30 ký tự',
            'slug_khu.required'        => 'Slug khu đã tồn tại ',
            'tinh_trang_kv.required'   => 'Vui lòng nhập đúng tình trạng',
        ];
    }
}
