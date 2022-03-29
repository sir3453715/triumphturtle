<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderBox;
use App\Models\OrderBoxItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PdfExportController extends Controller
{

    function pdfDelivery(Request $request,$id){
        $order_data = Order::find($id)->toArray();
        $order_data['OrderBoxes']=OrderBox::where('order_id',$id)->get()->toArray();
        $order_data['OrderBoxesItems']=OrderBoxItem::where('order_id',$id)->get()->toArray();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.delivery-order',$order_data)->setPaper('a4')->setOptions(['dpi' => 140, 'defaultFont' => 'msyh' , 'isFontSubsettingEnabled'=>true ,'isRemoteEnabled'=>true]);
        return $pdf->stream();
    }

    function pdfShipment(Request $request,$id){
        $pdfData['OrderBoxes'] = OrderBox::where('order_id',$id)->orderBy('box_seccode','ASC')->get()->toArray();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.shipment-order',$pdfData)->setPaper('a4')->setOptions(['dpi' => 140, 'defaultFont' => 'msyh' , 'isFontSubsettingEnabled'=>true ,'isRemoteEnabled'=>true]);
        return $pdf->stream();
    }
    function pdfPackage(Request $request,$id){
        $parentOrder = Order::find($id);
        $order_data = $parentOrder->toArray();
        $order_data['fromCountry']=$parentOrder->sailing->fromCountry->title.' '.$parentOrder->sailing->fromCountry->en_title;
        $order_data['toCountry']=$parentOrder->sailing->toCountry->title.' '.$parentOrder->sailing->toCountry->en_title;
        $packageOrderIDs = Order::where('serial_number',$parentOrder['serial_number'])->orderBy('parent_id','ASC')->pluck('id')->toArray();
        $packageBoxes = OrderBox::whereIn('order_id',$packageOrderIDs)->orderBy('box_seccode','ASC')->get();
        foreach ($packageBoxes as $packageBox){
            $order_data['OrderBoxes'][$packageBox->id]=$packageBox->toArray();
            $order_data['OrderBoxes'][$packageBox->id]['OrderBoxesItems']=OrderBoxItem::where('box_id',$packageBox->id)->orderBy('id','ASC')->get()->toArray();
            $total_value = 0;
            foreach ($order_data['OrderBoxes'][$packageBox->id]['OrderBoxesItems'] as $key => $boxesItem){
                $total_value += ($boxesItem['unit_price']*$boxesItem['item_num']);
            }
            $order_data['OrderBoxes'][$packageBox->id]['total_value'] = $total_value;
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.package',$order_data)->setPaper('a4')->setOptions(['dpi' => 140, 'defaultFont' => 'msyh' , 'isFontSubsettingEnabled'=>true ,'isRemoteEnabled'=>true]);
        return $pdf->stream();
    }
    function pdfPayment(Request $request,$id){
        $order = Order::find($id);
        $other_total = 0;
        $order_data = $order->toArray();
        $order_data['sailing']=$order->sailing->toArray();
        $order_data['box_count'] = count($order->box);
        if($order_data['other_price']){
            $other_price = unserialize($order_data['other_price']);
            $order_data['other_price']=$other_price;
            foreach ($other_price as $other){
                $other_total += $other['other_qty']*$other['other_unit'];
            }
        }
        $order_data['subtotal'] = $order_data['sailing']['final_price'] * count($order->box);
        if($other_total > 0 ){
            $order_data['subtotal'] += $other_total;
        }
        $order_data['tax_value'] = ($order_data['invoice'] != 1)? $order_data['subtotal'] * 0.05 * count($order->box) :0 ;
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.payment',$order_data)->setPaper('a4')->setOptions(['dpi' => 140, 'defaultFont' => 'msyh' , 'isFontSubsettingEnabled'=>true ,'isRemoteEnabled'=>true]);
        return $pdf->stream();
    }
    public function shipmentOrder()
    {
        return view('pdf.default-shipment');
    }

    public function deliveryOrder()
    {
        return view('pdf.default-delivery');
    }
    public function package()
    {
        return view('pdf.default-package');
    }
    public function paymentBilling()
    {
        return view('pdf.default-payment');
    }

}
