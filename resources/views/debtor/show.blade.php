@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ลูกหนี้ OPAE</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('debtor.index') }}">
                                รายการลูกหนี้
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('debtor.list') }}">
                                ข้อมูลลูกหนี้
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ "VN : ".$data->vn }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        {{-- <div class="col-md-12">
            @if ($data->p_status == 4)
            <div class="alert alert-success alert-dismissible">
                <h5><i class="icon fa-solid fa-check"></i> รายการนี้ถูกยืนยันจ่ายแล้ว</h5>
                วันที่ดำเนินการ : {{ date("d/m/Y", strtotime($data->pd_date)) }}
            </div>
            @endif
            @if ($data->p_status == 5)
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fa-solid fa-xmark"></i> รายการนี้ถูกปฏิเสธจ่ายแล้ว</h5>
                วันที่ดำเนินการ : {{ date("d/m/Y", strtotime($data->pd_date)) }}
            </div>
            @endif
        </div> --}}
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-regular fa-id-card"></i>
                            ข้อมูลผู้รับบริการ
                        </div>
                        <div class="card-body box-profile">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <td>VN</td>
                                        <td class="text-primary">{{ $data->vn }}</td>
                                        <td>วันที่</td>
                                        <td class="text-primary">{{ date("d/m/Y", strtotime($data->visitdate)) }}</td>
                                        <td>โรงพยาบาลหลัก</td>
                                        <td class="text-primary">{{ $data->h_name }}</td>
                                        <td>AutdenCode</td>
                                        <td class="text-primary">{{ $data->auth_code }}</td>
                                    </tr>
                                    <tr>
                                        <td>CID</td>
                                        <td class="text-primary">{{ $data->person_id }}</td>
                                        <td>HN</td>
                                        <td class="text-primary">{{ $data->hn }}</td>
                                        <td>ผู้รับบริการ</td>
                                        <td class="text-primary">{{ $data->name }}</td>
                                        <td>อายุ</td>
                                        <td class="text-primary">{{ $data->age." ปี" }}</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-regular fa-clipboard"></i>
                            รายการค่าใช้จ่าย
                        </div>
                        <div class="card-body box-profile">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">ICD10</th>
                                        <th class="">รายการ</th>
                                        {{-- <th class="text-left">รายละเอียด</th> --}}
                                        <th class="text-center">ค่าใช้จ่ายจริง</th>
                                        <th class="text-center">อัตราจ่าย</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">รวม</th>
                                        <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @php $total = 0; @endphp
                                    @php $paid = 0; @endphp
                                    @php $pdrg = 0; @endphp
                                    @foreach ($list as $rs)
                                    @php $i++; @endphp
                                    @php $total += $rs->total @endphp
                                    @php $paid += $rs->nhso_cost * $rs->num @endphp
                                    @php $pdrg += $rs->rate * $rs->num @endphp
                                    @if (!isset($rs->nhso_code) && !isset($rs->tid))
                                    @php 
                                        $icon = 'error';
                                        $text = '( ไม่พบรหัสข้อมูล )';
                                        $bg = 'bg-danger';
                                    @endphp
                                    @else
                                    @php 
                                        $icon = 'success';
                                        $text = '';
                                        $bg = 'bg-success';
                                    @endphp
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">{{ $rs->icd10 }}</td>
                                        <td class="{{ $bg }}">
                                            @if ($rs->nhso_code != "")
                                            {{ $rs->nhso_code." : ".$rs->nhso_name }}
                                            @endif
                                            @if ($rs->tid != "")
                                            {{ $rs->tid." : ".$rs->dname }}
                                            @endif
                                            @if ($rs->nhso_code == "" && $rs->tid == "") 
                                            {{ $rs->fs_code." : ".$text }}
                                            @endif
                                        </td>
                                        {{-- <td class="text-center {{ $bg }}">
                                            @if ($rs->nhso_code != "")
                                            {{ $rs->nhso_code }}
                                            @endif
                                            @if ($rs->tid != "")
                                            {{ $rs->tid }}
                                            @endif
                                            @if ($rs->nhso_code == "" && $rs->tid == "") 
                                            {{ $rs->fs_code }}
                                            @endif
                                        </td>
                                        <td class="text-left {{ $bg }}">
                                            @if ($rs->nhso_code != "")
                                            {{ $rs->nhso_name }}
                                            @endif
                                            @if ($rs->tid != "")
                                            {{ $rs->dname }}
                                            @endif
                                            @if ($rs->nhso_code == "" && $rs->tid == "") 
                                            {{ $text }}
                                            @endif
                                        </td> --}}
                                        <td class="text-center {{ $bg }}">
                                            {{ number_format($rs->total,2) }}
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            @if (isset($rs->rate))
                                            {{ number_format($rs->rate,2) }}
                                            @else
                                            {{ number_format($rs->nhso_cost,2) }}
                                            @endif
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            {{ number_format($rs->num) }}
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            @if (isset($rs->rate))
                                            {{ number_format($rs->rate * $rs->num,2) }}
                                            @else
                                            {{ number_format($rs->nhso_cost * $rs->num,2) }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($rs->p_status == 3)
                                            <form action="{{ route('debtor.list.delete',$rs->uuid) }}" method="GET">
                                                @csrf
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    {{ ($rs->p_status) != 1 ? 'disabled' : '' }}
                                                    onclick="
                                                    Swal.fire({
                                                        icon: 'warning',
                                                        title: 'ลบรายการ - ' + '{{ $rs->fs_code }}',
                                                        text: '{{ $rs->uuid }}',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'ลบรายการ',
                                                        cancelButtonText: 'ยกลก',
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            form.submit()
                                                        } else if (result.isDenied) {
                                                            form.clear()
                                                    }
                                                    });
                                                ">
                                                    ลบรายการ
                                                </button>
                                            </form>
                                            @else
                                            <span class="{{ $rs->p_text_color }}">
                                                {!! $rs->p_icon !!}
                                                {{ $rs->p_name }}
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">
                                                {{ number_format($total,2) }} ฿
                                            </span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">
                                            <span class="fw-bold text-success">
                                                {{ number_format($paid+$pdrg,2) }} ฿
                                            </span>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="addList" tabindex="-1" aria-labelledby="addListLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('debtor.list.add',$data->vn) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addListLabel">
                        <i class="fa-solid fa-plus-circle text-success"></i>
                        เพิ่มรายการ
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>วันที่</label>
                            <input type="text" class="form-control" value="{{ date("d/m/Y", strtotime($data->visitdate)) }}" @disabled(true)>
                        </div>
                        <div class="form-group col-md-6">
                            <label>VN</label>
                            <input type="text" name="vn" class="form-control" value="{{ $data->vn }}" @disabled(true)>
                        </div>
                        <div class="form-group col-md-12">
                            <label>ICD10</label>
                            <input type="text" name="icd10" class="form-control" value="{{ $rs->icd10 }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>รหัสบริการ</label>
                            <input type="text" name="fs_code" class="form-control" placeholder="ระบุรหัสบริการ">
                        </div>
                        <div class="form-group col-md-4">
                            <label>จำนวน</label>
                            <input type="text" name="unit" class="form-control" placeholder="ระบุจำนวน">
                        </div>
                        <div class="form-group col-md-4">
                            <label>ค่าใช้จ่าย</label>
                            <input type="text" name="total" class="form-control" placeholder="ระบุค่าใช้จ่าย">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    @if (!isset($data->trans_code))
                    <button type="button" class="btn btn-success"
                        onclick="
                            Swal.fire({
                                icon: 'success',
                                title: 'เพิ่มรายการค่าใช้จ่าย ?',
                                showCancelButton: true,
                                confirmButtonText: 'เพิ่มรายการ',
                                cancelButtonText: 'ยกลก',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit()
                                } else if (result.isDenied) {
                                    form.clear()
                            }
                            });
                        ">
                        <i class="fa-regular fa-save"></i>
                        บันทึกข้อมูล
                    </button>
                    @else
                    ข้อมูลที่ประมวลผลแล้วไม่สามารถเพิ่มรายการได้
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    new DataTable('#nhso_table', {
        layout: {
            topStart: {
                buttons: [
                    {
                        text: '<i class="fa-solid fa-plus-circle text-success"></i> เพิ่มรายการ',
                        action: function (e, dt, node, config) {
                            $('#addList').modal('show')
                        }
                    }
                ]
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        scrollX: true,
        oLanguage: {
            oPaginate: {
                sFirst: '<small>หน้าแรก</small>',
                sLast: '<small>หน้าสุดท้าย</small>',
                sNext: '<small>ถัดไป</small>',
                sPrevious: '<small>กลับ</small>'
            },
            sSearch: '<small><i class="fa fa-search"></i> ค้นหา</small>',
            sInfo: '<small>ทั้งหมด _TOTAL_ รายการ</small>',
            sLengthMenu: '<small>แสดง _MENU_ รายการ</small>',
            sInfoEmpty: '<small>ไม่มีข้อมูล</small>'
        },
    });
</script>
@endsection
