<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Thống kê đơn theo tháng';
    protected static ?string $width = 'full';
    protected function getData(): array
    {
        $doneOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->where('status', 1)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();

        $pendingOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->where('status', 0)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();

        $rejectOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->where('status', 2)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();
        $cancelOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->where('status', 3)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->all();

        $labels = [];
        $doneData = [];
        $pendingData = [];
        $rejectData = [];
        $cancelData = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = "T$i";
            $doneData[] = $doneOrders[$i] ?? 0;
            $pendingData[] = $pendingOrders[$i] ?? 0;
            $rejectData[] = $rejectOrders[$i] ?? 0;
            $cancelData[] = $cancelOrders[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Đơn chưa hoàn thành',
                    'data' => $pendingData,
                    'backgroundColor' => 'blue',
                    'borderWidth' => 0,
                ],
                [
                    'label' => 'Đơn hoàn thành',
                    'data' => $doneData,
                    'backgroundColor' => 'green',
                    'borderWidth' => 0,
                ],
                [
                    'label' => 'Đơn từ chối',
                    'data' => $rejectData,
                    'backgroundColor' => 'red',
                    'borderWidth' => 0,
                ],
                [
                    'label' => 'Đơn huỷ',
                    'data' => $cancelData,
                    'backgroundColor' => 'gray',
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
}
