# MongoDB clustering
Nama: Dewi Ayu Nirmalasari<br>
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
    ```
        vagrant init
    ```
2. Memodifikasi Vagrantfile menjadi sebagai berikut.
    ```ruby
    # -*- mode: ruby -*-
    # vi: set ft=ruby :

    Vagrant.configure("2") do |config|

    (1..2).each do |i|
        config.vm.define "mongo_config_#{i}" do |node|
        node.vm.hostname = "mongo-config-#{i}"
        node.vm.box = "bento/ubuntu-18.04"
        node.vm.network "private_network", ip: "192.168.115.#{i+1}"

        node.vm.provider "virtualbox" do |vb|
            vb.name = "mongo-config-#{i}"
            vb.gui = false
            vb.memory = "512"
        end

        node.vm.provision "shell", path: "bash/mongo_config#{i}.sh", privileged: false
        end
    end

    config.vm.define "mongo_query_router" do |mongo_query_router|
        mongo_query_router.vm.hostname = "mongo-query-router"
        mongo_query_router.vm.box = "bento/ubuntu-18.04"
        mongo_query_router.vm.network "private_network", ip: "192.168.115.4"
        
        mongo_query_router.vm.provider "virtualbox" do |vb|
        vb.name = "mongo-query-router"
        vb.gui = false
        vb.memory = "512"
        end

        mongo_query_router.vm.provision "shell", path: "bash/mongo_router.sh", privileged: false
    end

    (1..3).each do |i|
        config.vm.define "mongo_shard_#{i}" do |node|
        node.vm.hostname = "mongo-shard-#{i}"
        node.vm.box = "bento/ubuntu-18.04"
        node.vm.network "private_network", ip: "192.168.115.#{4+i}"
            
        node.vm.provider "virtualbox" do |vb|
        vb.name = "mongo-shard-#{i}"
        vb.gui = false
        vb.memory = "512"
        end

        node.vm.provision "shell", path: "bash/mongo_shard#{i}.sh", privileged: false
        end
    end

    end
    ```
### 3. Provisioning
1. Provision untuk `allhosts`
    ```sh
    # Add hostname
    sudo cp /vagrant/sources/hosts /etc/hosts

    # Copy APT sources list
    sudo cp '/vagrant/sources/sources.list' '/etc/apt/'
    sudo cp '/vagrant/sources/mongodb.list' '/etc/apt/sources.list.d/'

    sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 4B7C549A058F8B6B

    # Update Repository
    sudo apt-get update
    # sudo apt-get upgrade -y

    # Install MongoDB
    sudo apt-get install -y mongodb-org

    # bug asdljaskldal
    sudo mkdir -p /data/db
    sudo rm /tmp/mongodb-27017.sock
    sudo chown vagrant:vagrant /data/db
    sudo mkdir -p /var/run/mongodb
    sudo touch /var/run/mongodb/mongod.pid
    sudo chown -R  mongodb:mongodb /var/run/mongodb/
    sudo chown mongodb:mongodb /var/run/mongodb/mongod.pid

    # Start MongoDB
    sudo service mongod start
    ```

2. Provision untuk `mongo-config1` dan `mongo-config2`
    ```sh
    sudo bash /vagrant/bash/allhosts.sh

    # Override mongod config with current config
    sudo cp /vagrant/config/mongodcsvr1.conf /etc/mongod.conf

    # Restart the mongo service 
    sudo systemctl restart mongod
    ```

3. Provision untuk `mongo-query-router`
    ```sh
    sudo bash /vagrant/bash/allhosts.sh

    # Override mongod config with current config
    sudo cp /vagrant/config/mongos.conf /etc/mongos.conf

    # Create new service file
    sudo touch /lib/systemd/system/mongos.service
    sudo cp /vagrant/service/mongos.service /lib/systemd/system/mongos.service

    # Stop current mongo service
    sudo systemctl stop mongod

    # Enable mongos.service
    sudo systemctl enable mongos.service
    sudo systemctl start mongos

    # Confirm mongos is running
    systemctl status mongos
    ```

4. Provision untuk `mongo-shard1`, `mongo-shard2`, dan `mongo-shard3`
    ```sh
    sudo bash /vagrant/bash/allhosts.sh

    # Override mongod config with current config
    sudo cp /vagrant/config/mongodshardsvr1.conf /etc/mongod.conf

    # Restart the mongo service 
    sudo systemctl restart mongod
    ```

### 4. Konfigurasi

### 5. File Tambahan
- File `hosts`
    ```
    192.168.115.2 mongo-config-1
    192.168.115.3 mongo-config-2
    192.168.115.4 mongo-query-router
    192.168.115.5 mongo-shard-1
    192.168.115.6 mongo-shard-2
    192.168.115.7 mongo-shard-3
    ```
- File `mongos.service`
    ```sh
    [Unit]
    Description=Mongo Cluster Router
    After=network.target

    [Service]
    User=mongodb
    Group=mongodb
    ExecStart=/usr/bin/mongos --config /etc/mongos.conf
    # file size
    LimitFSIZE=infinity
    # cpu time
    LimitCPU=infinity
    # virtual memory size
    LimitAS=infinity
    # open files
    LimitNOFILE=64000
    # processes/threads
    LimitNPROC=64000
    # total threads (user+kernel)
    TasksMax=infinity
    TasksAccounting=false

    [Install]
    WantedBy=multi-user.target
    ```
## Konfigurasi MongoDB Cluster

