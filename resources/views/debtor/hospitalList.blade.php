@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ลูกหนี้ OPAE</li>
                        <li class="breadcrumb-item">ลูกหนี้แยกโรงพยาบาล</li>
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
                                <i class="fa-regular fa-hospital"></i>
                                ข้อมูลลูกหนี้แยกรายโรงพยาบาล
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">VN</th>
                                        <th class="text-center">CID</th>
                                        <th>ผู้รับบริการ</th>
                                        <th class="text-center">รพ.ลูกหนี้</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-right">ค่าใช้จ่ายจริง</th>
                                        <th class="text-right">เรียกเก็บตามเกณฑ์</th>
                                        <th class="text-right">ส่วนต่าง</th>
                                        {{-- <th class="text-center">สถานะ</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $diff = 0; @endphp
                                    @php $total = 0; @endphp
                                    @php $paid = 0; @endphp
                                    @php $tdiff = 0; @endphp
                                    @php $cases = 0; @endphp
                                    @foreach ($data as $rs)
                                    @php $diff = ($rs->nh_cost + $rs->d_cost) - $rs->total @endphp
                                    @php $tdiff += ($rs->nh_cost + $rs->d_cost) - $rs->total @endphp
                                    @php $total += $rs->total @endphp
                                    @php $cases += $rs->cases @endphp
                                    @php $paid += ($rs->nh_cost + $rs->d_cost) @endphp
                                    <tr>
                                        <td class="text-center">
                                            {{ date("d/m/Y", strtotime($rs->visitdate)) }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('debtor.show',$rs->vn) }}">
                                                {{ $rs->vn }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $rs->person_id }}</td>
                                        <td>{{ $rs->name }}</td>
                                        <td class="text-center">{{ $rs->hospmain." : ".$rs->h_name }}</td>
                                        <td class="text-center">{{ $rs->cases }}</td>
                                        <td class="text-primary text-right">{{ number_format($rs->total,2)." ฿" }}</td>
                                        <td class="text-right">{{ number_format($rs->nh_cost + $rs->d_cost,2)." ฿" }}</td>
                                        <td class="text-right">
                                            @if ($diff >= 0)
                                            @php $text = 'text-success'; @endphp
                                            @else
                                            @php $text = 'text-danger'; @endphp
                                            @endif
                                            <span class="{{ $text }}">
                                                {{ number_format($diff,2)." ฿" }}
                                            </span>
                                        </td>
                                        {{-- <td class="text-center {{ $rs->p_color }}">
                                            {{ $rs->p_name }}
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="5">รวม</td>
                                        <td class="text-center">
                                            <span style="text-decoration-line: underline">
                                                {{ number_format($cases)}}
                                            </span>
                                        </td>
                                        <td class="text-right text-primary">
                                            <span style="text-decoration-line: underline">
                                                {{ number_format($total,2)." ฿" }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <span style="text-decoration-line: underline">
                                                {{ number_format($paid,2)." ฿" }}
                                            </span>
                                        </td>
                                        <td class="text-right text-danger">
                                            <span style="text-decoration-line: underline">
                                                {{ number_format($tdiff,2)." ฿" }}
                                            </span>
                                        </td>
                                        {{-- <td></td> --}}
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
