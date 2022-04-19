@extends('layouts.app')

@section('content')
<div class="col-md-6">

    <div class="card card-primary">
        <div class="card-header">
        <h3 class="card-title">Add Product</h3>
        </div>


        <form id="formAdd" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="Nama">Nama</label>
                    <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Produk">
                    <span class="text-danger error-text nama_error"></span>
                </div>
                <div class="form-group">
                    <label for="Deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" >Masukkan <em>deskripsi</em> <u>produk</u> <strong>disini</strong></textarea>
                    <span class="text-danger error-text deskripsi_error"></span>
                </div>
                <div class="form-group">
                    <label for="Harga">Harga</label>
                    <input type="text" class="form-control" name="harga" placeholder="Masukkan Harga Produk">
                    <span class="text-danger error-text harga_error"></span>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="custom-select rounded-0" name="status">
                        <option value="0">Tidak Aktif</option>
                        <option value="1">Aktif</option>
                    </select>
                    <span class="text-danger error-text status_error"></span>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="btnSave" class="btn btn-primary float-right">Submit</button>
            </div>
        </form>
    </div>

</div>
@endsection

@section('script')
<script>
  $(function () {
    // Summernote
    $('#deskripsi').summernote({
        tabsize: 2,
        height: 200,
        toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                // ['insert', ['link', 'picture', 'hr', 'video']],
                // ['view', ['codeview'/*, 'codeview' */]],   // remove codeview button
                // ['help', ['help']]
            ],  
    })

    $('#formAdd').submit(function(e) {
            e.preventDefault();
            var frm = $(this);
            var formData = new FormData(frm[0]);
            console.log(frm);
            console.log(formData);
            $.ajax({
                url: baseUrl + "/product/store",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $(this).serialize(),
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend: function () {
                    $("#btnSave").html('<span class="spinner-border spinner-border-sm me-1 mr-1" role="status" aria-hidden="true"></span>Loading...').prop('disabled', true);
                },
                success: function (result) {
                    if (result.metaData.code == 200) {
                        Swal.fire({
                            title: 'Data berhasil disimpan',
                            icon: 'success',
                            showCancelButton: false,
                            showConfirmButton: false,
                        }).then((result) => {
                            $(".modal").modal("hide");
                            // $("#btnSave").html("Submit").prop('disabled', false);
                            // datatableUser.ajax.reload();
                            window.location = baseUrl + "/product";
                        })
                    } else if (result.metaData.code == 403) {
                        $.each(result.metaData.message, function(prefix,val){
                            $('span.'+prefix+'_error').text(val[0]);
                        });
                        Swal.fire({
                            title: 'Data tidak lengkap',
                            icon: 'warning',
                            showCancelButton: false,
                            showConfirmButton: false,
                        }).then((result) => {
                            $(".modal").modal("hide");
                            $("#btnSave").html("Submit").prop('disabled', false);
                            // datatableUser.ajax.reload();
                        })
                    } else {
                        Swal.fire({
                            title: 'Terjadi kesalahan server, silahkan coba beberapa saat lagi',
                            icon: 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                        }).then((result) => {
                            $(".modal").modal("hide");
                            $("#btnSave").html("Submit").prop('disabled', false);
                            // datatableUser.ajax.reload();
                        })
                    }
                },
                error: function (eventError, textStatus, errorThrown) {
                    // console.log(result);
                    $("#btnSave").html("Submit").prop('disabled', false);
                    Swal.fire({
                        title: eventError,
                        html: errorThrown,
                        icon: "error",
                        allowOutsideClick : false
                    });
                }
            });
        });
  })
</script>
@endsection
