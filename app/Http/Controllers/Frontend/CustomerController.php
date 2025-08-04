<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Http\Requests\Customer\EditProfileRequest;
use App\Http\Requests\Customer\RecoverCustomerPasswordRequest;
use App\Models\Order;
use App\Repositories\Interfaces\ConstructRepositoryInterface as ConstructRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Services\Interfaces\ConstructServiceInterface as ConstructService;
use App\Services\Interfaces\CustomerServiceInterface as CustomerService;
use App\Services\Interfaces\OrderServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends FrontendController
{

    protected $customerService;
    protected $constructRepository;
    protected $constructService;
    protected $customer;
    protected $orderService;
    protected $orderRepository;

    public function __construct(
        CustomerService       $customerService,
        ConstructRepository   $constructRepository,
        ConstructService      $constructService,
        OrderServiceInterface $orderService,
        OrderRepository       $orderRepository,
        ProvinceRepository    $provinceRepository,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->customerService = $customerService;
        $this->constructService = $constructService;
        $this->constructRepository = $constructRepository;
        $this->orderService = $orderService;
        $this->provinceRepository = $provinceRepository;
        parent::__construct();

    }


    public function profile()
    {

        $customer = Auth::guard('customer')->user();

        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang quản lý tài khoản khách hàng' . $customer['name'],
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('customer.profile')
        ];
        return view('frontend.auth.customer.profile', compact(
            'seo',
            'system',
            'customer',
        ));
    }

    public function order()
    {

        $customer = Auth::guard('customer')->user();
        $orders = $this->orderService->getOrderByCustomer($customer->id);

        $system = $this->system;
        $seo = [
            'meta_title' => 'Lịch sử đơn hàng của ' . $customer->name,
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('customer.order'),
        ];
//        dd($orders);
        return view('frontend.auth.customer.orders', compact(
            'orders',
            'customer',
            'seo',
            'system'
        ));
    }

    public function orderDetail($code)
    {
        $customer = Auth::guard('customer')->user();

        $order = $this->orderRepository->findByCodeAndCustomer($code, $customer->id);
        if (!$order) {
            abort(404);
        }

        $order->load('products'); // load quan hệ nếu cần

        $order = $this->orderService->getOrderItemImage($order);
        $provinces = $this->provinceRepository->all();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Chi tiết đơn hàng #' . $order->code,
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('customer.order.detail', ['code' => $order->code]),
        ];

        return view('frontend.auth.customer.order_detail', compact(
            'order',
            'customer',
            'seo',
            'provinces',
            'system'
        ));
    }


    public function updateProfile(EditProfileRequest $request)
    {
        $customerId = Auth::guard('customer')->user()->id;
        if ($this->customerService->update($customerId, $request)) {
            return redirect()->route('customer.profile')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('customer.profile')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function passwordForgot()
    {

        $customer = Auth::guard('customer')->user();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang thay đổi mật khẩu' . $customer['name'],
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('customer.profile')
        ];
        return view('frontend.auth.customer.password', compact(
            'seo',
            'system',
            'customer',
        ));
    }

    public function recovery(RecoverCustomerPasswordRequest $request)
    {
        $customer = Auth::guard('customer')->user();

        if (!Hash::check($request->password, $customer->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không chính xác.');
        }
        // Thay đổi mật khẩu
        $customer->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('customer.profile')->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('home.index')->with('success', 'Bạn đã đăng xuất khỏi hệ thống.');
    }

    public function construction(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $condition = [
            'keyword' => $request->input('keyword'),
            'confirm' => $request->input('confirm')
        ];
        $constructs = $this->constructRepository->findConstructByCustomer($customer->id, $condition);
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang quản lý danh sách công trình của ' . $customer['name'],
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('customer.profile')
        ];

        return view('frontend.auth.customer.construction', compact(
            'seo',
            'system',
            'customer',
            'constructs',
        ));
    }


    public function constructionProduct($id)
    {
        $customer = Auth::guard('customer')->user();

        $construction = $this->constructRepository->findById($id, ['*'], ['products']);

        $system = $this->system;
        $seo = [
            'meta_title' => 'Chi tiết sản phẩm công trình ' . $construction->name . ' của ' . $customer['name'],
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('customer.profile')
        ];
        return view('frontend.auth.customer.product', compact(
            'seo',
            'system',
            'customer',
            'construction',
        ));
    }

    public function warranty(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $condition = [
            'keyword' => $request->input('keyword'),
            'confirm' => $request->input('status')
        ];

        $warranty = $this->constructRepository->warranty($customer->id, $condition);


        $system = $this->system;
        $seo = [
            'meta_title' => 'Thông tin kích hoạt bảo hành',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('customer.profile')
        ];
        return view('frontend.auth.customer.warranty', compact(
            'seo',
            'system',
            'customer',
            'warranty',
        ));
    }


    public function active(Request $request)
    {
        $response = $this->constructService->activeWarranty($request, 'active');
        return response()->json($response);

    }

    public function cancelOrder(Request $request, $code)
    {
        $order = Order::where('code', $code)->firstOrFail();


        $reason = $request->cancel_reason === 'Khác' ? $request->custom_reason : $request->cancel_reason;


        $order->cancel_reason = $reason;
        $order->bank_account = $request->bank_account;
        $order->account_owner = $request->account_owner;
        $order->updated_at = now();
        $order->confirm = 'pending_cancel';

        $order->save();

        return redirect()->back()->with('success', 'Yêu cầu huỷ đơn hàng đã được gửi thành công.');
    }

}
