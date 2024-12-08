<?php
namespace app\controllers;

use yii\web\Controller;
use app\components\WebScraper;

class SiteController extends Controller
{
    public function actionScrape()
    {
        // 实例化爬虫并调用方法
        $scraper = new WebScraper();
        $scraper->scrapeArticles();
        return $this->render('scrape');
    }
}
