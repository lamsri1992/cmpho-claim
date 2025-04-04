@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">เจ้าหนี้ OPAE</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('creditor.hospital') }}">
                                ข้อมูลเจ้าหนี้
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $data->vn }}</li>
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
                <div class="col-md-12">
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
                                        {{-- <th class="text-center">รหัส</th> --}}
                                        <th class="">รายการ</th>
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
                                        {{-- <td class="text-left {{ $bg }}">
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="{{ route('creditor.vn.confirm',$rs->uuid) }}" method="post">
                                                        @csrf
                                                        <button type="button" class="btn btn-default"
                                                            {{ ($rs->p_status) != 3 ? 'disabled' : '' }}
                                                            onclick="
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'ยืนยันจ่าย - ' + '{{ $rs->fs_code }}',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'ยืนยันจ่าย',
                                                                    cancelButtonText: 'ยกเลิก',
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        form.submit()
                                                                    } else if (result.isDenied) {
                                                                        form.clear()
                                                                }
                                                                });
                                                            ">
                                                            <i class="fa-solid fa-check-circle text-success"></i>
                                                            ยืนยันจ่าย
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <form action="{{ route('creditor.vn.deny',$rs->uuid) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="sweetalert_value" id="sweetalert_value">
                                                        <button type="button" class="btn btn-default"
                                                            {{ ($rs->p_status) != 3 ? 'disabled' : '' }}
                                                            onclick="
                                                                Swal.fire({
                                                                    icon: 'warning',
                                                                    title: 'ปฏิเสธจ่าย - ' + '{{ $rs->fs_code }}',
                                                                    showCancelButton: true,
                                                                    input: 'text',
                                                                    inputLabel: 'ระบุเหตุผลการปฏิเสธจ่าย',
                                                                    confirmButtonText: 'ปฏิเสธจ่าย',
                                                                    cancelButtonText: 'ยกเลิก',
                                                                    inputValidator: (value) => {
                                                                        if (!value) {
                                                                            return 'กรุณาระบุหมายเหตุ';
                                                                            }
                                                                        }
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // alert(result.value)
                                                                        document.getElementById('sweetalert_value').value = result.value;
                                                                        form.submit()
                                                                    } else if (result.isDenied) {
                                                                        form.clear()
                                                                }
                                                                });
                                                            ">
                                                            <i class="fa-solid fa-xmark-circle text-danger"></i>
                                                            ปฏิเสธจ่าย
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>                                                
                                            @else
                                            <a href="#" class="{{ $rs->p_text_color }}"
                                                onclick="Swal.fire('{{ $rs->deny_note }}')">
                                                {!! $rs->p_icon !!}
                                                {{ $rs->p_name }}
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
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
@endsection
@section('script')
<script>
    new DataTable('#nhso_table', {
        // layout: {
        //     topStart: {
        //         buttons: [
        //             {
        //                 text: '<i class="fa-solid fa-check-circle text-success"></i> ยืนยันข้อมูล',
        //                 action: function (e, dt, node, config) {
        //                     var stat = {{ $data->p_status }}
        //                     if (stat == 3) {
        //                         Swal.fire({
        //                             icon: "success",
        //                             title: "ยืนยันการจ่าย ?",
        //                             text: "คำอธิบาย : คือการยืนยันการจ่ายรายการ VN นี้ทั้งหมด",
        //                             showDenyButton: false,
        //                             showCancelButton: true,
        //                             confirmButtonText: "ยืนยัน",
        //                             cancelButtonText: "ยกเลิก"
        //                             }).then((result) => {
        //                             if (result.isConfirmed) {
        //                                 $.ajax({
        //                                     url: "{{ route('creditor.paid.status') }}",
        //                                     method: 'GET',
        //                                     data: { 
        //                                         stat: '4',
        //                                         vn: "{{ $data->vn }}"
        //                                     },
        //                                     success:function(data){
        //                                         let timerInterval
        //                                         Swal.fire({
        //                                             timer: 3000,
        //                                             timerProgressBar: true,
        //                                             title: 'กำลังบันทึกข้อมูล',
        //                                             allowOutsideClick: false,
        //                                             allowEscapeKey: false,
        //                                             timerProgressBar: true,
        //                                             didOpen: () => {
        //                                                 Swal.showLoading();
        //                                                 const timer = Swal.getPopup().querySelector("b");
        //                                             },
        //                                             willClose: () => {
        //                                                 clearInterval(timerInterval);
        //                                             }
        //                                         }).then((result) => {
        //                                             if (result.dismiss === Swal.DismissReason.timer) {
        //                                                 Swal.fire({
        //                                                     icon: 'success',
        //                                                     title: 'ยืนยันจ่าย VN: ' + '{{ $data->vn }}',
        //                                                     text: '{{ number_format($paid + $pdrg,2) }}' + ' บาท',
        //                                                     showConfirmButton: false,
        //                                                     allowOutsideClick: false,
        //                                                     allowEscapeKey: false,
        //                                                     timer: 10000
        //                                                 })
        //                                                 window.setTimeout(function () {
        //                                                     location.reload()
        //                                                 }, 3000);
        //                                             }
        //                                         })
        //                                     }
        //                                 });
        //                             }
        //                         });
        //                     } else {
        //                         Swal.fire("รายการนี้ถูกดำเนินการแล้ว");
        //                     }
        //                 }
        //             },
        //             {
        //                 text: '<i class="fa-solid fa-times-circle text-danger"></i> ปฏิเสธการจ่าย',
        //                 action: function (e, dt, node, config) {
        //                     var stat = {{ $data->p_status }}
        //                     if (stat == 3) {
        //                         Swal.fire({
        //                             icon: "error",
        //                             title: "ปฏิเสธการจ่าย ?",
        //                             text: "คำอธิบาย : คือการปฏิเสธจ่ายรายการ VN นี้ทั้งหมด",
        //                             showDenyButton: false,
        //                             showCancelButton: true,
        //                             confirmButtonText: "ปฏิเสธการจ่าย",
        //                             cancelButtonText: "ยกเลิก"
        //                             }).then((result) => {
        //                         if (result.isConfirmed) {
        //                             $.ajax({
        //                                 url: "{{ route('creditor.paid.status') }}",
        //                                 method: 'GET',
        //                                 data: { 
        //                                     stat: '5',
        //                                     vn: {{ $data->vn }}
        //                                 },
        //                                 success:function(data){
        //                                     let timerInterval
        //                                     Swal.fire({
        //                                         timerProgressBar: true,
        //                                         title: 'กำลังบันทึกข้อมูล',
        //                                         allowOutsideClick: false,
        //                                         allowEscapeKey: false,
        //                                         timerProgressBar: true,
        //                                         didOpen: () => {
        //                                             Swal.showLoading();
        //                                             const timer = Swal.getPopup().querySelector("b");
        //                                         },
        //                                         willClose: () => {
        //                                             clearInterval(timerInterval);
        //                                         }
        //                                     }).then((result) => {
        //                                         if (result.dismiss === Swal.DismissReason.timer) {
        //                                             Swal.fire({
        //                                                 icon: 'error',
        //                                                 title: 'ปฏิเสธจ่าย VN: ' + '{{ $data->vn }}',
        //                                                 text: '{{ number_format($paid + $pdrg,2) }}' + ' บาท',
        //                                                 showConfirmButton: false,
        //                                                 allowOutsideClick: false,
        //                                                 allowEscapeKey: false,
        //                                                 timer: 10000
        //                                             })
        //                                             window.setTimeout(function () {
        //                                                 location.reload()
        //                                             }, 3000);
        //                                         }
        //                                     })
        //                                 }
        //                             });
        //                         }
        //                     });
        //                     } else {
        //                         Swal.fire("รายการนี้ถูกดำเนินการแล้ว");
        //                     }
        //                 }
        //             }
        //         ]
        //     }
        // },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        // responsive: true,
        // rowReorder: {
        //     selector: 'td:nth-child(2)'
        // },
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
