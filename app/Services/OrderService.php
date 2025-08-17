<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\ProductVariantRepositoryInterface as ProductVariantRepository;
use App\Services\Interfaces\OrderServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomerService
 * @package App\Services
 */
class OrderService extends BaseService implements OrderServiceInterface
{
    protected $orderRepository;
    protected $productVariantRepository;
    protected $productRepository;


    public function __construct(
        OrderRepository          $orderRepository,
        ProductVariantRepository $productVariantRepository,
        ProductRepository        $productRepository,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->productRepository = $productRepository;
    }


    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        foreach (__('cart') as $key => $val) {
            $condition['dropdown'][$key] = $request->string($key);
        }
        $condition['created_at'] = $request->input('created_at');


        $perPage = $request->integer('perpage');
        $orders = $this->orderRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'order/index'],
            ['id', 'desc'],
        );

        return $orders;
    }

//    public function update($request)
//    {
//        DB::beginTransaction();
//        try {
//            $id = $request->input('id');
//            $payload = $request->input('payload');
//
//            // Lấy đơn hàng trước khi cập nhật
//            $orderBefore = $this->orderRepository->findById($id);
//
//            // Cập nhật đơn hàng
//            $this->orderRepository->update($id, $payload);
//
//            // Lấy đơn hàng sau khi cập nhật
//            $orderAfter = $this->orderRepository->findById($id);
//
//            // Nếu đơn hàng được giao thành công và đã thanh toán thì gửi mail
//            if (
//                $orderAfter->delivery === 'success' &&
//                $orderAfter->payment === 'paid' &&
//                $orderAfter->mail_sent != 1 // tránh gửi nhiều lần
//            ) {
//                \Mail::to($orderAfter->email)->queue(new \App\Mail\OrderCompleted($orderAfter));
//
//                // Đánh dấu đã gửi mail
//                $this->orderRepository->updateById($id, ['mail_sent' => 1]);
//            }
//
//            DB::commit();
//            return true;
//        } catch (\Exception $e) {
//            DB::rollBack();
//            echo $e->getMessage(); die();
//            return false;
//        }
//    }


    public function update($request)
    {
        DB::beginTransaction();
        try {
            $id = $request->input('id');
            $payload = $request->input('payload');
            $this->orderRepository->update($id, $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function updatePaymentOnline($payload, $order)
    {
        DB::beginTransaction();
        try {
            $this->orderRepository->update($order->id, $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }


    public function getOrderItemImage($order)
    {
        foreach ($order->products as $key => $val) {
            $uuid = $val->pivot->uuid;
            if (!is_null($uuid)) {
                $variant = $this->productVariantRepository->findByCondition([
                    ['uuid', '=', $uuid]
                ]);
                $variantImage = explode(',', $variant->album)[0] ?? null;
                $val->image = $variantImage;
            }
        }

        return $order;

    }

    public function statistic()
    {
        $month = now()->month;
        $year = now()->year;
        $previousMonth = ($month == 1) ? 12 : $month - 1;
        $previousYear = ($month == 1) ? $year - 1 : $year;


        $orderCurrentMonth = $this->orderRepository->getOrderByTime($month, $year);
        $orderPreviousMonth = $this->orderRepository->getOrderByTime($previousMonth, $previousYear);

        return [
            'orderCurrentMonth' => $orderCurrentMonth,
            'orderPreviousMonth' => $orderPreviousMonth,
            'grow' => growth($orderCurrentMonth, $orderPreviousMonth),
            'totalOrders' => $this->orderRepository->getTotalOrders(),
            'cancleOrders' => $this->orderRepository->getCancleOrders(),
            'revenue' => $this->orderRepository->revenueOrders(),
            'revenueChart' => convertRevenueChartData($this->orderRepository->revenueByYear($year)),
        ];


    }

    public function ajaxOrderChart($request)
    {
        $type = $request->input('chartType');
        switch ($type) {
            case 1:
                $year = now()->year;
                $response = convertRevenueChartData($this->orderRepository->revenueByYear($year));
                break;
            case 7:
                $response = convertRevenueChartData($this->orderRepository->revenue7Day(), 'daily_revenue', 'date', 'Ngày');
                break;
            case 30:

                $currentMonth = now()->month;
                $currentYear = now()->year;
                $daysInMonth = Carbon::createFromDate($currentYear, $currentMonth, 1)->daysInMonth;

                $allDays = range(1, $daysInMonth);
                $temp = $this->orderRepository->revenueCurrentMonth($currentMonth, $currentYear);
                $label = [];
                $data = [];
                $temp2 = array_map(function ($day) use ($temp, &$label, &$data) {
                    $found = collect($temp)->first(function ($record) use ($day) {
                        return $record['day'] == $day;
                    });
                    $label[] = 'Ngày ' . $day;
                    $data[] = $found ? $found['daily_revenue'] : 0;

                }, $allDays);
                $response = [
                    'label' => $label,
                    'data' => $data,
                ];
                break;
        }
        return $response;

    }


    private function paginateSelect()
    {
        return [
            'id',
            'code',
            'fullname',
            'phone',
            'email',
            'province_id',
            'district_id',
            'ward_id',
            'address',
            'description',
            'promotion',
            'cart',
            'customer_id',
            'guest_cookie',
            'method',
            'confirm',
            'payment',
            'delivery',
            'shipping',
            'created_at',
        ];
    }

    public function getOrderByCustomer($customerId)
    {
        return Order::where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->with(['products'])
            ->get();
    }


}
