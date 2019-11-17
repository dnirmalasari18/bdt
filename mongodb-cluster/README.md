# MongoDB clustering
Nama: Dewi Ayu Nirmalasari
NRP: 05111640000115

## Content

## Implementasi MongoDB Cluster
### 1. Pembagian IP dan Spesifikasinya
Terdapat 6 server, yaitu:
- Server config sebanyak 2, dengan spesifikasi:
    - OS: `bento/ubuntu-18.04`
    - RAM: 512 MB
    - IP: `192.168.115.2` dan `192.168.115.3`
- Server query 
    - OS: `bento/ubuntu-18.04`
    - RAM: 512 MB
    - IP: `192.168.115.4`
- Server Data/Shard sebanyak 3 buah
    - OS: `bento/ubuntu-18.04`
    - RAM: 512 MB
    - IP: `192.168.115.5`, `192.168.115.6`, dan `192.168.115.7`
### 2. Vagrant
1. Membuat Vagrantfile<br>
    ```vagrant init```
2. Memodifikasi Vagrantfile meenjadi sebagai berikut.

### 3. Provisioning
### 4. Konfigurasi
### 5. File Tambahan