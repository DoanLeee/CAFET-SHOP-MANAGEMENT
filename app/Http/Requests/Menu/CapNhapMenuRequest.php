<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class CapNhapMenuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                =>  'required|exists:menus,id',
            'ten_mon'           =>  'required|min:5|max:30',
            'slug_mon'          =>  'required|min:5|unique:menus,slug_mon,' . $this->id,
            'gia_ban'           =>  'required|numeric|min:0',
            'tinh_trang_m'      =>  'required|boolean',
            'id_danh_muc'       =>  'required|exists:danhmucs,id',
            'hinh_anh'          =>  'required',
        ];
    }

    public function messages()
    {
        return [
            'id.*'              =>  'menu không tồn tại!',
            'ten_mon.required'  =>  'Yêu cầu phải nhập tên món',
            'ten_mon.min'       =>  'Tên món phải từ 5 ký tự',
            'ten_mon.max'       =>  'Tên món tối đa được 30 ký tự',
            'slug_mon.*'        =>  'Slug món đã tồn tại!',
            'gia_ban.*'         =>  'Giá bán ít nhất là 0đ',
            'tinh_trang_m.*'    =>  'Vui lòng chọn tình trạng theo yêu cầu!',
            'id_danh_muc.*'     =>  'Danh mục không tồn tại trong hệ thống!',
            'hinh_anh.*'        => 'Vui lòng chọn hình ảnh !',
        ];
    }
}
