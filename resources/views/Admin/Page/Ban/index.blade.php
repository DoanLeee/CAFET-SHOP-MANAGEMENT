@extends('admin.share.master')
@section('noi_dung')
    <div class="container">
        <div class="row" id="app">

            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Bàn</li>
                    </ol>
                </nav>
              </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh Sách Bàn</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#themmoiban"><i class="fa-solid fa-plus"></i> Thêm Mới</button>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table table-bordered border-primary">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Bàn</th>
                                    <th class="text-center">Slug Bàn</th>
                                    <th class="text-center">Khu Vực</th>
                                    <th class="text-center">Tình Trạng</th>
                                    <th class="text-center">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in data">
                                    <tr>
                                        <th class=" align-middle text-center">@{{ key + 1}}</th>
                                        <td class=" align-middle text-center">@{{ value.ten_ ban}}</th>
                                        <td class=" align-middle text-center">@{{ value.slug_ban}}</th>
                                        <td class=" align-middle text-center">@{{ value.ten_khu}}</th>
                                        <td class=" align-middle text-center">
                                            <i v-on:click="doitinhtrang(value)" v-if="value.tinh_trang_b ==0" class="fa-solid fa-eye-slash maudo" style="font-size: 20px;"></i>
                                            <i v-on:click="doitinhtrang(value)" v-else class="fa-solid fa-eye mauxanh"  style="font-size: 20px;"></i>
                                        </td>
                                        <td class="align-middle text-center">
                                            <i v-on:click="capnhap_ban = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#capnhapban" class="fa-solid fa-pen-to-square mauxanh" style="font-size: 1.2em;"></i>
                                            <i v-on:click="xoa_ban = value" data-bs-toggle="modal" data-bs-target="#xoaban" class="fa-solid fa-trash maudo" style="font-size: 1.2em;"></i> </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- -------------------------------- --}}
                    <div class="modal fade" id="themmoiban" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Mới Bàn </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tên Bàn</label>
                                        <input v-model="add_ban.ten_ban" v-on:keyup="createSlug()"  v-on:blur="checkSlug()" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Slug Bàn</label>
                                        <input v-model="add_ban.slug_ban" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tên Khu</label>
                                        <select v-model="add_ban.id_khu_vuc" class="form-control">
                                            <option value="0">vui lòng chọn khu vực</option>
                                            @foreach ( $khuvuc as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->ten_khu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        {{-- Switches --}}
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-check-label" >Tình Trạng</label>
                                            </div>
                                            <div class="col-8" style="font-size: 1.5rem">
                                                <div class="form-check form-switch">
                                                    <i v-if="add_ban.tinh_trang_b" class="fa-solid fa-eye mauxanh"  style="font-size: 20px;"></i>
                                                    <input class="form-check-input" type="checkbox" v-model="add_ban.tinh_trang_b">
                                                    <i class="fa-solid fa-eye-slash maudo" v-if="!add_ban.tinh_trang_b" style="font-size: 20px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                    <button id="add" v-on:click="themban()" type="button" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- -------------------------------- --}}
                    <div class="modal fade" id="xoaban" tabindex="-1" aria-labelledby="exampleModalLabel"aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Bàn</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="id_delete">
                                    <div class="alert alert-primary" role="alert">
                                        Bạn Có Chắc Muốn Xóa : <b class="text-danger text-uppercase"> @{{ xoa_ban.ten_ban }} </b> này không
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="xoa()">xác nhận xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- -------------------------------- --}}
                    <div class="modal fade" id="capnhapban" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhập Khu Vực</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="mt-3">Tên Bàn</label>
                                    <input v-model="capnhap_ban.ten_ban" v-on:keyup="createSlugedit()"class="form-control mt-1" type="text">
                                    <label class="mt-3">Slug Bàn</label>
                                    <input v-model="capnhap_ban.slug_ban" class="form-control mt-1" type="text">
                                    <label class="mt-3">Khu Vực</label>
                                    <input v-model="capnhap_ban.ten_khu" class="form-control mt-1" type="text">
                                    <div class="mt-3">
                                        {{-- Switches --}}
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-check-label">Tình Trạng</label>
                                            </div>
                                            <div class="col-8" style="font-size: 1.5rem">
                                                <div class="form-check form-switch">
                                                    <i v-if="capnhap_ban.tinh_trang_b" class="fa-solid fa-eye mauxanh" style="font-size: 20px;"></i>
                                                    <input class="form-check-input " type="checkbox" v-model="capnhap_ban.tinh_trang_b">
                                                    <i class="fa-solid fa-eye-slash maudo" v-if="!capnhap_ban.tinh_trang_b" style="font-size: 20px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                    <button type="button" class="btn btn-danger" v-on:click="capnhap()" >Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: "#app",
            data: {
                data: [],
                add_ban : {
                    'ten_ban': '',
                    'slug_ban': '',
                    'id_khu_vuc': 0,
                    "tinh_trang_b": 1 ,
                    "trang_thai": 0
                },
                xoa_ban : {},
                capnhap_ban : {},
            },
            created() {
                this.loadData();
            },
            methods: {

                loadData() {
                    axios
                        .get('{{ Route('databan') }}')
                        .then((res) => {
                            this.data = res.data.data;
                        });
                },

                //----Thêm bàn-----------
                themban() {
                    axios
                        .post('{{ Route('nhapban') }}', this.add_ban)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.add_ban = {
                                        'ten_ban': '',
                                        'slug_ban': '',
                                        'id_khu_vuc': 0,
                                        "tinh_trang_b": 1 ,
                                        "trang_thai": 0 ,
                                        "hinh_anh": '' ,
                                    },
                                $('#themmoiban').modal('hide');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "warning");
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors , function(k,v){
                                toastr.error(v[0]);
                            })
                            $('#add').removeAttr('disabled');
                        });
                },
                //----checkslug-----------
                createSlug() {
                    var slug = this.toSlug(this.add_ban.ten_ban);
                    this.add_ban.slug_ban = slug;
                },
                toSlug(str) {
                    str = str.toLowerCase();
                    str = str
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '');
                    str = str.replace(/[đĐ]/g, 'd');
                    str = str.replace(/([^0-9a-z-\s])/g, '');
                    str = str.replace(/(\s+)/g, '-');
                    str = str.replace(/-+/g, '-');
                    str = str.replace(/^-+|-+$/g, '');
                    return str;
                },

                //----đổi tình trạng-----------
                doitinhtrang(abcxyz) {
                    axios
                        .post('{{ Route('tinhtrangban') }}', abcxyz)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "error");
                            }
                        });
                },
                //------Xóa -----
                xoa() {
                    axios
                        .post('{{ Route('xoaban') }}', this.xoa_ban)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message);
                            }
                        });
                },
                //------cập nhập -----
                capnhap() {
                    axios
                        .post('{{ Route('capnhapban') }}', this.capnhap_ban)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                                $('#capnhapban').modal('hide');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            })
                            $("#add").removeAttr("disabled");
                        });
                },
                createSlugedit() {
                    var slug = this.toSlug(this.capnhap_ban.ten_ban);
                    this.capnhap_ban.slug_ban = slug;
                },

                //------checkSlug-----------
                checkSlug() {
                    var payload = {
                        'slug_ban': this.add_ban.slug_ban
                    };
                    axios
                        .post('{{ Route('checkslugban') }}', payload)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message);
                                $("#add").removeAttr("disabled");
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                                $("#add").prop("disabled", true);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message);
                            }
                        });
                },
            }
        });
    </script>
@endsection
