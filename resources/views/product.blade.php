@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-4">
                    <a href="{{url('product/add')}}" class="btn btn-block btn-success"><i class="fa fa-plus"></i> Tambah Produk</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Product List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('script')
<script>
    var dataTable = $('#dataTable').DataTable( {
        "responsive": true,
        "lengthChange": false, 
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "serverSide": "true",
        "processing": "true",
        "ordering": false,
        "searching": false,
        "autoWidth": true,
        "ajax": {
            "url": baseUrl + "/product/get-datatables",
            "type": "GET",
            "datatype": "JSON",
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // "data": function ( d ) {
            //       d.consulting_service_id = $('#categorySearch').val();
            //       d.date = $('#dateSearch').val();
            //       d.published_status = $('#statusSearch').val();
            // }
        },
        "columns": [
            { "data": "DT_RowIndex", "name": "DT_RowIndex" },
            { "data": "nama", "name": "nama","defaultContent": "NULL" },
            { "data": "deskripsi", "name": "deskripsi","defaultContent": "NULL" },
            { "data": "harga", "name": "harga","defaultContent": "NULL" },
            { "data": "status", "name": "status",
                render: function (data, type, row) {
                    if (data == "0") {
                        return 'Tidak Aktif';
                    }
                    if (data == "1") {
                        return 'Aktif';
                    }
                }
            },
            { "data": 'actions', "name": 'actions', "searchable": false, "orderable": false, "sClass":"text-center", "width": '100'},
        ]
    })

    $(document).on("click", "#btnDelete", function(e){
            let dataId = $(this).data("id");
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang sudah terhapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed){
                    $.ajax({
                        type:'DELETE',
                        url: baseUrl + '/product/delete/' + dataId,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(data) {
                            Swal.fire({
                                title: 'Data berhasil dihapus',
                                icon: 'success',
                                showCancelButton: false,
                                showConfirmButton: false,
                            }).then((result) => {
                                dataTable.ajax.reload();
                            });
                        },
                        error: function (eventError, textStatus, errorThrown) {
                            $("#btnSave").html("Submit").prop('disabled', false);
                            Swal.fire({
                                title: eventError,
                                html: errorThrown,
                                icon: "error",
                                allowOutsideClick : false
                            });
                        }
                    });
                }
            });
        });
</script>
@endsection

