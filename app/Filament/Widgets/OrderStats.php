<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        $orders = Order::count();
        $orderDone = Order::where('status', 1)->count();
        $orderDoneTotal = Order::where('status', 1)->sum('price');
        return [
            Stat::make('Tổng số đơn', $orders),
            Stat::make('Số đơn hoàn thành', $orderDone),
            Stat::make('Tổng tiền', number_format($orderDoneTotal, 0, ',', '.') . ' đ'),
        ];
    }
}
