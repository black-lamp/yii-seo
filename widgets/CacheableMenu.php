<?php
namespace bl\seo\widgets;

use bl\cms\shop\common\entities\Category;
use Yii;
use yii\caching\DbDependency;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

abstract class CacheableMenu extends Menu
{
    public $cacheKey;
    public $cacheDependency;
    public $dropDownTemplate;

    public function init()
    {
        if(!empty(Yii::$app->cache) && !empty($this->cacheKey)) {
            $this->items = Yii::$app->cache->getOrSet($this->cacheKey . '_' . Yii::$app->language, function () {
                return array_merge($this->items, $this->getItems());
            }, 0, $this->cacheDependency);
        } else {
            $this->items = array_merge($this->items, $this->getItems());
        }
        parent::init();
    }

    protected abstract function getItems();

    public static function widget($config = [])
    {
        return parent::widget($config);
    }

    protected function renderItem($item)
    {

        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode($item['url']),
                '{label}' => $item['label'],
            ]);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

            return strtr($template, [
                '{label}' => $item['label'],
            ]);
        }
    }

    protected function isItemActive($item)
    {
        if(!empty($item['url'])) {
            return Yii::$app->request->url == $item['url'];
        }

        return false;
    }


}