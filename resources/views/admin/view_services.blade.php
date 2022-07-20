@foreach ($checkin as $item)
    <button type="button" class="btn btn-info btn-md" data-toggle="modal"
        onclick="addService({{ $item->id_checkin_room }})">Thêm</button><br><br>
@endforeach
<div class="fresh-datatables">
    <table id="datatable_services" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
        style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên dịch vụ</th>
                <th>Số lượng</th>
                <th>Tổng giá thành</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $data)
                <tr>
                    <td>
                        <div style='height: 100px; overflow: auto;'>
                            {{ $index++ }}
                        </div>
                    </td>
                    <td>
                        <div style='height: 100px; overflow: auto;'>
                            {{ $data->name }}
                        </div>
                    </td>
                    <td>
                        <div style='height: 100px; overflow: auto;'>
                            {{ $data->amount }}
                        </div>
                    </td>
                    <td>
                        <div style='height: 100px; overflow: auto;'>
                            {{ $data->price }} VNĐ
                        </div>
                    </td>

                    <td class="text-right" style="text-align: center; overflow: auto;">
                        <button type="button" class="btn btn-info btn-warning btn-icon edit" data-toggle="modal"
                            onclick="editService({{ $data->id_service }})"><i class="fa fa-file-text-o"></i></button>
                        <button class="btn btn-danger lock" onclick="deleteService({{ $data->id_service }})"
                            style="height: 38px; width: 38px; padding: 0 8px 0 8px"><i class="fa fa-lock"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="insertForm-services" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="frm-services">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Thêm dịch vụ</h3>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <input type="hidden" class="form-control" id="id-checkin-room" name="id-checkin-room">
                        <input type="hidden" class="form-control" id="id-service" name="id-service">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tên dịch vụ:</label>
                                    <input type="text" class="form-control" id="name-service" name="name-service"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Số lượng:</label>
                                    <input type="number" class="form-control" id="amount-service" name="amount-service"
                                        min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tổng giá thành:</label>
                                    <input type="number" class="form-control" id="price-service" name="price-service"
                                        min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" onclick="saveService()">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script src="js/services.js"></script>
@push('js')
    <script>
        $(document).ready(function() {
            $('#datatable_services').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Tất cả"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Tìm kiếm",
                }

            });
        });
    </script>
@endpush
