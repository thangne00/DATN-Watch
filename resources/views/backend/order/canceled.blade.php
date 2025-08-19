<h1>Danh sách đơn hàng yêu cầu hủy</h1>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Lý do hủy</th>
            <th>Thời gian</th>
            <th>Tài khoản hoàn tiền</th>
            {{-- <th>Bill hoàn tiền</th>--}}
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $order)
            <tr>
                <td>{{ $order->code }}</td>
                <td>{{ $order->fullname }}</td>
                <td>{{ $order->created_at->format('d/m/Y - H:i') }}</td>
                <td>
                    @if($order->confirm === 'pending_cancel')
                        <span class="badge badge-warning">Yêu cầu hủy</span>
                    @elseif($order->confirm === 'cancel')
                        <span class="badge badge-secondary">Đã hủy</span>
                    @else
                        <span class="badge badge-success">-</span>
                    @endif
                </td>
                <td>{{ $order->cancel_reason }}</td>
                <td>{{  $order->updated_at->format('d/m/Y - H:i') }}</td>
                <td>{{ $order->bank_account ?? "NO"}} - {{ $order->account_owner}}</td>
                {{-- <td>--}}
                    {{-- @if($order->refund_bill)--}}
                    {{-- <a href="{{ asset($order->refund_bill) }}" target="_blank">Xem ảnh</a>--}}
                    {{-- @else--}}
                    {{-- Không có--}}
                    {{-- @endif--}}
                    {{-- </td>--}}
                <td>
                    <a href="{{ route('order.detail', $order->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                    <!-- Có thể thêm nút duyệt hủy, hủy hủy, xử lý hoàn tiền... -->
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Chưa có đơn hàng yêu cầu hủy</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $orders->links() }}