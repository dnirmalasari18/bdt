# EAS
Nama: Dewi Ayu Nirmalasari<br>
NRP: 05111640000115

## Content
## Implementasi Arsitektur
### Desain Arsitektur
### Vagrant
1. Membuat file vagrant dengan mengetikkan
    ```
    vagrant init
    ```
2. Mengubah Vagrantfile menjadi seperti berikut
    ```
    ```
3. Provisioning
    ```
    ```

4. Menjalan kan vagrant
    ```
    vagrant up
    ```
5. Konfigurasi TiDB
    ```
    ```

## Pemanfaatan Basis Data Terdistribusi dalam Aplikasi
Aplikasi yang digunakan disini adalah aplikasi lpencerdas yang dibuat Lab Pemrograman 1 Informatika ITS. Langkah-langkah deploy:
1. Membuat user untuk database lalu membuat database-nya.
    ```sh    
    mysql -u root -h 192.168.16.115 -P 4000 -e "create user if not exists 'user'@'%' identified by 'password'; grant all privileges on lpencerdas.* to 'user'@'%'; flush privileges;";
    mysql -u user -h 192.168.16.115 -P 4000 -p
    ```
    ```sql
    CREATE DATABASE lpencerdas;
    ```

2. Instalasi LPencerdas
    ```sh
    git clone https://github.com/lpif/lpencerdas.git
    composer install
    composer dump-autoload
    cp .env.example .env
    php artisan key:generate
    ```

3. Mengubah .env menjadi seperti berikut
    ```
    DB_CONNECTION=mysql
    DB_HOST=192.168.16.115
    DB_PORT=6033
    DB_DATABASE=lpencerdas
    DB_USERNAME=user
    DB_PASSWORD=password
    ```

4. Install tidb-laravel milik evvo sesuasi dengan petunjuk di [sini](https://github.com/evvo/tidb-laravel)

### Create

### Read
### Update
### Delete
## Uji Performa Aplikasi dan Basis Data
### JMeter
* 
### Sysbench
### Aplikasi
### Basis Data
### Uji Fail Over

## Monitoring Dashboard Menggunakan Grafana
