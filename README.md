# BookStudyWeb 书斋 - 网上图书馆管理系统

目前正在开发中...

## 功能列表
- [x] 书籍详情页：提交数据的更改
- [x] 书籍详情页：点击封面更改图片
- [x] 图书管理页面：删除书
- [x] 图书馆里页面：添加新书
- [x] 用户管理页面：分页功能
- [x] 用户详情页：更改为表单形式
- [x] 用户详情页：还书
- [x] 登录页面：找回密码功能
- [x] 用户管理页面：搜索用户的功能
- [x] 图书管理页面：搜索图书的功能
- [x] 删除图书、用户需要确认管理员密码
- [x] 登录时检测是否已在其它设备登录
- [x] 注册页面：注册功能
- [ ] 系统管理员审核普通管理员的申请
- [ ] 用户详情页：管理员发送消息
- [ ] ~~管理员：点击头像展示管理员信息~~
- [ ] ...

## 部分截图展示
![主页](https://github.com/MonoKelvin/BookStudyWeb/blob/master/img/screenshot/home.png)
![主页](https://github.com/MonoKelvin/BookStudyWeb/blob/master/img/screenshot/login.png)
![主页](https://github.com/MonoKelvin/BookStudyWeb/blob/master/img/screenshot/book_management.png)
![主页](https://github.com/MonoKelvin/BookStudyWeb/blob/master/img/screenshot/book_info1.png)
![主页](https://github.com/MonoKelvin/BookStudyWeb/blob/master/img/screenshot/user_management.png)
![主页](https://github.com/MonoKelvin/BookStudyWeb/blob/master/img/screenshot/user_info.png)

## 数据库设计

### 用户表

​	为了能更快查找一些用户的基本信息而不涉及隐私数据，故将用户表拆分成两个表：userinfo 和 userprivate，前者只包含基本的用户信息，也是对于[客户端]( https://github.com/MonoKelvin/BookStudyApp )应用可见的，即客户端可以把这些数据缓存到本地，方便以后不使用账号密码直接使用ID、MD5验证登录；后者保存的是用户的隐私数据，比如账号、密码，这些数据客户端一般不能直接保存，而用户借书情况等数据只有在用户主动访问时服务器才请求数据库再发送给客户端。这些表会更具以后的开发再添加更多的字段，或拆分出更多的表，比如收藏书籍、第三方账号授权信息等。

#### UserInfo

##### 字段介绍

| int(11) | varchar(16) | char(32) | varchar(80) |
| ------- | ----------- | -------- | ----------- |
| id      | name        | md5      | avatar      |

* id：用户ID，唯一标识一个用户

* name：用户昵称

* md5：MD5校验，php生成依据：md5(id+account+password+time)

* avatar：用户头像，只保存头像地址，而不是具体的图像数据，比如：http://api.bookstudy.com/user/image/123626c8689420157ba4a7dbd47ce702.png



##### UserInfo 表结构的MySQL创建语句

```mysql
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE `userinfo`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(16) NOT NULL,
    `md5` char(32) NOT NULL,
    `avatar` varchar(80) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

```



#### UserPrivate

##### 字段介绍

| int(11) | varchar(32) | varchar(16) | bit(1) | text    | varchar(60) |
| ------- | ----------- | ----------- | ------ | ------- | ----------- |
| id      | account     | password    | online | message | verify_msg  |

* id：用户id，主键、外键约束

* account：账号，目前仅保存QQ邮箱，唯一约束

* password：密码，6-16个字符

* online：表示用户是否在线，1表示在线，0表示不在线，默认为0

* message：接受用户和管理员、服务器之间的消息缓冲区，比如管理员发送还书提醒等，目前该字段暂未用到。

* verify_msg：验证码消息缓存字段。保存发送的验证码，一般用在更能改密码时，在该系统中，验证码有效时间为5分钟。其格式为：

    ```text
    email,code,time		//比如xxxxxx@qq.com,123456,1578915326
    ```

##### UserPrivate 表结构的MySQL创建语句

```mysql

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `userprivate`;
CREATE TABLE `userprivate`  (
    `id` int(11) UNSIGNED NOT NULL,
    `account` varchar(32) NOT NULL,
    `password` varchar(16) NOT NULL,
    `online` bit(1) NOT NULL DEFAULT b'0',
    `message` text NULL,
    `verify_msg` varchar(60) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `account`(`account`) USING BTREE,
    CONSTRAINT `id` FOREIGN KEY (`id`) REFERENCES   `userinfo` (`id`) ON DELETE CASCADE ON UPDATE     CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

```

### 图书表

图书表和用户一样也分成了两个表：bookinfo、bookdetail，但不同的是bookinfo保存的时图书的基本信息，而bookdetail保存的时图书的详细信息，因为详细信息一般包含比较多的数据。对于[客户端]( https://github.com/MonoKelvin/BookStudyApp)来说，用户浏览书籍时只需要看到书籍的封面、书名、评分、作者、摘要这些最直观评价书记的内容的数据，而不需要看更多的细节，只有当用户想要查看书籍的详细资料时，客户端才会向服务器请求更多的数据。同样地，对于管理员来说亦是如此。

#### BookInfo

##### 表结构的MySQL创建语句

```mysql
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `bookinfo`;
CREATE TABLE `bookinfo`  (
    `id` int(11) UNSIGNED NOT NULL COMMENT '书的ID号，匹配豆瓣图书的subject后的id号',
    `title` varchar(100) NULL DEFAULT NULL COMMENT '标题',
    `author` varchar(100) NULL DEFAULT NULL COMMENT '作者，可能有多个',
    `publisher` varchar(32) NULL DEFAULT NULL COMMENT '出版社',
    `pages` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '页数',
    `pubdate` varchar(10) NULL DEFAULT NULL COMMENT '出版时间',
    `rating` decimal(2, 1) UNSIGNED ZEROFILL NULL DEFAULT NULL COMMENT '评价0.0-10.0',
    `image` varchar(80) NULL DEFAULT NULL COMMENT '图片地址',
    `summary` text NULL COMMENT '概要',
    `translator` varchar(32) NULL DEFAULT NULL COMMENT '翻译，可能有多个',
    `remaining` smallint(6) UNSIGNED NULL DEFAULT 1 COMMENT '书库里还剩余书的数量',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
```

#### BookDetail

##### 表结构的MySQL创建语句

```mysql
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `bookdetail`;
CREATE TABLE `bookdetail`  (
    `id` int(11) UNSIGNED NOT NULL,
    `isbn13` bigint(13) NOT NULL COMMENT 'ISBN分类',
    `subtitle` varchar(100) NULL DEFAULT NULL COMMENT '次标题',
    `origin_title` varchar(100) NULL DEFAULT NULL COMMENT '原标题',
    `binding` varchar(8) NULL DEFAULT NULL COMMENT '装帧',
    `tags` varchar(255) NULL DEFAULT NULL COMMENT '标签',
    `author_intro` text NULL COMMENT '作者信息',
    `catalog` text NULL COMMENT '章节目录',
    `price` varchar(16) NULL DEFAULT NULL COMMENT '价格，比如：108.00元',
    PRIMARY KEY (`id`) USING BTREE,
    CONSTRAINT `bookdetail_ibfk_1` FOREIGN KEY (`id`) REFERENCES `bookinfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
```


### 用户借书表 UserBooks

#### 字段介绍

| int(11) | int(11) | datetime  |
| ------- | ------- | --------- |
| u_id    | b_id    | lent_time |

* 用户ID：表示哪个用户借的书
* 书ID：表示用户借的哪本书
* lent_time：借书时间，格式为：yyyy-MM-dd hh:mm:ss

> 在该系统里，还书时间结束期限设置为30天



#### 表结构的Mysql创建语句

```mysql

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `userbooks`;
CREATE TABLE `userbooks`  (
    `u_id` int(11) UNSIGNED NOT NULL,
    `b_id` int(11) UNSIGNED NOT NULL,
    `lent_time` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`u_id`, `b_id`) USING BTREE,
    INDEX `b_id`(`b_id`) USING BTREE,
    CONSTRAINT `b_id` FOREIGN KEY (`b_id`) REFERENCES `bookinfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `u_id` FOREIGN KEY (`u_id`) REFERENCES `userinfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

```



### 管理员AdminInfo表

​管理员表很简单，只是把所有数据放在一个表内

#### 表结构的Mysql创建语句

```mysql

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `admininfo`;
CREATE TABLE `admininfo`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `account` varchar(32) NOT NULL,
    `name` varchar(16) NOT NULL,
    `password` varchar(16) NOT NULL,
    `avatar` varchar(80) NULL DEFAULT 'http://api.bookstudy.com/user/image/123626c8689420157ba4a7dbd47ce702.png',
    `online` bit(1) NULL DEFAULT b'0' COMMENT '是否在线',
    `message` text NULL COMMENT '接受其他管理员、用户发来的消息缓冲区',
    `verify_msg` varchar(60) NULL DEFAULT NULL COMMENT '验证消息：email(32) , code(5-6) , time(10)',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `account`(`account`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

```


### 注册消息队列Register_Queue表

​该表是为了解决管理员（用户注册实在客户端内注册，但以后更改为该方式）注册的问题，当多个管理员（或用户）同时注册时，服务器需要响应多个请求，故该表动态保存管理员（或用户）的注册请求。

#### 字段介绍

| int(11) | varchar(60) |
| ------- | ----------- |
| id      | verify_msg  |

* id：自动递增的注册请求
* verify_msg：同普通用户的verify_msg请求一样

> 该表在某个注册请求成功响应后就会删除对应的记录，但提出请求后却不注册时，就会造成记录的保持，占用空间，所以下一个版本中需要增加定时删除5分钟前的请求的功能。


## 图书数据的获取

​图书数据来源于豆瓣，比如《红楼梦》的json数据：[红楼梦](https://api.douban.com/v2/book/isbn/9787020002207?apikey=0df993c66c0c636e29ecbb5344252a4a)。目前该系统的数据库中只有100本书。

### 批量请求图书数据的php代码片段：

```php
<?php
require_once(dirname(__FILE__) . '\..\api\mysql_api.php');
require_once(dirname(__FILE__) . '\..\api\utility.php');

// 数据以链接的形式保存在books.txt文件中，每个链接以','隔开。
$booksFile = dirname(__FILE__) . '\books.txt';
$fp = fopen($booksFile, 'r');
$booksArray = fread($fp, filesize($booksFile));
fclose($fp);
$booksArray = explode(',', $booksArray);

// 打开数据库，数据库封装在 /api/mysql_api.php 中
$db = MySqlAPI::getInstance();
$book_ids = $db->getAll('select id from bookinfo');
$ids = [];
foreach ($book_ids as $val) {
    $ids[$val['id']] = $val['id'];
}

foreach ($booksArray as $book) {

    // 使用curl获取链接返回的数据
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $book);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    // 解析返回的json数据
    $json_obj = json_decode($response, true);
    $ret_code = @$json_obj['code'] ? $json_obj['code'] : 200;
    if ($json_obj == null || $json_obj == false || $ret_code != 200) {
        $db->close();
        die('json_decode_is_failed');
    }

    // 如果数据库中已存在该书，就继续。
    if (isset($ids[$json_obj['id']])) {
        continue;
    }

    // 获取图片地址
    $img_url = $json_obj['image'];
    $img_file_name = $json_obj['id'] . substr($img_url, strripos($img_url, '.'));
    $local_img_path = 'http://api.bookstudy.com/book/image/' . $img_file_name;

    // 基本信息的获取
    $author = implode(",", $json_obj['author']);
    $translator = implode(",", $json_obj['translator']);

    // 豆瓣图书的返回pages中有的pages带'页'字，而我们的page字段是int类型
    $pages = $json_obj['pages'];
    if (!is_numeric($pages)) {
        preg_match('/\d+/', $pages, $pages);
        $pages = $pages[0];
    }
    $data = [
        'id' => $json_obj['id'],
        'title' => addslashes($json_obj['title']),
        'author' => addslashes($author),
        'publisher' => addslashes($json_obj['publisher']),
        'pages' => $pages,
        'pubdate' => $json_obj['pubdate'],
        'rating' => $json_obj['rating']['average'],
        'image' => $local_img_path,
        'summary' => $json_obj['summary'],
        'translator' => addslashes($translator)
    ];
    $res = $db->insert('bookinfo', $data);

    // 详细信息的获取
    $tags = '';
    foreach ($json_obj['tags'] as $val) {
        $tags .= $val['name'] . ',';
    }
    $tags = trim($tags, ',');
    $data = [
        'id' => $json_obj['id'],
        'isbn13' => $json_obj['isbn13'],
        'subtitle' => addslashes($json_obj['subtitle']),
        'origin_title' => addslashes($json_obj['origin_title']),
        'binding' => $json_obj['binding'],
        'tags' => addslashes($tags),
        'author_intro' => addslashes($json_obj['author_intro']),
        'catalog' => addslashes($json_obj['catalog']),
        'price' => $json_obj['price']
    ];
    $res = $db->insert('bookdetail', $data);
}

$db->close();

```

