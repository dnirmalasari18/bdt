sudo bash /vagrant/bash/allhosts.sh

# Override mongod config with current config
sudo cp /vagrant/config/mongodshardsvr1.conf /etc/mongod.conf

# Restart the mongo service 
sudo systemctl restart mongod

# Add shards
# mongo mongo-query-router:27017 -u mongo-admin -p --authenticationDatabase admin < /vagrant/mongo/add_shards.mongo

# Enable shards
# mongo mongo-query-router:27017 -u mongo-admin -p --authenticationDatabase admin < /vagrant/mongo/enable_shard.mongo