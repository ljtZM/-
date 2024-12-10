import json
import pymysql

# 数据库配置信息
DB_CONFIG = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "yii2basic",
    "port": 3306,
}

# 读取 articles.json 文件
def load_articles(file_path):
    try:
        with open(file_path, "r", encoding="utf-8") as file:
            return json.load(file)
    except Exception as e:
        print(f"Error reading JSON file: {e}")
        return []

# 上传数据到数据库
def upload_to_database(articles):
    connection = None
    try:
        # 连接数据库
        connection = pymysql.connect(**DB_CONFIG)
        cursor = connection.cursor()

        # 插入文章数据
        insert_query = """
        INSERT INTO articles (title, content, summary, author, publication_date)
        VALUES (%s, %s, %s, %s, %s)
        """
        for article in articles:
            try:
                cursor.execute(
                    insert_query,
                    (
                        article["title"],
                        article["content"],
                        article.get("summary", ""),
                        article["author"],
                        article.get("publish_time", None),
                    ),
                )
            except Exception as e:
                print(f"Failed to insert article '{article['title']}': {e}")

        # 提交事务
        connection.commit()
        print(f"Successfully uploaded {cursor.rowcount} articles.")
    except Exception as e:
        print(f"Error connecting to database: {e}")
    finally:
        if connection:
            connection.close()

if __name__ == "__main__":
    # 文件路径
    json_file_path = "articles.json"

    # 加载 JSON 数据
    articles = load_articles(json_file_path)
    if not articles:
        print("No articles to upload.")
    else:
        upload_to_database(articles)
