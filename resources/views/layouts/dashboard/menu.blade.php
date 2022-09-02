<div class="sidebar" data-color="none" data-image="{{ asset('img/bg9.jpg') }}">
    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    <div class="logo">
        <a href="dashboard" class="simple-text logo-mini">
            QL
        </a>

        <a href="dashboard" class="simple-text logo-normal">
            Quản lý
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="info">
                <div class="photo">
                    <img src="{{ asset('img/AngelRosé.jpg') }}" />
                </div>

                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                        {{ Auth::user()->name }}
                        <b class="caret"></b>
                    </span>
                </a>

                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        @role('superadmin')
                            <li>
                                <a href="superadmin/info/{{ Auth::user()->id }}">
                                    {{ __('Thông tin cá nhân') }}
                                </a>
                            </li>
                        @endrole
                        @role('admin')
                            <li>
                                <a href="admin/info/{{ Auth::user()->id }}">
                                    {{ __('Thông tin cá nhân') }}
                                </a>
                            </li>
                        @endrole
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Đăng xuất') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            @role('superadmin')
                <li>
                    <a data-toggle="collapse" href="#chart">
                        <i class="pe-7s-note2"></i>
                        <p>Thống kê
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="chart">
                        <ul class="nav">
                            {{-- <li>
                                <a href="superadmin/so-luong-khach">
                                    <span class="sidebar-mini">DC</span>
                                    <span class="sidebar-normal">Lượng khách mỗi ngày</span>
                                </a>
                            </li> --}}
                            <li>
                                <a href="superadmin/doanh-so">
                                    <span class="sidebar-mini">NRU</span>
                                    <span class="sidebar-normal">Doanh số</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>



                <li>
                    <a data-toggle="collapse" href="#room">
                        <i class="pe-7s-note2"></i>
                        <p>Quản lý phòng
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="room">
                        <ul class="nav">
                            <li>
                                <a href="superadmin/type-room">
                                    <span class="sidebar-mini">TRs</span>
                                    <span class="sidebar-normal">Loại phòng</span>
                                </a>
                            </li>
                            <li>
                                <a href="superadmin/rooms">
                                    <span class="sidebar-mini">IRs</span>
                                    <span class="sidebar-normal">Thông tin phòng</span>
                                </a>
                            </li>
                            <li>
                                <a href="superadmin/price-room">
                                    <span class="sidebar-mini">PRs</span>
                                    <span class="sidebar-normal">Giá phòng</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="superadmin/account">
                        <i class="pe-7s-graph"></i>
                        <p>Quản lý tài khoản nhân viên</p>
                    </a>
                </li>
            @endrole
            @role('admin')
                <li>
                    <a href="admin/checkin">
                        <i class="pe-7s-graph"></i>
                        <p>Đặt phòng <span style="color:blue" id="numb-room-checkin"></span></p>
                    </a>
                </li>
                <li>
                    <a href="admin/nhan-phong">
                        <i class="pe-7s-graph"></i>
                        <p>Nhận phòng <span style="color:blue" id="numb-rooms"></span></p>
                    </a>
                </li>
                <li>
                    <a href="admin/checkout">
                        <i class="pe-7s-graph"></i>
                        <p>Trả phòng <span style="color:blue" id="numb-room-checkout"></span></p>
                    </a>
                </li>
                <li>
                    <a href="admin/clean">
                        <i class="pe-7s-graph"></i>
                        <p>Dọn dẹp & sửa phòng <span style="color:blue" id="numb-room-clean"></span></p>
                    </a>
                </li>
                <li>
                    <a href="admin/history">
                        <i class="pe-7s-graph"></i>
                        <p>Lịch sử thuê phòng</p>
                    </a>
                </li>
            @endrole

        </ul>
    </div>
</div>
@push('js')
    <script>
        getInfo();

        function getInfo() {
            $.ajax({
                url: "/api/get-status-room",
                type: "get",
                dataType: "json",
                success: function(rs) {
                    var htmlCheckin = `(${rs.checkin})`;
                    $('#numb-room-checkin').html(htmlCheckin);

                    var htmlRoom = `(${rs.room})`;
                    $('#numb-rooms').html(htmlRoom);

                    var htmlCheckout = `(${rs.checkout})`;
                    $('#numb-room-checkout').html(htmlCheckout);

                    var htmlClean = `(${rs.clean})`;
                    $('#numb-room-clean').html(htmlClean);
                },
            });
        }
    </script>
@endpush
