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
                        <li class="breadcrumb-item active">
                            รายการปฏิเสธจ่าย
                        </li>
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
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                ข้อมูลรายการถูกปฏิเสธจ่าย
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">VN</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">สถานบริการหลัก</th>
                                        <th class="text-center">HN</th>
                                        <th class="text-center">รหัสบริการ</th>
                                        <th class="text-center">ค่าใช้จ่าย</th>
                                        <th class="text-center">อัตราจ่าย</th>
                                        <th class="text-center">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($data as $rs)
                                    @php $i++; @endphp
                                    @if (!isset($rs->nhso_code))
                                    @php 
                                        $icon = 'error';
                                        $text = 'ไม่พบข้อมูลใน NHSO FS-CODE';
                                        $check = $rs->fs_code;
                                        $bg = 'bg-danger';
                                    @endphp
                                    @else
                                    @php 
                                        $icon = 'success';
                                        $text = '';
                                        $check = $rs->nhso_code;
                                        $bg = 'bg-success';
                                    @endphp
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('debtor.show',$rs->vn) }}">
                                                {{ $rs->vn }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ date("d/m/Y", strtotime($rs->visitdate)) }}</td>
                                        <td class="text-center">{{ $rs->hospmain." : ".$rs->h_name }}</td>
                                        <td class="text-center">{{ $rs->hn }}</td>
                                        <td class="text-center {{ $bg }}">
                                            <a href="#" 
                                                onclick="
                                                    Swal.fire({
                                                        icon: '{{ $icon }}',
                                                        title: '{{ $check }}',
                                                        text: '{{ $text.$rs->nhso_name }}',
                                                    });
                                                ">
                                                {{ $check }}
                                            </a>
                                        </td>
                                        <td class="text-center {{ $bg }}">{{ number_format($rs->total,2) }}</td>
                                        <td class="text-center {{ $bg }}">{{ number_format($rs->nhso_cost,2) }}</td>
                                        <td class="text-center">
                                            <a href="#" class="{{ $rs->p_text_color }}"
                                                onclick="
                                                Swal.fire({
                                                    title: '{{ $rs->p_name }}',
                                                });
                                            ">
                                                {!! $rs->p_icon !!}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
                    }
                ]
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        responsive: true,
        // scrollX: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
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
