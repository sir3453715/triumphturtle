<?php

namespace App\Repositories;

use App\Models\Option;
use Illuminate\Support\Facades\Cache;
/**
 * Class OptionRepository
 * @package App\Repositories
 *
 * @property \App\Option $model
 * @method \App\Option getModel()
 */
class OptionRepository extends BaseRepository
{

    private $cacheKeyPrefix = 'options_';

    public function __construct(Option $option)
    {
        $this->setModel($option);
    }

    public function __get($key)
    {
        return $this->getOption($key);
    }

    public function __set($key, $value)
    {
        $this->setOption($key, $value);
    }

    /**
     * 新增Option
     *
     * @param $key
     * @param $value
     * @return void
     */
    public function addOption($key, $value)
    {
        if(is_string($key) && $key) {
            if(!is_string($value)) {
                if(is_bool($value) || is_null($value)) {
                    $value = (string) $value;
                } else {
                    $value = serialize($value);
                }
            }
            $this->model->updateOrInsert(['key' => $key], ['value' => $value]);
            Cache::forget($this->cacheKeyPrefix . $key);
        }
    }

    /**
     * 更新Option
     *
     * @param $key
     * @param $value
     * @return void
     */
    public function setOption($key, $value)
    {
        $this->addOption($key, $value);
    }

    /**
     * 取得Option
     *
     * @param $key
     * @return mixed
     */
    public function getOption($key)
    {
        if(Cache::has($this->cacheKeyPrefix . $key)) {
            return Cache::get($this->cacheKeyPrefix . $key);
        }
        $value = null;
        try {
            $option = $this->model->where(['key' => $key])->first();
            if($option) {
                $value = @unserialize($option->value);
                if($value === false) {
                    $value = $option->value;
                }
            } else {
                $value = null;
            }
            Cache::put($this->cacheKeyPrefix . $key, $value);
        } catch(\Exception $e) {}

        return $value;
    }

    /**
     * 刪除Option
     *
     * @param $key
     * @throws \Exception
     * @return void
     */
    public function deleteOption($key)
    {
        $option = $this->model->where('key', $key)->first();
        if($option) {
            $option->delete();
            Cache::forget($this->cacheKeyPrefix . $key);
        }
    }

    /**
     * 批次更新Options
     *
     * @param $options
     * @return void
     */
    public function setOptions($options)
    {
        if(is_array($options)) {
            foreach ($options as $key => $value) {
                $this->setOption($key, $value);
            }
        }
    }
}
