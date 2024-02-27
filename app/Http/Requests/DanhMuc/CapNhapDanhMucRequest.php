<?php

namespace App\Http\Requests\DanhMuc;

use Illuminate\Foundation\Http\FormRequest;

class CapNhapDanhMucRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                =>  'required|exists:danhmucs,id',
            'ten_danh_muc'      =>  'required|min:3|max:30',
            'slug_danh_muc'     =>  'required|min:4|unique:danhmucs,slug_danh_muc,' .$this->id,
            'tinh_trang_dm'        =>  'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'id.*'                   =>  'Danh mục không tồn tại!',
            'ten_danh_muc.required'  =>  'Yêu cầu phải nhập tên danh mục',
            'ten_danh_muc.min'       =>  'Tên danh mục phải từ 3 ký tự',
            'ten_danh_muc.max'       =>  'Tên danh mục tối đa được 30 ký tự',
            'slug_danh_muc.required' =>  'Slug danh muc đã tồn tại ',
            'tinh_trang_dm.*'           =>  'Vui lòng chọn tình trạng theo yêu cầu!',
        ];
    }
}
