@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ลูกหนี้ OPAE</li>
                        <li class="breadcrumb-item active">บันทึกข้อมูลผู้รับบริการ</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa-regular fa-edit"></i>
                                บันทึกข้อมูลผู้รับบริการ
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('debtor.add') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>VN</label>
                                        <input type="text" name="vn" class="form-control" value="{{ old('vn') }}" placeholder="ระบุเลข VN">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>วันที่</label>
                                        <input type="text" name="visitdate" class="form-control pickr" value="{{ old('visitdate') }}" placeholder="เลือกวันที่">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>โรงพยาบาลหลัก</label>
                                        <select name="hospmain" class="basic-select2">
                                            <option></option>
                                            @foreach ($hosp as $rs)
                                            <option value="{{ $rs->h_code }}">
                                                {{ $rs->h_code.' - '.$rs->h_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>CID</label>
                                        <input type="text" name="person_id" class="form-control" value="{{ old('person_id') }}" placeholder="ระบุหมายเลข ปชช. 13 หลัก">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>HN</label>
                                        <input type="text" name="hn" class="form-control" value="{{ old('hn') }}" placeholder="HN">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>ชื่อ -สกุล</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="ระบุคำนำหน้า ชื่อ-สกุล">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>อายุ</label>
                                        <input type="text" name="age" class="form-control" value="{{ old('age') }}" placeholder="ระบุอายุ">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>เพศ</label>
                                        <select name="sex" class="custom-select">
                                            <option value="">กรุณาเลือก</option>
                                            <option value="1">ชาย</option>
                                            <option value="2">หญิง</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Authen Code</label>
                                        <input type="text" name="auth_code" value="{{ old('auth_code') }}" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>ICD10</label>
                                        <input type="text" name="icd10" value="{{ old('icd10') }}" class="form-control" placeholder="ระบุ ICD10 / A00 , X99 , J44">
                                    </div>
                                    <div class="col-md-12">
                                        <table id="tableCost" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>รหัสบริการ</th>
                                                    <th>จำนวน</th>
                                                    <th>ค่าใช้จ่าย</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="60%">
                                                        <input type="text" name="addField[0][fs_code]" class="form-control" placeholder="ระบุรหัสบริการ">
                                                    </td>
                                                    <td width="20%">
                                                        <input type="text" name="addField[0][unit]" class="form-control" placeholder="ระบุจำนวน">
                                                    </td>
                                                    <td width="20%">
                                                        <input type="text" name="addField[0][total]" class="form-control" placeholder="ระบุค่าใช้จ่าย">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-12 text-right">
                                        <button id="dynamic-ar" type="button" class="btn btn-default">
                                            <i class="fa fa-plus-circle text-warning"></i>
                                            เพิ่มแถว
                                        </button>
                                        <button type="button" class="btn btn-default"
                                            onclick="
                                            Swal.fire({
                                                icon: 'question',
                                                title: 'ยืนยันการบันทึกข้อมูล ?',
                                                text: 'ข้อมูลจะถูกบันทึกในรายการลูกหนี้',
                                                showCancelButton: true,
                                                confirmButtonText: 'บันทึก',
                                                cancelButtonText: 'ยกเลิก'
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    form.submit()
                                                }
                                            });">
                                            <i class="fa fa-save text-success"></i>
                                            บันทึกข้อมูลบริการ
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script>
    flatpickr('.pickr', {
        "locale": "th"
    });

    $(document).ready(function() {
        $('.basic-select2').select2({
            width: '100%',
            placeholder: 'กรุณาเลือก'
        });
    });

    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;

        $("#tableCost").append('<tr>'+
        '<td><input type="text" id="fs_code'+i+'" name="addField['+i+'][fs_code]" class="form-control" placeholder="ระบุรหัสบริการ"></div></td>'+
        '<td><input type="text" id="unit'+i+'" name="addField['+i+'][unit]" class="form-control" placeholder="ระบุจำนวน"></div></td>'+
        '<td><input type="text" id="total'+i+'" name="addField['+i+'][total]" class="form-control" placeholder="ระบุค่าใช้จ่าย"></div></td>'+
        '<td><button type="button" class="btn btn-sm btn-danger remove-input-field mt-1"><i class="fa-solid fa-minus"></i></button></td>'+
        '</tr>');
    });
    
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
@endsection
