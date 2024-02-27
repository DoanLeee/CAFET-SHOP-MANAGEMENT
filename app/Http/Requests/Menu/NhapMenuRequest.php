<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class NhapMenuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ten_mon'       =>'required|min:5|max:30',
            'slug_mon'      =>'required|min:5|unique:menus,slug_mon',
            'gia_ban'       =>'required|numeric|min:0',
            'id_danh_muc'   =>'required|exists:danhmucs,id',
            // 'hinh_anh'      =>'required|mimes:png,jpg',
            'hinh_anh'      =>'required',
            'tinh_trang_m'      => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'ten_mon.required'  => 'vui lòng nhập tên món',
            'ten_mon.min'       => 'tên món ít nhất 5 ký tự',
            'ten_mon.max'       => 'tên món tối đa 30 ký tự',
            'slug_mon.*'        => 'Slug đã tồn tại !',
            'gia_ban.*'         => 'giá bán ít nhất 0 đồng',
            'id_danh_muc.*'     => 'Vui lòng chọn danh mục !',
            'hinh_anh.*'        => 'Vui lòng chọn hình ảnh !',
            'tinh_trang_m.*'         => 'vui lòng chọn tình trạng theo yêu cầu !',
        ];
    }
}
