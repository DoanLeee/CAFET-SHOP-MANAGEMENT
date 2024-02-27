<?php

namespace App\Http\Requests\Ban;

use Illuminate\Foundation\Http\FormRequest;

class CapNhapBanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                => 'required|exists:bans,id',
            'ten_ban'           => 'required|min:1|max:30',
            'slug_ban'          => 'required|min:1|unique:bans,slug_ban,' .$this->id,
            'id_khu_vuc'        => 'required|exists:khuvucs,id',
            'tinh_trang_b'      => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'id.*'                   => 'Bàn không tồn tại',
            'ten_ban.required'       => 'Vui lòng nhập tên bàn',
            'ten_ban.min'            => 'Tên bàn ít nhất 1 ký tự ',
            'ten_ban.max'            => 'Tên bàn tối đa 30 ký tự ',
            'slug_ban.*'             => 'Slug đã tồn tại',
            'id_khu_vuc.*'           => 'Vui lòng chọn khu vực',
            'tinh_trang_b.*'         => 'vui lòng chọn tình trạng theo yêu cầu !',
        ];
    }
}
