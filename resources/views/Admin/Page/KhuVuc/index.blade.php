@extends('admin.share.master')
@section('noi_dung')
    <div class="container">
        <div class="row" id="app">
            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Khu Vực</li>
                    </ol>
                </nav>
              </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh Sách Khu Vực</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#themmoikhuvuc"><i class="fa-solid fa-plus"></i> Thêm Mới</button>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table table-bordered border-primary">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Khu</th>
                                    <th class="text-center">Slug Khu</th>
                                    <th class="text-center">Tình Trạng</th>
                                    <th class="text-center">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in data">
                                    <tr>
                                        <th class=" align-middle text-center">@{{ key + 1 }}</th>
                                        <td class=" align-middle text-center">@{{ value.ten_khu}}</td>
                                        <td class=" align-middle text-center">@{{ value.slug_khu}}</td>
                                        <td class=" align-middle text-center">
                                            <i v-on:click="doitinhtrang(value)" class="fa-solid fa-eye-slash maudo" v-if="value.tinh_trang_kv == 0" style="font-size: 20px;"></i>
                                            <i v-on:click="doitinhtrang(value)" class="fa-solid fa-eye mauxanh" v-else style="font-size: 20px;"></i>
                                        </td>
                                        <td class="align-middle text-center">
                                            <i v-on:click="capnhap_khu_vuc = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#capnhapkhuvuc" class="fa-solid fa-pen-to-square mauxanh" style="font-size: 1.2em;"></i>
                                            <i v-on:click="del_khu_vuc = value" data-bs-toggle="modal" data-bs-target="#xoakhuvuc" class="fa-solid fa-trash maudo" style="font-size: 1.2em;"></i> </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- -------------------------------- --}}
                    <div class="modal fade" id="themmoikhuvuc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Mới Khu Vực</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tên Khu Vực</label>
                                        <input v-model="add_khu_vuc.ten_khu" v-on:keyup="createSlug()" v-on:blur="checkSlug()" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Slug Khu Vực</label>
                                        <input v-model="add_khu_vuc.slug_khu" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        {{-- Switches --}}
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-check-label" >Tình Trạng</label>
                                            </div>
                                            <div class="col-8" style="font-size: 1.5rem">
                                                <div class="form-check form-switch">
                                                    <i v-if="add_khu_vuc.tinh_trang_kv" class="fa-solid fa-eye mauxanh"  style="font-size: 20px;"></i>
                                                    <input class="form-check-input" type="checkbox" v-model="add_khu_vuc.tinh_trang_kv">
                                                    <i class="fa-solid fa-eye-slash maudo" v-if="!add_khu_vuc.tinh_trang_kv" style="font-size: 20px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                    <button id="add" v-on:click="themkhuvuc()" type="button" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- -------------------------------- --}}
                    <div class="modal fade" id="xoakhuvuc" tabindex="-1" aria-labelledby="exampleModalLabel"aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Khu Vực</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="id_delete">
                                    <div class="alert alert-primary" role="alert">
                                        Bạn Có Chắc Muốn Xóa : <b class="text-danger text-uppercase"> @{{ del_khu_vuc.ten_khu }} </b> này không
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
                    <div class="modal fade" id="capnhapkhuvuc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhập Khu Vực</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="mt-3">Tên Khu</label>
                                    <input v-model="capnhap_khu_vuc.ten_khu"  v-on:keyup="createSlugedit()" class="form-control mt-1" type="text">
                                    <label class="mt-3">Slug Khu</label>
                                    <input v-model="capnhap_khu_vuc.slug_khu" class="form-control mt-1" type="text">

                                    <div class="mt-3">
                                        {{-- Switches --}}
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-check-label">Tình Trạng</label>
                                            </div>
                                            <div class="col-8" style="font-size: 1.5rem">
                                                <div class="form-check form-switch">
                                                    <i v-if="capnhap_khu_vuc.tinh_trang_kv" class="fa-solid fa-eye mauxanh" style="font-size: 20px;"></i>
                                                    <input class="form-check-input " type="checkbox" v-model="capnhap_khu_vuc.tinh_trang_kv">
                                                    <i class="fa-solid fa-eye-slash maudo" v-if="!capnhap_khu_vuc.tinh_trang_kv" style="font-size: 20px;"></i>
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
                
                add_khu_vuc: {
                    'ten_khu': '',
                    'slug_khu': '',
                    'tinh_trang_kv': 1
                },
                del_khu_vuc: {},
                capnhap_khu_vuc: {},
            },
            created() {
                this.loadData();
            },
            methods: {

                loadData() {
                    axios
                        .get('{{ Route('datakhuvuc') }}')
                        .then((res) => {
                            this.data = res.data.data;
                        });
                },

                //----Thêm Khu Vực-----------
                themkhuvuc() {
                    axios
                        .post('{{ Route('nhapkhuvuc') }}', this.add_khu_vuc)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message);
                                this.loadData();
                                this.add_khu_vuc = {
                                    'ten_khu': '',
                                    'slug_khu': '',
                                    'tinh_trang_kv': 1
                                    },
                                $('#themmoikhuvuc').modal('hide');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message);
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
                    var slug = this.toSlug(this.add_khu_vuc.ten_khu);
                    this.add_khu_vuc.slug_khu = slug;
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
                        .post('{{ Route('tinhtrangkhuvuc') }}', abcxyz)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                            }
                        });
                },

                //------Xóa -----
                xoa() {
                    axios
                        .post('{{ Route('xoakhuvuc') }}', this.del_khu_vuc)
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
                        .post('{{ Route('capnhapkhuvuc') }}', this.capnhap_khu_vuc)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                                $('#capnhapkhuvuc').modal('hide');
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
                    var slug = this.toSlug(this.capnhap_khu_vuc.ten_khu);
                    this.capnhap_khu_vuc.slug_khu = slug;
                },

                //------checkSlug-----------
                checkSlug() {
                    var payload = {
                        'slug_khu': this.add_khu_vuc.slug_khu
                    };
                    axios
                        .post('{{ Route('checkslugkhuvuc') }}', payload)
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
