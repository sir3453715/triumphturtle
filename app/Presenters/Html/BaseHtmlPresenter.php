<?php

namespace App\Presenters\Html;

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
}
