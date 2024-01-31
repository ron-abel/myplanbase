# Filevine Connect SAAS
SaaS consists of 3 main apps
- Super Admin Portal
- Tenant Admin portal : Contractor
- Client Portal : Bulder

## Sample Urls for portals
- Super Admin Portal : https://admin.myplanbase.com
- Tenant Clint Portal: http://first.myplanbase.com/
- Tenant Admin Portal: http://first.myplanbase.com/admin

"first" means the tenant name.
DB
UN: 
PW: 

# How to Install

## First, clone the repo on Wamp/Xampp
```
git clone <Git repo link>
```

## Second, set up the local DB with the latest backup
- create the db name "myplanbase" on mysql.
- should migrate the latest db format.
- Install sql file to the created DB on localhost or migrate

## Third, configure the Vhost on Wamp/Xampp and hosts on the system

set up virtual host configuration for the super admin and tenant portal on localhost. 

Reference this article, https://www.osradar.com/how-to-install-apache-virtual-host-in-windows-10/

localhost apache web server > httpd-vhosts.conf

Super admin: admin.myplanbase.com

one of the tenants : first.myplanbase.com

If you'd like to test another tenant, must set the tenant on vhost configuration file.  like this second.myplanbase.com

example: 

    <VirtualHost *:80>
        ServerName admin.myplanbase.com
        ServerAlias admin.myplanbase.com
        DocumentRoot "${INSTALL_DIR}/www/myplanbase/public"
        <Directory "${INSTALL_DIR}/www/myplanbase/public">
            Options +Indexes +Includes +FollowSymLinks +MultiViews
            AllowOverride All
            Require local
        </Directory>
    </VirtualHost>

    <VirtualHost *:80>
        ServerName first.myplanbase.com
        ServerAlias first.myplanbase.com
        DocumentRoot "${INSTALL_DIR}/www/myplanbase/public"
        <Directory "${INSTALL_DIR}/www/myplanbase/public">
            Options +Indexes +Includes +FollowSymLinks +MultiViews
            AllowOverride All
            Require local
        </Directory>
    </VirtualHost>
    ```

## Fourth, Set up laravel project on localhost
- copy ".env.example" and past with rename. ".env"
    On .env file, need to set up Twilio credential info, so, it's possible to make it works on localhost.
- "composer install" to install laravel packages. 
- visit the site superadmin portal :  admin.myplanbase.com
- visit the site tenant portal : first.myplanbase.com

# How to Use the app

## First, log in the super admin portal with the below credential
```
Email: superadmin@myplanbase.com
Password: "Abc123"
```

## Second, create the tenant in admin.myplanbase.com/admin/tenants

Once you create the tenant on the superadmin, the tenant app is available with <tenant_name>.myplanbase.com.

The Credential of this tenant admin is <tenant_name>.admin@myplanbase.com / <tenant_name>password

## Third, the tenant user can log in the tenant admin and configure the needed settings
- Once the tenant admin logs in its admin site, <tenat_name>.myplanbase.com/admin with the above credential, he can update his name, email, and password.
- Next, he needs to configure the settings on Setting / Credential page, <tenat_name>.myplanbase.com/admin/settings
- Once the settings are configured, the client portal <tenat_name>.myplanbase.com is available.

## FOR MAC USING MAMP PRO
Each time the database updates, we must recompile.
In terminal, navigate to the root folder of the saas using the "cd" command.
Install composer packages with command "composer install"
Run the last command "php artisan migrate --force"
Restart the MAMP server and load host.


## Connect to MySQL in hosting server, using Terminal
- Connect Hosting server using Putty. 
    To connect to the SSH, need to know IP of the hosting server and username, PPK file key.
- Once connect to the SSH, need to connect DB using MYSQL command. 
    https://www.hostmysite.com/support/linux/mysql/access/ 
    
