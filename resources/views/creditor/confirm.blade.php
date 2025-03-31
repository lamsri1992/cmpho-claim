@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">เจ้าหนี้ OPAE</li>
                        <li class="breadcrumb-item active">เจ้าหนี้แยกโรงพยาบาล</li>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">
                                        <i class="fa-regular fa-check-square"></i>
                                        รายการยืนยันจ่าย
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-borderless table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">รหัสหน่วยบริการ</th>
                                        <th class="">หน่วยบริการ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-right">ค่าใช้จ่ายจริง</th>
                                        <th class="text-right">เรียกเก็บตามเกณฑ์</th>
                                        <th class="text-right">ส่วนต่าง</th>
                                        <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $diff = 0; @endphp
                                    @php $total = 0; @endphp
                                    @php $paid = 0; @endphp
                                    @php $tdiff = 0; @endphp
                                    @foreach ($data as $rs)
                                    @php $diff = ($rs->nh_cost + $rs->d_cost) - $rs->total @endphp
                                    @php $tdiff += ($rs->nh_cost + $rs->d_cost) - $rs->total @endphp
                                    @php $total += $rs->total @endphp
                                    @php $paid += ($rs->nh_cost + $rs->d_cost) @endphp
                                    <tr>
                                        <td class="text-center">{{ $rs->hcode }}</td>
                                        <td class="">{{ $rs->h_name }}</td>
                                        <td class="text-center">{{ number_format($rs->count)." รายการ" }}</td>
                                        <td class="text-primary text-right">{{ number_format($rs->total,2)." ฿" }}</td>
                                        <td class="text-right">{{ number_format($rs->nh_cost + $rs->d_cost,2)." ฿" }}</td>
                                        <td class="text-right">
                                            @if ($diff <= 0)
                                            @php $text = 'text-success'; @endphp
                                            @else
                                            @php $text = 'text-danger'; @endphp
                                            @endif
                                            <span class="{{ $text }}">
                                                {{ number_format($diff,2)." ฿" }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-secondary btn-sm">
                                                <i class="fa-solid fa-comments-dollar"></i>
                                                บันทึกชำระเงิน
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="3">รวม</td>
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
       lengthMenu: [
           [10, 25, 50, -1],
           [10, 25, 50, "All"]
       ],
       responsive: true,
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
