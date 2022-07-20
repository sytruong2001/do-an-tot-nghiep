@foreach ($checkin as $item)
    <button type="button" class="btn btn-info btn-md" data-toggle="modal"
        onclick="addAdditionalFee({{ $item->id_checkin_room }})">Thêm</button><br><br>
@endforeach
<div class="fresh-datatables">
    <table id="datatable_additional_fee" class="table table-striped table-no-bordered table-hover" cellspacing="0"
        width="100%" style="width:100%">
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
            @foreach ($additional_fee as $data)
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
                            onclick="editAdditionalFee({{ $data->id_additional_fee }})"><i
                                class="fa fa-file-text-o"></i></button>
                        <button class="btn btn-danger lock"
                            onclick="deleteAdditionalFee({{ $data->id_additional_fee }})"
                            style="height: 38px; width: 38px; padding: 0 8px 0 8px"><i class="fa fa-lock"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="insertForm-additional-fee" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="frm-additional-fee">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle-additional-fee"></h3>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <input type="hidden" class="form-control" id="id-checkin-room" name="id-checkin-room">
                        <input type="hidden" class="form-control" id="id-additional-fee" name="id-additional-fee">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tên sản phẩm:</label>
                                    <input type="text" class="form-control" id="name-prod" name="name-prod" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Số lượng:</label>
                                    <input type="number" class="form-control" id="amount-prod" name="amount-prod"
                                        min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tổng giá thành:</label>
                                    <input type="number" class="form-control" name="price-prod" id="price-prod"
                                        min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-additional-fee"
                        data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" onclick="saveAdditionalFee()">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script src="js/additional_fee.js"></script>
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable_additional_fee').DataTable({
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
    <script>
        $('#insertForm').on('shown.bs.modal', function() {
            $('#insertForm').trigger('focus')
        })
    </script>
@endpush
