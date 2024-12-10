import requests
from bs4 import BeautifulSoup
import json
import os

# 爬取文章摘要和链接
def scrape_articles():
    url = "https://search.cctv.com/search.php?qtext=%E4%BA%BA%E5%B7%A5%E6%99%BA%E8%83%BD&sort=relevance&type=web&vtime=&datepid=1&channel=%E6%96%B0%E9%97%BB&page=4"
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36"
    }
    response = requests.get(url, headers=headers)
    if response.status_code != 200:
        print("Failed to fetch the webpage")
        return []

    soup = BeautifulSoup(response.text, "html.parser")
    articles = []

    for li in soup.find_all("li", class_="image"):
        # 提取标题
        title_tag = li.find("a", id=lambda x: x and x.startswith("web_content_"))
        title = title_tag.text.strip() if title_tag else "No Title"

        # 提取文章链接
        link = title_tag["href"] if title_tag else None
        if link and link.startswith("link_p.php"):
            link = link.split("targetpage=")[1].split("&")[0]
            link = requests.utils.unquote(link)  # 解码链接

        # 提取摘要
        summary_tag = li.find("p", class_="bre")
        summary = summary_tag.text.strip() if summary_tag else "No Summary"

        # 提取发布时间
        time_tag = li.find("span", class_="tim")
        publish_time = time_tag.text.strip().replace("发布时间：", "") if time_tag else "Unknown"

        # 提取全文内容和作者
        content, author = scrape_article_content_and_author(link, headers) if link else ("No Content", "Unknown Author")

        # 跳过 content 为空的文章
        if not content.strip():
            continue

        articles.append({
            "title": title,
            "summary": summary,
            "content": content,
            "author": author,
            "publish_time": publish_time,
            "link": link
        })

    return articles


# 爬取文章全文内容和作者信息
def scrape_article_content_and_author(link, headers):
    try:
        response = requests.get(link, headers=headers)

        # 自动推断网页编码，防止乱码
        response.encoding = response.apparent_encoding

        if response.status_code != 200:
            return "Failed to fetch the article content", "Unknown Author"

        soup = BeautifulSoup(response.text, "html.parser")

        # 假设全文内容在 <div class="content_area"> 中，请根据实际结构调整
        content_div = soup.find("div", class_="content_area")
        content = ""
        if content_div:
            paragraphs = content_div.find_all("p")
            content = "\n".join(p.text.strip() for p in paragraphs if p.text.strip())

        # 提取作者信息
        source_tag = soup.find("meta", attrs={"name": "source"})
        author_tag = soup.find("meta", attrs={"name": "author"})
        source = source_tag["content"].strip() if source_tag else "Unknown Source"
        author_name = author_tag["content"].strip() if author_tag else "Unknown Author"
        author = f"{source}：{author_name}"

        return content, author
    except Exception as e:
        return "", "Unknown Author"


# 保存数据到文件
def save_articles_to_file(new_articles, file_path):
    # 如果文件存在，读取现有内容
    if os.path.exists(file_path):
        with open(file_path, "r", encoding="utf-8") as f:
            try:
                existing_articles = json.load(f)
            except json.JSONDecodeError:
                existing_articles = []
    else:
        existing_articles = []

    # 合并现有内容和新内容，确保去重
    combined_articles = {article["link"]: article for article in existing_articles}
    for article in new_articles:
        combined_articles[article["link"]] = article  # 使用链接作为唯一标识

    # 写回文件
    with open(file_path, "w", encoding="utf-8") as f:
        json.dump(list(combined_articles.values()), f, ensure_ascii=False, indent=4)


if __name__ == "__main__":
    articles = scrape_articles()
    save_articles_to_file(articles, "articles.json")
    print(f"Articles saved to articles.json with {len(articles)} new entries.")