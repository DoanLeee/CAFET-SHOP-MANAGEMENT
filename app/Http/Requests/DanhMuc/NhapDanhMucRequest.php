<?php

namespace App\Http\Requests\DanhMuc;

use Illuminate\Foundation\Http\FormRequest;

class NhapDanhMucRequest extends FormRequest
{
    public function authorize()
    {
        return True;
    }

    public function rules()
    {
        return [
            'ten_danh_muc'           => 'required|min:4|max:30',
            'slug_danh_muc'          => 'required|min:4|unique:danhmucs,slug_danh_muc',
            'tinh_trang_dm'             => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'ten_danh_muc.required'      => 'Vui lòng nhập tên danh mục',
            'ten_danh_muc.min'           => 'Tên danh_muc ít nhất 5 ký tự',
            'ten_danh_muc.max'           => 'Tên danh_muc tối đa 30 ký tự',
            'slug_danh_muc.required'     => 'yêu cầu nhập slug danh mục ',
            'tinh_trang_dm.required'     => 'Vui lòng nhập đúng tình trạng',
        ];
    }
}
