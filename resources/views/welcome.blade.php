@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active">
                            <h3>
                                <i class="fa-solid fa-tachometer-alt"></i>
                                Dashboard
                            </h3>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($deb_cost->total,2) }} <sup style="font-size: 20px">บาท</sup></h3>
                            <p>ยอดลูกหนี้ทั้งหมด</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($due_cost->total,2) }} <sup style="font-size: 20px">บาท</sup></h3>
                            <p>ยอดเจ้าหนี้ทั้งหมด</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-comment-dollar"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ number_format($deb_count) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รายการเรียกเก็บ</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-file-import"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($due_count) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รายการตามจ่าย</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-file-export"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa-solid fa-chart-line"></i>
                                แผนภูมิแสดงรายการลูกหนี้แยกตามโรงพยาบาล
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="debtorChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
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
            label: 'ยอดเจ้าหนี้',
            data: [
                @foreach ($creditor as $res)
                "{{ $res->paid }}",
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

    // MOO
    const labels2 = [
        @foreach ($debtor as $res)
        [ "{{ $res->h_name }}"],
        @endforeach
    ];
  
    const config2 = {
      type: 'bar',
      data: {
        datasets: [{
            label: 'ยอดลูกหนี้',
            data: [
                @foreach ($debtor as $res)
                "{{ $res->paid }}",
                @endforeach
            ],
            backgroundColor: [
                '#2dce89',
            ],
            borderColor: [
                '#2dce89',
            ],
        }],
        labels: labels2
    },
      options: {}
    };

    const debtorChart = new Chart(
        document.getElementById('debtorChart'),
        config2
    );
</script>
@endsection
