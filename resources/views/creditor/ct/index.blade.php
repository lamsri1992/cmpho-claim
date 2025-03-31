@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ข้อมูล CT - MRI</li>
                        <li class="breadcrumb-item active">เจ้าหนี้ CT - MRI</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($ct_cash->t_pay + $ct_cash->t_con,2) }} <sup style="font-size: 20px">บาท</sup></h3>
                            <p>ค่าใช้จ่ายทั้งหมด</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <a href="{{ route('ct.hospital') }}" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ number_format($list) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รอดำเนินการ</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-clipboard"></i>
                        </div>
                        <a href="{{ route('ct.list','process') }}" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($confirm) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รายการยืนยันจ่าย</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <a href="{{ route('ct.list','confirm') }}" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($deny) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รายการที่ปฏิเสธ</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </div>
                        <a href="{{ route('ct.list','deny') }}" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa-solid fa-chart-line"></i>
                                แผนภูมิแสดงรายการเจ้าหนี้แยกตามโรงพยาบาล
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="creditorChart"></canvas>
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
    
    $(document).ready(function() {
        $('.select-hos').select2({
            width: '100%',
            dropdownParent: $('#search')
        });
    });

    flatpickr('.flatpickr', {
        "locale": "th"
    });

    $(document).ready(function () {
        Chart.defaults.font.family = 'Noto Sans Thai';
    });

    const labels = [
        @foreach ($creditor as $res)
        [ "{{ $res->h_name }}"],
        @endforeach
    ];
  
    const config = {
      type: 'bar',
      data: {
        datasets: [{
            label: 'เจ้าหนี้ / ค่าใช้จ่ายตามเกณฑ์',
            data: [
                @foreach ($creditor as $res)
                "{{ $res->t_pay + $res->t_con }}",
                @endforeach
            ],
            backgroundColor: [
                '#17a2b8',
            ],
            borderColor: [
                '#17a2b8',
            ],
        }],
        labels: labels
    },
      options: {}
    };

    const creditorChart = new Chart(
        document.getElementById('creditorChart'),
        config
    );
</script>
@endsection
