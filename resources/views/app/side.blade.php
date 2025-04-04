<aside class="main-sidebar sidebar-dark-secondary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('img/logo_cmh.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CMPHO - CLAIM</span>
    </a>

    <div class="sidebar mt-2">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header text-muted">เมนูระบบ</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header text-muted">ข้อมูล OPAE</li>
                <li class="nav-item {{ request()->is('debtor*') ? 'menu-is-opening menu-open':'' }}">
                    <a href="#" class="nav-link {{ request()->is('debtor*') ? 'active':'' }}">
                        <i class="fa-solid fa-user-injured nav-icon"></i>
                        <p>
                            ลูกหนี้ OPAE
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('debtor.index') }}"
                                class="nav-link {{ request()->is('debtor') || request()->is('debtor/list*') || request()->is('debtor/deny*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายการลูกหนี้</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('debtor.hospital') }}"
                                class="nav-link {{ request()->is('debtor/hospital*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ลูกหนี้แยกโรงพยาบาล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('debtor.create') }}" 
                                class="nav-link {{ request()->is('debtor/create*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>บันทึกข้อมูลลูกหนี้</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->is('creditor*') ? 'menu-is-opening menu-open':'' }}">
                    <a href="#" class="nav-link {{ request()->is('creditor*') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-comment-dollar"></i>
                        <p>
                            เจ้าหนี้ OPAE
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('creditor.hospital') }}"
                                class="nav-link {{ request()->is('creditor/hospital*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>เจ้าหนี้แยกโรงพยาบาล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('creditor.confirm') }}"
                                class="nav-link {{ request()->is('creditor/confirm*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายการยืนยันจ่าย</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header text-muted">ข้อมูล CT - MRI</li>
                @if (Auth::user()->ct_active == 'Y')                    
                <li class="nav-item {{ request()->is('ctmri*') ? 'menu-is-opening menu-open':'' }}">
                    <a href="#" class="nav-link {{ request()->is('ctmri*') ? 'active':'' }}">
                        <i class="fa-solid fa-x-ray nav-icon"></i>
                        <p>
                            ลูกหนี้ CT - MRI
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ctmri.index') }}"
                                class="nav-link {{ request()->is('ctmri') || request()->is('ctmri/list*') || request()->is('ctmri/search') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายการลูกหนี้</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" type="button" class="nav-link" data-toggle="modal" data-target="#importModal">
                                <i class="far fa-circle nav-icon"></i>
                                Import Excel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ctmri.hospital') }}"
                                class="nav-link {{ request()->is('ctmri/hospital*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ลูกหนี้แยกโรงพยาบาล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ctmri.paid') }}"
                                class="nav-link {{ request()->is('ctmri/paid*') ? 'active':'' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>รายการชำระหนี้</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('ct.index') }}" class="nav-link {{ request()->is('credit/ct*') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-comment-dollar"></i>
                        <p>เจ้าหนี้ CT - MRI</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transaction.index') }}" class="nav-link {{ request()->is('transaction/ct*') ? 'active':'' }}">
                        <i class="nav-icon fa-solid fa-money-check-dollar"></i>
                        <p>ข้อมูล Transaction</p>
                    </a>
                </li>
                <li class="nav-header text-muted">ฐานข้อมูลระบบ</li>
                <li class="nav-item">
                    <a href="{{ route('nhso.list') }}"
                        class="nav-link {{ request()->is('nhso/list') ? 'active':'' }}">
                        <i class="fa-solid fa-book-medical nav-icon"></i>
                        <p>ข้อมูลค่าบริการ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('gpu.drug') }}" 
                        class="nav-link {{ request()->is('gpu/drug*') ? 'active':'' }}">
                        <i class="fa-solid fa-pills nav-icon"></i>
                        <p>ข้อมูลบัญชียา GPU</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('nhso.drug') }}" 
                        class="nav-link {{ request()->is('nhso/drug*') ? 'active':'' }}">
                        <i class="fa-solid fa-capsules nav-icon"></i>
                        <p>ข้อมูลบัญชียา สมสท.</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('ctmri.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        นำเข้าข้อมูล
                        <small class="text-danger">รองรับไฟล์ xls , xlsx เท่านั้น</small>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">เลือกไฟล์</label>
                        <input type="file" class="form-control-file" id="file" name="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button id="btnUpload" type="button" class="btn btn-success"
                        onclick="
                        Swal.fire({
                            icon: 'question',
                            title: 'ยืนยันการนำเข้าข้อมูล ?',
                            text: 'ข้อมูลจะถูกบันทึกในรายการลูกหนี้ CT - MRI',
                            showCancelButton: true,
                            confirmButtonText: 'นำเข้า',
                            cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('btnUpload').disabled = true;
                                let timerInterval;
                                form.submit()
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'กำลังนำเข้า',
                                    text: 'กรุณารอจนกว่าจะนำเข้าสำเร็จ ห้ามปิดหน้าจอนี้ !!',
                                    timerProgressBar: true,
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        const timer = Swal.getPopup().querySelector('b');
                                        timerInterval = setInterval(() => {
                                        timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        console.log('Import Success');
                                    }
                                });
                            }
                        });">
                        <i class="fa-solid fa-folder-plus"></i>
                        นำเข้าข้อมูล
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>