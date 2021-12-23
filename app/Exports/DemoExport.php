<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class DemoExport implements FromCollection, WithTitle, WithEvents, WithStrictNullComparison
{
    public $data;
    public $title;

    public function __construct(array $data,  $title,array $headings = array())
    {
        if(empty($headings)){
            $headings = [
                'id'=>"流水序號",
                'name'=>"姓名",
                'phone'=>"電話",
                'email'=>"信箱",
            ];
        }


        $this->data   = $data;
        $this->title  = $title;
        $this->headings  = $headings;
    }

    /**
     * registerEvents    freeze the first row with headings
     * @return array
     * @author   liuml  <[email protected]>
     * @DateTime 2018/11/1  11:19
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // 合併單元格
                $event->sheet->getDelegate()->setMergeCells(['A1:J1']);
                // 凍結窗格
                $event->sheet->getDelegate()->freezePane('A3');
                // 設定單元格內容居中
                $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // 定義列寬度
                $widths = ['A' => 20, 'B' => 20, 'C' => 20, 'D' => 20];
                foreach ($widths as $k => $v) {
                    // 設定列寬度
                    $event->sheet->getDelegate()->getColumnDimension($k)->setWidth($v);
                }
            },
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $export_data = [];
        $headings = $this->headings;
        foreach ($this->data as $key =>$output){
            foreach ($headings as $data_key=>$header){
                if($data_key == 'id'){
                    $export_data[$key][$data_key]=$key+1;
                }else{
                    $export_data[$key][$data_key]=$output[$data_key];
                }
            }
        }
        $title    = [$this->title];
        array_unshift($export_data, $title,  $headings);
        // 此處資料需要陣列轉集合
        return collect($export_data);
    }

    public function title(): string
    {
        // 設定工作䈬的名稱
        return $this->title;
    }
}
