# Atte(勤怠管理システム)

## 環境構築  

**Dockerビルド**  
```bash
1.git clone git@github.com:mmkano/AttendanceTracker.git  
2.DockerDesktopアプリを立ち上げる  
3.docker-compose up -d --build  
4.「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成  
5..envに以下の環境変数を追加  
DB_CONNECTION=mysql  
DB_HOST=mysql  
DB_PORT=3306  
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass  
6.アプリケーションキーの作成  
7.php artisan key:generate  
8.マイグレーションの実行  
php artisan migrate  
9.シーディングの実行  
php artisan db:seed --class=ComprehensiveSeeder  
 
