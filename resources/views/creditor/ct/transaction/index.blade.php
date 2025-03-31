@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ข้อมูล CT - MRI</li>
                        <li class="breadcrumb-item active">รายการ Transaction</li>
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
                               ข้อมูล Transaction
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="basicTable" class="table table-striped table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <i class="fa-regular fa-calendar"></i>
                                            วันที่สร้าง
                                        </th>
                                        <th class="text-center">เลขที่ Transaction</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="">ค่าใช้จ่ายชดเชย</th>
                                        <th class="">ค่าฉีดสี</th>
                                        <th class="">รวม</th>
                                        <th class="text-center">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $rs)
                                    <tr>
                                        <td class="text-center">{{ date("d/m/Y", strtotime($rs->trans_create)) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('transaction.view',$rs->trans_code) }}">
                                                {{ $rs->trans_code }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $rs->trans_num." รายการ" }}</td>
                                        <td class="">{{ number_format($rs->trans_payment,2) }}</td>
                                        <td class="">{{ number_format($rs->trans_contrast,2) }}</td>
                                        <td class="">{{ number_format($rs->trans_payment + $rs->trans_contrast,2) }}</td>
                                        <td class="text-center {{ $rs->t_bg }}">{{ $rs->t_name }}</td>
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

@endsection
