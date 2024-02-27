@extends('admin.share.master')
@section('noi_dung')
    <div class="container">
        <div class="row" id="app">
            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Pha Chế</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh Sách Các Món Cần Pha Chế</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Launch demo modal
                          </button>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table table-bordered border-primary">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">#</th>
                                    <th class="text-center align-middle">Tên Món Ăn</th>
                                    <th class="text-center align-middle">Số Lượng</th>
                                    <th class="text-center align-middle">Tên Bàn</th>
                                    <th class="text-center align-middle">Ghi Chú</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in dataphache">
                                    <tr>
                                        <th class="text-center align-middle">@{{ key + 1 }}</th>
                                        <td class="text-center align-middle">@{{ value.ten_mon }}</td>
                                        <td class="text-center align-middle">@{{ value.so_luong_ban }}</td>
                                        <td class="text-center align-middle">@{{ value.ten_ban }}</td>
                                        <td class="text-center align-middle">@{{ value.ghi_chu }}</td>
                                        <td class="text-center align-middle">
                                            <button v-on:click="Done(value)" class="btn btn-primary">Xong</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            new Vue({
                el: '#app',
                data: {
                    dataphache: [],
                },
                created() {
                    setInterval(() => {
                        this.loadData();
                    }, 2000);

                },
                methods: {

                    Done(value) {
                        axios
                            .post('{{ Route('capnhapphache') }}', value)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message);
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                })
                            });
                    },
                    loadData() {
                        axios
                            .get('{{ Route('dataphache') }}')
                            .then((res) => {
                                this.dataphache = res.data.data;
                            });
                    },

                },
            });
        });
    </script>
@endsection
