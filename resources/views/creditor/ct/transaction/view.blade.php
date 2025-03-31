@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ข้อมูล CT - MRI</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('transaction.index') }}">
                                ข้อมูล Transaction
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $id }}</li>
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
                                @if (isset($trans->trans_file))
                                Transaction :: 
                                <i class="fa-solid fa-file-pdf text-danger"></i>
                                <a href="{{ asset('uploads/paid/'.$trans->trans_file) }}" target="_blank">
                                    {{ $id }}
                                </a>
                                @else
                                Transaction :: {{ $id }}
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">รพ.เจ้าหนี้</th>
                                        <th class="text-center">HN</th>
                                        <th class="">ผู้รับบริการ</th>
                                        <th class="text-center">ICD10</th>
                                        <th class="text-center">ICD9</th>
                                        <th class="">รายการ</th>
                                        <th class="text-center">ค่าใช้จ่ายจริง</th>
                                        <th class="text-center">Point</th>
                                        <th class="text-center">ค่าชดเชย</th>
                                        <th class="text-center">ค่าฉีดสี</th>
                                        <th class="text-center">รายละเอียด</th>
                                        <th class="text-center">รวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $all_cash = 0;
                                        $all_payment = 0;
                                        $all_contrast = 0;
                                        $all_total = 0;
                                    @endphp
                                    @foreach ($data as $rs)
                                    @php
                                        $all_cash += $rs->total_cash;
                                        $all_payment += $rs->total_payment;
                                        $all_contrast += $rs->total_contrast;
                                        $all_total += $rs->total_payment + $rs->total_contrast;
                                    @endphp
                                    @if ($rs->ct_status == 3)
                                    @php $vs = '' @endphp
                                    @else
                                    @php $vs = 'disabled' @endphp
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ date("d/m/Y", strtotime($rs->visitdate)) }}</td>
                                        <td class="text-center">{{ $rs->h_code." : ".$rs->h_name }}</td>
                                        <td class="text-center">{{ $rs->hn }}</td>
                                        <td class="">{{ $rs->name }}</td>
                                        <td class="text-center">{{ $rs->icd10 }}</td>
                                        <td class="text-center">{{ $rs->icd9 }}</td>
                                        <td class="">{{ $rs->red }}</td>
                                        <td class="text-end">{{ number_format($rs->total_cash,2) }}</td>
                                        <td class="text-center">{{ $rs->point }}</td>
                                        <td class="text-end">{{ number_format($rs->total_payment,2) }}</td>
                                        <td class="text-end">{{ number_format($rs->total_contrast,2) }}</td>
                                        <td class="">{{ $rs->contrast_description }}</td>
                                        <td class="text-end text-primary">
                                            {{ number_format($rs->total_payment + $rs->total_contrast,2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-decoration-line: underline">
                                            {{ number_format($all_cash,2) }}
                                        </td>
                                        <td></td>
                                        <td style="text-decoration-line: underline">
                                            {{ number_format($all_payment,2) }}
                                        </td>
                                        <td style="text-decoration-line: underline">
                                            {{ number_format($all_contrast,2) }}
                                        </td>
                                        <td></td>
                                        <td style="text-decoration-line: underline" class="text-primary">
                                            {{ number_format($all_total,2) }}
                                        </td>
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
<div class="modal fade" id="upload" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
    <form action="{{ route('transaction.upload',$id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadLabel">
                        <i class="fa-solid fa-cloud-upload"></i>
                        อัพโหลดไฟล์แจ้งชำระ
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">
                            <i class="fa-regular fa-file-pdf text-danger"></i>
                            แนบไฟล์เอกสาร
                        </label>
                        <input type="file" name="file" class="form-control-file">
                    </div>
                    <small class="text-danger">รองรับไฟล์ประเภท .pdf เท่านั้น</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิดหน้าต่าง</button>
                    <button type="button" class="btn btn-success"
                        onclick="Swal.fire({
                            icon: 'question',
                            title: 'ยืนยันการบันทึกข้อมูล',
                            showDenyButton: true,
                            confirmButtonText: 'ยืนยัน',
                            denyButtonText: 'ยกเลิก'
                          }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit()
                            }
                          });">
                        <i class="fa-solid fa-save"></i>
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            // placeholder: 'กรุณาเลือก',
            width: '100%',
        });
    });

    new DataTable('#nhso_table', {
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-solid fa-file-excel text-success"></i> Export Excel',
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            sheet.querySelectorAll('row c[r^="C"]').forEach((el) => {
                                el.setAttribute('s', '2');
                            });
                        }
                    },
                    {
                        text: '<i class="fa-solid fa-cloud-upload text-primary"></i> อัพโหลดไฟล์แจ้งชำระ',
                        action: function (e, dt, node, config) {
                            var st = {{ $trans->trans_status }}
                            if (st === 2) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'ข้อมูลถูกดำเนินการแล้ว',
                                    text: 'วันที่ดำเนินการ ' + '{{ date("d/m/Y", strtotime($trans->trans_upload)) }}',
                                    showCancelButton: false,
                                });
                            } else {
                                $('#upload').modal('show')
                            }
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
        }
    });
</script>
@endsection
