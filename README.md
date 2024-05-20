# Deploying Docker Application to AWS EC2 and DigitalOcean Droplets

This guide provides steps to deploy a Docker-based PHP application to AWS EC2 and DigitalOcean droplets.

## Prerequisites

- AWS EC2 instance with Ubuntu
- DigitalOcean droplet with Ubuntu
- SSH access to your instances
- Docker and Docker Compose installed on your local machine

## Steps

### 1. Connect to Your Instance

#### AWS EC2

```bash
ssh -i ~/Downloads/hovahyii.pem ubuntu@47.129.44.171
```

#### DigitalOcean Droplet

```bash
ssh root@<your_droplet_ip>
```

### 2. Install Docker on the Instance

#### Update and Install Docker

```bash
sudo apt update
sudo apt install -y docker.io
sudo systemctl enable docker
sudo systemctl start docker
```

#### Verify Docker Installation

```bash
docker --version
```

### 3. Install Docker Compose

```bash
sudo apt install -y docker-compose
```

### 4. Transfer Docker Application Files

#### Using `scp` to Transfer Files

```bash
scp -i ~/Downloads/hovahyii.pem -r C:/Users/shado/OneDrive/Desktop/runcloud/hovah ubuntu@47.129.44.171:/home/ubuntu/
```

Replace the paths and IP address accordingly for DigitalOcean:

```bash
scp -r C:/Users/shado/OneDrive/Desktop/runcloud/hovah root@<your_droplet_ip>:/root/
```

### 5. Build and Run Docker Containers

#### Navigate to the Project Directory

```bash
cd /home/ubuntu/hovah   # AWS
cd /root/hovah          # DigitalOcean
```

#### Build and Run with Docker Compose

```bash
sudo docker-compose up --build -d
```

### 6. Fix File Permission Issues

If you encounter permission issues with file uploads:

#### Change Ownership and Permissions

```bash
sudo chown -R www-data:www-data /path/to/your/uploads/directory
sudo chmod -R 755 /path/to/your/uploads/directory
```

### 7. Access Your Services

#### For AWS EC2

```bash
http://47.129.44.171:8080  # Your application
http://47.129.44.171:8081  # phpMyAdmin
```

#### For DigitalOcean Droplet

```bash
http://<your_droplet_ip>:8080  # Your application
http://<your_droplet_ip>:8081  # phpMyAdmin
```

### Example Dockerfile

```bash
# Use the official PHP image as a base image
FROM php:7.4-apache

# Set the ServerName directive
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install Node.js and npm
RUN apt-get update && \\
    apt-get install -y curl && \\
    curl -sL https://deb.nodesource.com/setup_14.x | bash - && \\
    apt-get install -y nodejs

# Enable mod_rewrite
RUN a2enmod rewrite

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli

# Copy project files to the working directory
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Change ownership and permissions
RUN chown -R www-data:www-data /var/www/html/uploads
RUN chmod -R 755 /var/www/html/uploads
```

### Example docker-compose.yml

```bash
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: hovah_space
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
    networks:
      - hovah_net
    depends_on:
      - db

  db:
    image: mysql:5.7
    container_name: hovah_db
    environment:
      MYSQL_ROOT_PASSWORD: password
      MYSQL_DATABASE: mywall
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql
      - ./init.sql:/docker-entrypoint-initdb.d/init.sql
    networks:
      - hovah_net

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: phpmyadmin
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: password
    ports:
      - "8081:80"
    depends_on:
      - db
    networks:
      - hovah_net

networks:
  hovah_net:
    driver: bridge

volumes:
  db_data:
```

### 8. Automate SSL Certificate Renewal (Optional)

If you set up SSL, make sure to automate certificate renewal:

#### Create a Cron Job for Automatic Renewal

```bash
sudo crontab -e
```

Add the following line:

```bash
0 0,12 * * * /usr/bin/certbot renew --quiet
```

### Conclusion

By following these steps, you can deploy your Docker-based PHP application to both AWS EC2 and DigitalOcean droplets. Ensure to update any placeholder values with your actual configuration.

For any further assistance or issues, please refer to the documentation or seek help from the respective communities.

### Like this project? You can show your appreciation by buying Hovah a coffee ☕

<a target="_blank" rel="noopener noreferrer" href="https://www.buymeacoffee.com/hovahyii"><img src="https://github.com/appcraftstudio/buymeacoffee/raw/master/Images/snapshot-bmc-button.png" width="300" style="max-width:100%;"></a>



