@extends('layouts.master')

{{-- Link Link --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title')
    <title>Data Matakuliah | Presensi Teknik Elektro</title>
@endsection

@section('header-table')
    <button type="button" name="create_record" id="create_record" class="btn btn-primary float-end">Tambah Data</button>
    <h6 class="m-0 font-weight-bold text-primary">Mata Kuliah Tabel</h6>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-bordered matakuliah_datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Matakuliah</th>
                            <th>Nama Matakuliah</th>
                            <th>Semester</th>
                            <th>Prodi</th>
                            <th width="180px">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="sample_form" class="form-horizontal">
                    <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Form Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_result"></span>
                        <div class="form-group">
                            <label>Kode Mata Kuliah : </label>
                            <input type="text" name="kode_matakuliah" placeholder="Kode Mata Kuliah" id="kode_matakuliah" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Mata Kuliah : </label>
                            <input type="text" name="name_matakuliah" placeholder="Mata Kuliah" id="name_matakuliah" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Semester : </label>
                            <select class="form-select" name="semester_id" id="semester_id">
                                <option value="">Silahkan pilih semester</option>
                                @foreach ($semester as $item)
                                    @if (old('semester_id') == $item->id)
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name_semester }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Prodi : </label>
                            <select class="form-select" name="prodi_id" id="prodi_id">
                                <option value="">Silahkan pilih prodi</option>
                                @role('admin')
                                @foreach ($prodi as $item)
                                    @if (old('prodi_id') == $item->id)
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name_prodi }}</option>
                                    @endif
                                @endforeach
                                @endrole
                                @role('AdminInformatika')
                                @foreach ($prodi as $item)
                                    @if (old('prodi_id') == $item->id)
                                    @else
                                        @if ($item->name_prodi == 'Teknik Informatika')
                                        <option value="{{ $item->id }}">{{ $item->name_prodi }}</option>
                                        @endif
                                    @endif
                                @endforeach
                                @endrole
                                @role('AdminElektronika')
                                @foreach ($prodi as $item)
                                    @if (old('prodi_id') == $item->id)
                                    @else
                                        @if ($item->name_prodi == 'Teknik Elektronika')
                                        <option value="{{ $item->id }}">{{ $item->name_prodi }}</option>
                                        @endif
                                    @endif
                                @endforeach
                                @endrole
                                @role('AdminListrik')
                                @foreach ($prodi as $item)
                                    @if (old('prodi_id') == $item->id)
                                    @else
                                        @if ($item->name_prodi == 'Teknik Listrik')
                                        <option value="{{ $item->id }}">{{ $item->name_prodi }}</option>
                                        @endif
                                    @endif
                                @endforeach
                                @endrole
                            </select>
                        </div>
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add" class="btn btn-info" />
                    </div>
                </form>
            </div>
            </div>
        </div>

        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="sample_form" class="form-horizontal">
                    <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4 align="center" style="margin: 0;">Apakah anda yakin ingin menghapus data ini?</h4>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('.matakuliah_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('matakuliah.index') }}",
            columns: [
                {data : 'id', name: 'id'},
                {data : 'kode_matakuliah', name: 'kode_matakuliah'},
                {data : 'name_matakuliah', name: 'name_matakuliah'},
                {data : 'semester_id', name: 'semester_id'},
                {data : 'prodi_id', name: 'prodi_id'},
                {data : 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#create_record').click(function(){
            $('.modal-title').text('Form Tambah Data');
            $('#action_button').val('Add');
            $('#action').val('Add');
            $('#form_result').html('');

            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function(event){
            event.preventDefault();
            var action_url = '';

            if($('#action').val() == 'Add')
            {
                action_url = "{{ route('matakuliah.store') }}";
            }

            if($('#action').val() == 'Edit')
            {
                action_url = "{{ route('matakuliah.update') }}";
            }

            $.ajax({
                type: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: action_url,
                data:$(this).serialize(),
                dataType: 'json',
                success: function(data) {
                    console.log('success: '+data);
                    var html = '';
                    if(data.errors)
                    {
                        html = '<div class="alert alert-danger">';
                        for(var count = 0; count < data.errors.length; count++)
                        {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if(data.success)
                    {
                        html = '<div class="alert alert-success">' +data.success + '</div>';
                        location.reload(true);
                        $('#sample_form')[0].reset();
                        $('#matakuliah_table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        });

        $(document).on('click', '.edit', function(event){
            event.preventDefault();
            var id = $(this).attr('id');
            $('#form_result').html('');

            $.ajax({
                url :"/admin/matakuliah/edit/"+id+"/",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType:"json",
                success:function(data)
                {
                    console.log('success: '+data);
                    $('#kode_matakuliah').val(data.result.kode_matakuliah);
                    $('#name_matakuliah').val(data.result.name_matakuliah);
                    $('#semester_id').val(data.result.semester_id);
                    $('#prodi_id').val(data.result.prodi_id);
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Form Edit Data');
                    $('#action_button').val('Update');
                    $('#action').val('Edit');
                    $('.editpass').hide();
                    $('#formModal').modal('show');
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            })
        });

        var matakuliah_id;

        $(document).on('click', '.delete', function(){
            $('.modal-title').text('Hapus Data');
            matakuliah_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function(){
            $.ajax({
                url:"/admin/matakuliah/destroy/"+matakuliah_id,
                beforeSend:function(){
                    $('#ok_button').text('Deleting...');
                },
                success:function(data)
                {
                    setTimeout(function(){
                        $('#confirmModal').modal('hide');
                        $('#matakuliah_table').DataTable().ajax.reload();
                        location.reload(true);
                        alert('Data Deleted');
                    }, 200);
                }
            })
        });
    });
</script>
