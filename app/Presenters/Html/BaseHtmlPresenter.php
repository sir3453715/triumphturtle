<?php

namespace App\Presenters\Html;

use App\Models\Order;
use App\Models\OrderBox;
use Arr;

trait BaseHtmlPresenter
{
    public function __call($name, $arguments)
    {
        return $this->tag($name, isset($arguments[0]) ? $arguments[0] : []);
    }

    public function getAttribute($key, $value = null)
    {
        if($value === null) {
            return "$key";
        } else{
            return "$key=\"{$value}\"";
        }
    }

    public function getAttributes($fieldArgs = [])
    {
        $attributes = [];
        $multiValueAttributes = [
            'class',
            'style',
        ];
        Arr::forget($fieldArgs, 'html');
        foreach ($fieldArgs as $name => $value) {
            if(in_array($name, $multiValueAttributes)) {
                if(is_array($value)) {
                    $value = array_filter($value);
                    $values = trim(implode(' ', $value));
                } else {
                    $values = $value;
                }
                array_push($attributes, $this->getAttribute($name, $values));
            } else {
                array_push($attributes, $this->getAttribute($name, $value));
            }
        }
        return trim(implode(' ', $attributes));
    }

    public function tag($tag, $fieldArgs = [], $echo = false)
    {
        $selfClosingTags = array(
            'area',
            'base',
            'br',
            'col',
            'command',
            'embed',
            'hr',
            'img',
            'input',
            'keygen',
            'link',
            'menuitem',
            'meta',
            'param',
            'source',
            'track',
            'wbr',
        );
        $htmlElements = !isset($fieldArgs['html']) ? '' : $fieldArgs['html'];
        $htmlContent = '';
        if(is_array($htmlElements)) {
            foreach ($htmlElements as $htmlElement) {
                if($htmlElement instanceof \Closure) {
                    $htmlContent .= call_user_func($htmlElement);
                } else {
                    $htmlContent .= $htmlElement;
                }
            }
        } elseif($htmlElements instanceof \Closure) {
            $htmlContent = call_user_func($htmlElements);
        } else {
            $htmlContent = $htmlElements;
        }

        $isSelfClosing = in_array($tag, $selfClosingTags);

        return '<' . trim(implode(' ', [$tag, $this->getAttributes($fieldArgs)])) . '>' .
            (!$isSelfClosing ? $htmlContent . '</' . $tag . '>' : '');
    }

    public function readonly($readonly = true)
    {
        return $readonly ? $this->getAttribute('readonly') : '';
    }

    public function disabled($disabled = true)
    {
        return $disabled ? $this->getAttribute('disabled', 'disabled') : '';
    }

    public function required($required = true)
    {
        return $required ? $this->getAttribute('required') : '';
    }

    public function checked($checked = true)
    {
        return $checked ? $this->getAttribute('checked', 'checked') : '';
    }

    public function checkChecked($currentValue, $comparedValue)
    {
        if(is_array($comparedValue)) {
            return in_array($currentValue, $comparedValue) ? $this->checked() : '';
        } else {
            return $currentValue == $comparedValue ? $this->checked() : '';
        }
    }

    public function selected($selected = true)
    {
        return $selected ? $this->getAttribute('selected', 'selected') : '';
    }

    public function selectSelected($currentValue, $comparedValue)
    {
        return $currentValue == $comparedValue ? $this->selected() : '';
    }

    public function sailingStatus($status){
        $html = '';
        switch ($status){
            case 1:
                $html = '<span class="cus-badge cus-badge-green">集貨中</span>';
                break;
            case 2:
                $html = '<span class="cus-badge cus-badge-orange">準備中</span>';
                break;
            case 3:
                $html = '<span class="cus-badge cus-badge-blue">開航中</span>';
                break;
            case 4:
                $html = '<span class="cus-badge cus-badge-teal">已抵達</span>';
                break;
            case 5:
                $html = '<span class="cus-badge cus-badge-gray">已取消</span>';
                break;
        }
        return $html;
    }

    public function sailingPrice($sailing){
        $sailing_id = $sailing->id;
        $status = $sailing->status;
        $minimum = $sailing->minimum;
        $box_interval = $sailing->box_interval;
        $order_ids = Order::where('sailing_id',$sailing_id)->pluck('id');
        $box_count = OrderBox::whereIn('order_id',$order_ids)->count();
        $html = '';
        if ($status == 1){
            if ($box_count >= $minimum){
                $price = $sailing->price;
                $interval = intval(floor($box_count/$box_interval));
                $margin = $box_count%$box_interval;
                for ($i = 0;$i<=$interval;$i++){
                    $price = ($price*$sailing->discount);
                }
                $html = '<div><img src="/storage/image/pack-icon.svg" alt="">已成團！差 <span class="data-number">'.$margin.'</span>箱即可享有優惠</div>
                            <div class="data-extra-info"><span>NT$ '.number_format($price).'</span> / 箱</div>';
            }else{
                $num = $minimum - $box_count;
                $html = '<div><img src="/storage/image/pack-icon.svg" alt="">差 <span class="data-number">'.$num.'</span>箱即可成團</div>';
            }
        }else{
            $price = $sailing->price;
            $interval = intval(floor($box_count/$box_interval));
            for ($i = 1;$i<=$interval;$i++){
                $price = ($price*$sailing->discount);
            }
            $html = '<div><img src="/storage/image/pack-icon.svg" alt="">已成團！已滿箱享有優惠價</div>
                            <div class="data-extra-info"><span>NT$ '.number_format($price).'</span> / 箱</div>';
        }
        return $html;

    }

}
