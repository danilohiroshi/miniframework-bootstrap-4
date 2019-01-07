# NBR - Landing page

# Set up environment

- Install Docker: http://docs.docker.com/engine/installation/
- Install docker-compose: https://docs.docker.com/compose/install/
- Configure NFS (Linux & Mac OS):
  - sudo apt-get install nfs-common
- Install node
  - curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.0/install.sh | bash
  - export NVM_DIR="~/.nvm"
  - nvm install v6.11.5
  - nvm alias default node
  - node --version
- Install Yarn
  - npm -g i yarn

# Start environment

```bash
cd docker
./start-environment
```

# Enter cli mode

```bash
docker exec -it nbr-docker-app bash
```

# Mailhog

http://nbr.local.com:8025
