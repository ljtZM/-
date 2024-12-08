<?php
namespace app\components;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class WebScraper
{
    public function scrapeArticles()
    {
        // 创建一个 HttpBrowser 实例
        $client = new HttpBrowser(HttpClient::create());
        
        // 发送 GET 请求
        $crawler = $client->request('GET', 'https://example.com/articles');
        
        // 使用 CSS 选择器筛选文章元素
        $crawler->filter('.article')->each(function ($node) {
            $title = $node->filter('h2')->text();
            $content = $node->filter('.content')->text();
            
            // 创建并保存 Article 模型
            $article = new \app\models\Article();
            $article->title = $title;
            $article->content = $content;
            $article->save();
        });
    }
}
