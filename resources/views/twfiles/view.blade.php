@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item">
                            <a href="{{ route('twfiles.index') }}">
                                ข้อมูล 12 แฟ้ม
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            แฟ้ม {{ $table }}
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
                           <div class="row">
                                <div class="col-md-10">
                                    <h5 class="card-title">
                                        <i class="fa-regular fa-folder-open"></i>
                                        ข้อมูลแฟ้ม {{ $table }}
                                    </h5>
                                </div>
                                <div class="col-md-2">
                                   <select id="sel12" class="custom-select text-center" onchange="redirectToOption()">
                                        <option value="">-- 12 แฟ้ม --</option>
                                        <option value="{{ route('twfiles.view','ADP') }}">ADP</option>
                                        <option value="{{ route('twfiles.view','AER') }}">AER</option>
                                        <option value="{{ route('twfiles.view','CHA') }}">CHA</option>
                                        <option value="{{ route('twfiles.view','CHT') }}">CHT</option>
                                        <option value="{{ route('twfiles.view','DRU') }}">DRU</option>
                                        <option value="{{ route('twfiles.view','INS') }}">INS</option>
                                        <option value="{{ route('twfiles.view','LAB') }}">LAB</option>
                                        <option value="{{ route('twfiles.view','ODX') }}">ODX</option>
                                        <option value="{{ route('twfiles.view','OOP') }}">OOP</option>
                                        <option value="{{ route('twfiles.view','OPD') }}">OPD</option>
                                        <option value="{{ route('twfiles.view','ORF') }}">ORF</option>
                                        <option value="{{ route('twfiles.view','PAT') }}">PAT</option>
                                   </select>
                                </div>
                           </div>
                        </div>
                        <div class="col-lg-12">
                            @php
                                $array = json_decode(json_encode($data), true);
                                function build_table($array){
                                $html = '<table id="12_table"
                                    class="table table-striped table-borderless table-bordered nowrap"
                                    style="width:100%">';
                                    $html .= '<thead>';
                                        $html .= '<tr>';

                                            foreach($array[0] as $key=>$value){
                                            $html .= '<th>' . htmlspecialchars($key) . '</th>';
                                            }
                                            $html .= '</tr>';
                                        $html .= '</thead>';

                                    $html .= '<tbody>';
                                        foreach( $array as $key=>$value){
                                        $html .= '<tr>';
                                            foreach($value as $key2=>$value2){
                                            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
                                            }
                                            $html .= '</tr>';
                                        }
                                        $html .= '</tbody>';
                                    $html .= '</table>';
                                return $html;
                                }
                                echo build_table($array);
                            @endphp
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
    new DataTable('#12_table', {
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        // responsive: true,
        scrollX: true,
        // rowReorder: {
        //     selector: 'td:nth-child(2)'
        // },
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

    function redirectToOption() {
        const selectElement = document.getElementById('sel12');
        const selectedOption = selectElement.value;
        
        if (selectedOption !== '') {
            window.location.href = selectedOption;
        }
    }
</script>
@endsection
