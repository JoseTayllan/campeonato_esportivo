# Deploying to Google Cloud Platform with SQLite

This guide provides step-by-step instructions for deploying the Championship Sports App to Google Cloud Platform (GCP) using SQLite as the database.

## Prerequisites

1. A Google Cloud Platform account
2. Google Cloud SDK installed on your local machine
3. Git repository with the SQLite branch

## Step 1: Set Up GCP Project

```bash
# Install Google Cloud SDK if not already installed
# https://cloud.google.com/sdk/docs/install

# Login to your Google Cloud account
gcloud auth login

# Create a new project (or use an existing one)
gcloud projects create [PROJECT_ID] --name="Championship Sports App"

# Set the project as the default
gcloud config set project [PROJECT_ID]

# Enable required APIs
gcloud services enable compute.googleapis.com
```

## Step 2: Create a Compute Engine Instance

```bash
# Create a VM instance for the application
gcloud compute instances create championship-app \
  --zone=us-central1-a \
  --machine-type=e2-medium \
  --image-family=debian-11 \
  --image-project=debian-cloud \
  --boot-disk-size=20GB \
  --tags=http-server,https-server

# Allow HTTP and HTTPS traffic
gcloud compute firewall-rules create allow-http \
  --direction=INGRESS \
  --action=ALLOW \
  --rules=tcp:80 \
  --target-tags=http-server

gcloud compute firewall-rules create allow-https \
  --direction=INGRESS \
  --action=ALLOW \
  --rules=tcp:443 \
  --target-tags=https-server
```

## Step 3: Configure the VM

SSH into your VM instance:

```bash
gcloud compute ssh championship-app
```

Install required software:

```bash
# Update package lists
sudo apt-get update

# Install Apache, PHP, Git, and other dependencies
sudo apt-get install -y apache2 php php-sqlite3 php-curl php-json php-mbstring php-xml php-zip unzip git composer

# Enable required Apache modules
sudo a2enmod rewrite
sudo systemctl restart apache2
```

## Step 4: Deploy Your Application

```bash
# Create the application directory
sudo mkdir -p /var/www/championship
sudo chown -R $USER:$USER /var/www/championship

# Clone your repository (using the SQLite branch)
git clone -b feature/sqlite https://github.com/your-username/campeonato_esportivo.git /var/www/championship

# Navigate to the application directory
cd /var/www/championship

# Install dependencies
composer install --no-dev --optimize-autoloader

# Initialize the SQLite database
php init_sqlite_db.php

# Set proper permissions
sudo chown -R www-data:www-data /var/www/championship
sudo chmod -R 755 /var/www/championship/storage
sudo chmod -R 755 /var/www/championship/db
```

## Step 5: Configure Apache

Create a virtual host configuration:

```bash
sudo nano /etc/apache2/sites-available/championship.conf
```

Add the following configuration:

```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/championship/public
    
    <Directory /var/www/championship>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/championship-error.log
    CustomLog ${APACHE_LOG_DIR}/championship-access.log combined
</VirtualHost>
```

Enable the site and restart Apache:

```bash
sudo a2ensite championship.conf
sudo a2dissite 000-default.conf
sudo systemctl reload apache2
```

## Step 6: Environment Configuration

Create or update your `.env` file:

```bash
nano /var/www/championship/.env
```

Update with the required configuration:

```
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=UTC
```

## Step 7: Set Up Automatic Backups (Important for SQLite)

Create a backup script:

```bash
sudo nano /usr/local/bin/backup-sqlite.sh
```

Add the following content:

```bash
#!/bin/bash
TIMESTAMP=$(date +"%Y%m%d%H%M%S")
DB_PATH="/var/www/championship/db/championship.sqlite"
BACKUP_DIR="/var/backups/championship"

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

# Create a backup
cp "$DB_PATH" "$BACKUP_DIR/championship-$TIMESTAMP.sqlite"

# Keep only the 10 most recent backups
ls -t $BACKUP_DIR/*.sqlite | tail -n +11 | xargs rm -f
```

Make the script executable:

```bash
sudo chmod +x /usr/local/bin/backup-sqlite.sh
```

Set up a cron job to run the backup daily:

```bash
sudo crontab -e
```

Add the following line:

```
0 2 * * * /usr/local/bin/backup-sqlite.sh
```

## Step 8: (Optional) Configure HTTPS with Let's Encrypt

Install Certbot:

```bash
sudo apt-get install certbot python3-certbot-apache -y
```

Obtain and install the SSL certificate:

```bash
sudo certbot --apache -d yourdomain.com
```

## Step 9: Set Up Health Monitoring

Enable Google Cloud monitoring:

```bash
# Install the monitoring agent
curl -sSO https://dl.google.com/cloudagents/add-monitoring-agent-repo.sh
sudo bash add-monitoring-agent-repo.sh
sudo apt-get update
sudo apt-get install stackdriver-agent -y
sudo service stackdriver-agent start
```

## Important Maintenance Tasks

### Periodically Optimize the Database

Create an optimization script:

```bash
sudo nano /usr/local/bin/optimize-sqlite.sh
```

Add the following content:

```bash
#!/bin/bash
DB_PATH="/var/www/championship/db/championship.sqlite"

# Perform VACUUM to reclaim space and defragment
sqlite3 "$DB_PATH" "VACUUM;"

# Analyze for query optimization
sqlite3 "$DB_PATH" "ANALYZE;"
```

Make it executable and add to cron:

```bash
sudo chmod +x /usr/local/bin/optimize-sqlite.sh
sudo crontab -e
```

Add the following line to run weekly:

```
0 3 * * 0 /usr/local/bin/optimize-sqlite.sh
```

## Troubleshooting

### Check Apache Error Logs

```bash
sudo tail -f /var/log/apache2/championship-error.log
```

### Verify Database Access

```bash
sudo -u www-data sqlite3 /var/www/championship/db/championship.sqlite .tables
```

### Permission Issues

```bash
sudo chown -R www-data:www-data /var/www/championship/db
sudo chmod 664 /var/www/championship/db/championship.sqlite
sudo chmod 775 /var/www/championship/db
```

## Security Best Practices

1. **Firewall**: Configure the VM's firewall to only allow necessary traffic
2. **Backup**: Ensure regular backups of the SQLite database file
3. **Updates**: Keep the system and all software packages updated
4. **File Permissions**: Use proper permissions for the SQLite database file

## Scaling Considerations

While SQLite is excellent for small to medium applications, consider these options if you need to scale:

1. Implement caching (e.g., Redis, Memcached)
2. Consider migrating to MySQL/PostgreSQL for very high traffic
3. Set up a load balancer if deploying multiple instances 