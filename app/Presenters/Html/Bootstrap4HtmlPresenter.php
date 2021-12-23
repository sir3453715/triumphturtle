<?php

namespace App\Presenters\Html;

class Bootstrap4HtmlPresenter
{
    use BaseHtmlPresenter;

    /**
     * 返回Badge元件的Html
     *
     * @param string $content 內容
     * @param string $type 類型
     * @param bool $isPill 膠囊型態
     * @param bool $isLink 連結
     * @return string
     */
    public function badge(string $content = '', string $type = 'primary', $isPill = false, string $link = '')
    {
        $allowedTypes = [
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'light',
            'dark',
        ];
        if(in_array(strtolower($type), $allowedTypes)) {
            $tag = $link ? 'a' : 'span';
            $htmlArgs = [
                'class' => [
                    'badge',
                    'badge-' . $type,
                ],
                'role' => 'alert',
                'html' => $content
            ];
            if($isPill)
                $htmlArgs['class'][] = 'badge-pill';

            if($link)
                $htmlArgs['href'] = $link;

            return $this->tag($tag, $htmlArgs);
        } else {
            return '';
        }
    }

    /**
     * 返回Alert元件的Html
     *
     * @param string $content 內容，可包含連結，連結格式為:key，再於alertLink參數使用陣列指定傳入網址
     * @param $type string 類型
     * @param bool $dismiss 是否有關閉的按鈕
     * @param array $alertLinks 文字中連結，陣列格式為 key => url
     * @return string
     */
    public function alert(string $content = '', string $type = 'primary', $dismiss = true, array $alertLinks = [])
    {
        $allowedTypes = [
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'light',
            'dark',
        ];
        if(in_array(strtolower($type), $allowedTypes)) {
            if(!empty($alertLinks)) {
                foreach ($alertLinks as $key => $link) {
                    $linkHtmlArgs = [
                        'href'  => $link['url'],
                        'class' => 'alert-link',
                        'html'  => $link['content']
                    ];
                    if(!empty($link['target'])) {
                        $linkHtmlArgs['target'] = $link['target'];
                    }
                    $linkHtml = $this->tag('a', $linkHtmlArgs);
                    $content = str_replace(":$key", $linkHtml, $content);
                }
            }
            $dismissButtonHtml = '';
            if($dismiss) {
                $dismissButtonHtml = $this->tag('button', [
                    'type'         => 'button',
                    'class'        => 'close',
                    'data-dismiss' => 'alert',
                    'aria-label'   => 'Close',
                    'html' => $this->tag('span', [
                        'aria-hidden' => 'true',
                        'html' => '&times;'
                    ])
                ]);
            }
            $htmlArgs = [
                'class' => [
                    'alert',
                    'alert-' . $type,
                ],
                'html' => $content . $dismissButtonHtml
            ];

            if($dismiss) {
                $htmlArgs['class'][] = 'alert-dismissible fade show';
            }

            return $this->tag('div', $htmlArgs);
        } else {
            return '';
        }
    }

    /**
     * 返回Breadcrumb元件的Html
     *
     * @param array $items
     * @return string
     */
    public function breadcrumb(array $items = [])
    {
        $html = $this->tag('nav', [
            'aria-label' => 'breadcrumb',
            'html' => $this->tag('ol', [
                'class' => 'breadcrumb',
                'html' => function() use ($items) {
                    $itemsHtml = '';
                    foreach ((array)$items as $item) {
                        $args = [
                            'class' => [
                                'breadcrumb-item'
                            ],
                            'html' => !empty($item['content']) ? $item['content'] : ''
                        ];

                        if(!empty($item['active'])) {
                            $args['class'][] = 'active';
                            $args['aria-current'] = 'page';
                            $args['html'] = $this->tag('a', [
                                'href' => !empty($item['href']) ? $item['href'] : '#',
                                'html' => !empty($item['content']) ? $item['content'] : ''
                            ]);
                        }

                        $itemsHtml .= $this->tag('li', $args);
                    }
                    return $itemsHtml;
                }
            ])
        ]);
        return $html;
    }
}
