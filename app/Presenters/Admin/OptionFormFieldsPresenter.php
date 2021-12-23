<?php

namespace App\Presenters\Admin;

use App\Presenters\Html\HtmlPresenter;
use Arr;

class OptionFormFieldsPresenter
{

    public function render()
    {
        $options = config('options');
        $presenter = app('Html');
        $optionRepo = app('Option');
        $html = '';
        if(!empty($options['fields'])) {
            foreach($options['fields'] as $key => $option) {
                $label = !empty($option['label']) ? $option['label'] : $key;
                $html .= $presenter->div([
                    'class' => 'form-group row',
                    'html'  =>  [
                        $presenter->div([
                            'class' => 'col-12 col-md-2',
                            'html'  => $presenter->label([
                                'for' => 'option-' . $key,
                                'html' => $label
                            ])
                        ]),
                        $presenter->div([
                            'class' => 'col-12 col-md-10',
                            'html'  => function() use ($key, $option, $presenter, $optionRepo) {
                                $html = '';
                                $type = !empty($option['type']) ? $option['type'] : 'text';
                                $required = !empty($option['required']) && $option['required'] ? true : false;
                                $bastHtmlArgs = [
                                    'name'  => $key,
                                    'id'    => 'option-' . $key,
                                ];
                                switch ($type) {
                                    case 'text':
                                    case 'password':
                                    case 'email':
                                    case 'number':
                                        $htmlArgs = array_merge([
                                            'type'  => $type,
                                            'value' => $optionRepo->$key,
                                            'class' => 'form-control',
                                        ], $bastHtmlArgs);

                                        if($required)
                                            $htmlArgs['required'] = null;

                                        $html .= $presenter->input($htmlArgs);

                                        if(isset($option['help'])){
                                            $Args = array_merge([
                                                'class' => 'notice-msg',
                                                'id'    => 'option-' . $key.'-notice',
                                                'html'  =>  $option['help'],
                                            ]);
                                            $html .= $presenter->p($Args);
                                        }
                                        break;
                                    case 'checkbox':
                                        $htmlArgs = array_merge([
                                            'type'  => 'checkbox',
                                            'value' => 1,
                                        ], $bastHtmlArgs);

                                        if($optionRepo->$key) {
                                            $htmlArgs['checked'] = 'checked';
                                        }

                                        $html .= $presenter->input($htmlArgs);

                                        if(isset($option['help'])){
                                            $Args = array_merge([
                                                'class' => 'notice-msg',
                                                'id'    => 'option-' . $key.'-notice',
                                                'html'  =>  $option['help'],
                                            ]);
                                            $html .= $presenter->p($Args);
                                        }
                                        break;
                                    case 'textarea':
                                        $htmlArgs = array_merge([
                                            'html' => $optionRepo->$key,
                                            'class' => 'form-control',
                                        ], $bastHtmlArgs);

                                        if($required)
                                            $htmlArgs['required'] = null;

                                        if(!empty($option['row']))
                                            $htmlArgs['rows'] = $option['row'];

                                        $html .= $presenter->textarea($htmlArgs);

                                        if(isset($option['help'])){
                                            $Args = array_merge([
                                                'class' => 'notice-msg',
                                                'id'    => 'option-' . $key.'-notice',
                                                'html'  =>  $option['help'],
                                            ]);
                                            $html .= $presenter->p($Args);
                                        }
                                        break;
                                    case 'editor':
                                        $htmlArgs = array_merge([
                                            'html' => $optionRepo->$key,
                                            'class' => 'custom-editor',
                                            'data-weight' => $option['weight'],
                                        ], $bastHtmlArgs);

                                        $html .= $presenter->textarea($htmlArgs);
                                        break;
                                    case 'select':
                                        $selectOptions = !empty($option['options']) ? $option['options'] : null;
                                        $htmlArgs = array_merge([
                                            'class' => 'form-control',
                                        ], $bastHtmlArgs);
                                        $currentValue = $optionRepo->$key;
                                        if(!empty($selectOptions)) {
                                            $htmlArgs['html'] = function() use ($currentValue, $selectOptions, $presenter) {
                                                $html = '';
                                                foreach ($selectOptions as $value => $label) {
                                                    $htmlArgs = [
                                                        'value' => $value,
                                                        'html'  => trans('form.options.' . $label),
                                                    ];
                                                    if($currentValue == $value) {
                                                        $htmlArgs['selected'] = 'selected';
                                                    }
                                                    $html .= $presenter->option($htmlArgs);
                                                }
                                                return $html;
                                            };
                                        }

                                        if($required)
                                            $htmlArgs['required'] = null;

                                        $html .= $presenter->select($htmlArgs);

                                        if(isset($option['help'])){
                                            $Args = array_merge([
                                                'class' => 'notice-msg',
                                                'id'    => 'option-' . $key.'-notice',
                                                'html'  =>  $option['help'],
                                            ]);
                                            $html .= $presenter->p($Args);
                                        }
                                        break;
                                    case 'radio':
                                        $radioOptions = !empty($option['options']) ? $option['options'] : null;
                                        $currentValue = $optionRepo->$key;
                                        $defaultValue = !empty($option['default']) ? $option['default'] : null;
                                        if(!empty($radioOptions)) {
                                            foreach ($radioOptions as $value => $label) {
                                                $html .= $presenter->div([
                                                    'class' => 'form-check',
                                                    'html' => function() use ($key, $currentValue, $defaultValue, $label, $value, $radioOptions, $presenter) {
                                                        $html = '';
                                                        $inputId = 'option-' . $key . '-' . $value;

                                                        $inputHtmlArgs = [
                                                            'type'  => 'radio',
                                                            'class' => 'form-check-input',
                                                            'name'  => $key,
                                                            'id'    => $inputId,
                                                            'value' => $value
                                                        ];

                                                        if($currentValue === null) {
                                                            if($defaultValue && $defaultValue == $value) {
                                                                $inputHtmlArgs['checked'] = 'checked';
                                                            } elseif(array_key_first($radioOptions) == $value) {
                                                                $inputHtmlArgs['checked'] = 'checked';
                                                            }
                                                        } elseif($currentValue == $value) {
                                                            $inputHtmlArgs['checked'] = 'checked';
                                                        }

                                                        $html .= $presenter->input($inputHtmlArgs);

                                                        $html .= $presenter->label([
                                                            'class' => 'form-check-label',
                                                            'for'   => $inputId,
                                                            'html'  => $label
                                                        ]);
                                                        return $html;
                                                    }
                                                ]);
                                            }
                                        }
                                        break;
                                }
                                return $html;
                            }
                        ]),
                    ]
                ]);
            }
        }
        return $html;
    }
}
