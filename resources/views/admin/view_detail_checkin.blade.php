<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="content content-full-width">
                <ul role="tablist" class="nav nav-tabs">
                    <li role="presentation" class="active">
                        <a href="#icon-info" data-toggle="tab"><i class="fa fa-info"></i> Thông tin thời gian thuê
                            phòng + khách hàng</a>
                    </li>
                    <button class="btn btn-success">Trả phòng</button>
                </ul>
                <div class="tab-content">
                    <div id="icon-info" class="tab-pane active">
                        <div class="card">
                            <div class="content">
                                @foreach ($checkin as $data)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Số phòng:</label>
                                                <input type="text" class="form-control" id="name_room"
                                                    name="time_start" value="{{ $data->name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Thời gian bắt đầu</label>
                                                <input type="datetime-local" class="form-control" id="time_start"
                                                    name="time_start" value="{{ $data->time_start }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Thời gian kết thúc</label>
                                                <input type="datetime-local" class="form-control" id="time_end"
                                                    name="time_end" value="{{ $data->time_end }}" readonly>
                                                <span class="text-danger error-text time_end_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach ($customers as $cus)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Họ và tên khách hàng:</label>
                                                <input type="text" class="form-control" value="{{ $cus->name }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Số CMT/CCCD:</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $cus->identify_numb }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- @push('js')
    <script type="text/javascript">
        let currentDate = new Date();
        let cDay = currentDate.getDate();
        if (cDay >= 10) {
            cDay = cDay;
        } else {
            cDay = "0" + cDay;
        }
        let cMonth = currentDate.getMonth() + 1;
        let cYear = currentDate.getFullYear();
        let cHour = currentDate.getHours();
        if (cHour >= 10) {
            cHour = cHour;
        } else {
            cHour = "0" + cHour;
        }
        let cMinute = currentDate.getMinutes();
        if (cMinute >= 10) {
            cMinute = cMinute;
        } else {
            cMinute = "0" + cMinute;
        }
        let cTime = cHour + ":" + cMinute;
        let currentTime;
        if (cMonth < 10) {
            currentTime = cYear + "-0" + cMonth + "-" + cDay + "T" + cTime;
        } else {
            currentTime = cYear + "-" + cMonth + "-" + cDay + "T" + cTime;
        }
        // $('#time_end').val(currentTime);
    </script>
@endpush --}}
