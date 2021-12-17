# HOW TO GET STARTED
Make sure your machine as te following
- PHP 8.0
- Mysql 5.7 or up
- composer

##Message to onlooker
There's no CSRF protection. The setup of the project took bulk of the time (which frameworks provide out of the box). I had other obligations, unfortunately. 
The project is scalable. I couldn't make my vision a reality in the short amount of time. But it has some basic security like XSS and SQL injection protection. 
Didn't focus on styling at all. I hope you have a good day!

### Setup the environment
I have included a library to easily setup the environment. You have to make a `.env` file. The variables are added in `.env.example` file
```
cp .env.example .env
```
and put appropriate values

Next is the database migration. I didnt have time to set up a proper migration you'll have to import the included `entertech.sql` file. to import just type
```
mysql -u <user> -p <databasename> < entertech.sql
```
you should be golden on the Database front after that. admin credential is:
```
safayatjamil27@gmail.com
```
```
Password_4
```

To get started clone the repo and type
```
composer install
```

start the server by typing
```
php -S localhost:8000 -t public
```
your server will be started and you can access it by clicking here:

[Access Server](http://localhost:8000)

or directly go to
`
http://localhost:8000
`