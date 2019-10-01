# Assign Elastic IP

To allocate an Elastic IP address from Amazon's pool of public IPv4 addresses using the console
	
	1. Open the Amazon EC2 console at https://console.aws.amazon.com/ec2/.
	
	2. In the navigation pane, choose Elastic IPs.
	
	3. Choose Allocate new address.
	
	4. For IPv4 address pool, choose Amazon pool.
	
	5. Choose Allocate, and close the confirmation screen.


To associate an Elastic IP address with an instance using the console

	1. Open the Amazon EC2 console at https://console.aws.amazon.com/ec2/.

	2. In the navigation pane, choose Elastic IPs.

	3. Select an Elastic IP address and choose Actions, Associate address.

	4. Select the instance from Instance and then choose Associate.



# SERVER SETUP COMMANDS

Before installation update ubuntu repositories:

	1. sudo apt update


### Installations

Apache:

	2. sudo apt install apache2

Adjust Firewall:

	3. sudo ufw app list

	4. sudo ufw allow Apache

Mysql:

 	5. sudo apt-get install mysql-server

 	6. sudo mysql_secure_installation

 	7. sudo ufw allow mysql
 	
	8 . Sudo mysql -uroot -p

Remote Login user

	9. CREATE USER 'administrator'@'%' IDENTIFIED BY 'xxxxxxxxxxxx';

Grant privileges to table(s)

	10. GRANT ALL PRIVILEGES ON *.* TO 'administrator'@'%' WITH GRANT OPTION;

	11. FLUSH PRIVILEGES; 

	12 .Change bind-address from 127.0.0.1 to 0.0.0.0
 
		sudo vim  /etc/mysql/mysql.conf.d/mysqld.cnf

	13. Restart mysql server:

		sudo systemctl restart mysql.service


UPDATE SECURITY GROUP

	14. Update security pool in aws to allow 3306 available
	15. Add http and https to security group in EC2 

	16. Install PHP
		sudo apt-get install php7.2
		sudo a2enmod php7.2
		sudo apt-get install php7.2-opcache php7.2-mbstring php-memcached
		sudo apt-get install php7.2-curl
		sudo apt-get install php7.2-mysql php7.2-soap


	17. Enable .htaccess
		sudo a2enmod rewrite

		Now open

			sudo vim /etc/apache2/sites-available/000-default.conf

		and write following code before </VirtualHost>

			<Directory /var/www/html>
					Options Indexes FollowSymLinks MultiViews
					AllowOverride All
					Require all granted
			</Directory>

	18. Restart Apache
		sudo systemctl restart apache2


	19. Pull Code from GIT
		sudo git clone https://github.com/ajaygautam/g2s-automation.git

	20. To install all dependencies -  download composer first
			sudo apt-get install curl
			cd ~
			sudo curl -s https://getcomposer.org/installer | php
			sudo mv composer.phar /usr/local/bin/composer
			composer

	21. Go to working directory and type:
			composer update


### Steps to Work with PPM and PPK file

	Steps 

		1. Convert pem file from aws to ppk in puttygen
		2. Login to putty with ppk file


### Restart servers

	Apache

		sudo systemctl restart apache2

	Mysql

		sudo systemctl status mysql.service
		sudo systemctl restart mysql.service

# Setting up Stripe Keys

Set up stripe keys in /keys.php out side Git Repo on the root folder. This will be included in the code through /config/settings.php file

	<?php
		return [
			'STRIPE_KEY' => 'YOUR_STRIPE_KEY',
			'STRIPE_SECRET' => 'YOUR_STRIPE_SECRET'
		];
	?>









