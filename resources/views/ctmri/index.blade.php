@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ข้อมูล CT - MRI</li>
                        <li class="breadcrumb-item active">ลูกหนี้ CT - MRI</li>
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
                            <h3>{{ number_format($ct_cash->total,2) }} <sup style="font-size: 20px">บาท</sup></h3>
                            <p>ค่าใช้จ่ายทั้งหมด</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($ct_total->total,2) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รายการเรียกเก็บ</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-clipboard"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#search">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ number_format($process) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รายการรอนำส่ง</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-file-import"></i>
                        </div>
                        <a href="{{ route('ctmri.list') }}" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($deny) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รายการถูกปฏิเสธ</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
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

<!-- Modal Search -->
<div class="modal fade" id="search" tabindex="-1" aria-labelledby="searchLabel" aria-hidden="true">
    <form action="{{ route('ctmri.search') }}" method="GET">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchLabel">ค้นหาข้อมูลเรียกเก็บ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">
                            <i class="fa-regular fa-calendar"></i>
                            เริ่มวันที่
                        </label>
                        <input type="text" name="dstart" class="form-control flatpickr">
                    </div>
                    <div class="form-group">
                        <label for="">
                            <i class="fa-regular fa-calendar"></i>
                            ถึงวันที่
                        </label>
                        <input type="text" name="dend" class="form-control flatpickr">
                    </div>
                    <div class="form-group">
                        <label for="">
                            <i class="fa-regular fa-hospital"></i>
                            หน่วยบริการ
                        </label>
                        <select name="hos" class="select-hos">
                            <option value="0">เลือกทั้งหมด</option>
                            @foreach ($hos as $rs)
                            <option value="{{ $rs->h_code }}">
                                {{ $rs->h_code." : ".$rs->h_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-center">
                        <small class="text-danger">ข้อมูลจะถูกค้นหาจากวันที่ Visit</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-search"></i>
                        ค้นหา
                    </button>
                </div>
            </div>
        </div>
    </form>
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
