Commands

Before installation update ubuntu repositories:

	1. sudo apt update


Installations

Apache
	2. sudo apt install apache2

Adjust Firewall
	3. sudo ufw app list

From <https://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-ubuntu-18-04-quickstart> 

	4. sudo ufw allow Apache

From <https://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-ubuntu-18-04-quickstart> 

Mysql

 5. sudo apt-get install mysql-server

From <https://tecadmin.net/install-mysql-5-on-ubuntu/> 

 6. sudo mysql_secure_installation

From <https://support.rackspace.com/how-to/installing-mysql-server-on-ubuntu/> 

	7. sudo ufw allow mysql
	
	From <https://support.rackspace.com/how-to/installing-mysql-server-on-ubuntu/> 
	
	
8 . Sudo mysql -uroot -p



Remote Login user

9. CREATE USER 'administrator'@'%' IDENTIFIED BY 'Ju8$sp!002';

# grant privileges to table(s)
	10. GRANT ALL PRIVILEGES ON *.* TO 'administrator'@'%' WITH GRANT OPTION;

From <http://jslim.net/blog/2016/06/06/aws-ec2-enable-remote-access-on-mysql/> 

	11. FLUSH PRIVILEGES; 





12 .Change bind-address from 127.0.0.1 to 0.0.0.0
 
Sudo vim  /etc/mysql/mysql.conf.d/mysqld.cnf

	13. Restart mysql server:

sudo systemctl restart mysql.service

	14. Update security pool in aws to allow 3306 available 


Steps 

	1. Convert pem file from aws to ppk in puttygen
	2. Login to putty with ppk file

Sudo chmod -R a+rwx /opt/lampp/htdocs



Restart servers

Apache

sudo systemctl restart apache2

From <https://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-ubuntu-18-04-quickstart> 


Mysql
sudo systemctl status mysql.service
sudo systemctl restart mysql.service


Important: Add http and https to security group in EC2


PHP

sudo apt-get install php7.2
 sudo a2enmod php7.2
sudo apt-get install php7.2-opcache php7.2-mbstring php-memcached
sudo apt-get install php7.2-curl
 sudo apt-get install php7.2-mysql php7.2-soap


Enable .htaccess
Sudo a2enmod rewrite

-> Now open

Sudo vim /etc/apache2/sites-available/000-default.conf

From <https://hostadvice.com/how-to/how-to-enable-apache-mod_rewrite-on-an-ubuntu-18-04-vps-or-dedicated-server/> 


-> and write following code before </VirtualHost>

<Directory /var/www/html>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
</Directory>

From <https://hostadvice.com/how-to/how-to-enable-apache-mod_rewrite-on-an-ubuntu-18-04-vps-or-dedicated-server/> 


Assign Elastic IP

To allocate an Elastic IP address from Amazon's pool of public IPv4 addresses using the console
	1. Open the Amazon EC2 console at https://console.aws.amazon.com/ec2/.
	2. In the navigation pane, choose Elastic IPs.
	3. Choose Allocate new address.
	4. For IPv4 address pool, choose Amazon pool.
	5. Choose Allocate, and close the confirmation screen.

From <https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/elastic-ip-addresses-eip.html> 


To associate an Elastic IP address with an instance using the console
	1. Open the Amazon EC2 console at https://console.aws.amazon.com/ec2/.
	2. In the navigation pane, choose Elastic IPs.
	3. Select an Elastic IP address and choose Actions, Associate address.
	4. Select the instance from Instance and then choose Associate.

From <https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/elastic-ip-addresses-eip.html> 


