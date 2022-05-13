## Web-interface database of registered site users
### What services you need to run the project
```
web: 
    nginx:
engine:
    php: 7.x or 8.x
db:
    MySQL: 5.x
```
### Project run instructions
#### Windows (Openserver)
```
Put the project folder in the 'domains' folder, which is located in the folder with the Openserver executable file.
```
#### Linux
```
1. Put the 'default.conf' file in the following directory:
/etc/nginx/conf.d
(as a result /etc/nginx/conf.d/default.conf)
2. Put the project folder in the folowing directory:
/var/www/html
(as a result /var/www/html/web-interface)
```
### Setting up database access
```
Configure database access in ./config/connect.php file
changing username and password if needed
```
### Login
```
To login with administrator rights: 
login - 'admin',
password - 'admin'.
```