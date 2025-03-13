# Radio ID 申请网站

这是一个用于申请和管理 Radio ID 的网站，支持湖南省的 14 个行政区域。

## 功能
- 用户申请 Radio ID。
- 管理员审核申请。

## 部署
1. 将项目文件上传到 Server 的 `www` 目录。

2. 配置数据库连接（`includes/db.php`）创建radio_db数据库。

   ```sql
   CREATE TABLE radio_ids (
       id INT AUTO_INCREMENT PRIMARY KEY,
       radio_id BIGINT UNIQUE NOT NULL, -- Radio ID
       name VARCHAR(255) NOT NULL,    -- 用户姓名
       qq VARCHAR(255) NOT NULL,      -- 用户 QQ
       region VARCHAR(255) NOT NULL,  -- 用户所在区域
       status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending', -- 申请状态
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- 申请时间
   );
   ```

   然后创建管理员账号数据库

   ```sql
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(191) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL
   ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

   

3. 访问 `application/index.php` 提交申请。

4. 访问 `admin/index.php` 管理后台。

## By BI7ACC