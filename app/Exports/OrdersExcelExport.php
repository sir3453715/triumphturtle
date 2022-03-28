<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class OrdersExcelExport implements FromView
{
    public $data;

    public function __construct(array $data)
    {
        $this->data   = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('pdf.excel-package',[
            'order_data'=>$this->data,
        ]);

    }

    public function title(): string
    {
        // 設定工作䈬的名稱
        return '';
    }
}
