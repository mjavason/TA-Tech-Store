# tats(Tech Acoustic Tech Store)
This is a simple ecommerce site for electronics(pointing out electronics because the database is modelled after them. Needing fields like specs, ram etc).  
  
  The site is made with mainly PHP and JavaScript. There's no particular reason for the use of these two apart from availability and experimentation.  
  
  The site was challenging in that i had to find harmony in combining PHP and JavaScript and trying to make it as asynchronous as possible.  
  I plan to make the sites frontend a bit more appealing. The cms should also be made a lot easier to use.  
  ## Table of Contents
  1. How to install and run the site locally
  2. How to use the site(Admin/User)
  3. How to contribute
  
  
### How to install and run the site locally
I use a windows operating system, so my explanation might be a bit limited, but with a little googling you should be able to do the same with any other OS.  

The site is made mainly with php so you'll need a localhost to be able to run the code. I use XAMPP, an apache emulator. You can download it for any machine [here](https://www.apachefriends.org/download.html).  
After installation, go to the folder you installed it in, then htdocs and copy the project to it. The file path will look something like this: C:\xampp\htdocs\tats  

Make sure the virtual server is running, then go to this address in your browser: localhost\phpmyadmin and create a database called tats. After the folder is succesfully created, import the mysql file 'tats.sql' located in the root folder of the project, if successful, your done.

On your browser go to this address: localhost/tats/ and the home page should load up.  
### How to use the site
Once you load up the site, the rest should be easy. To login into the admin section, use 'admin@mail.com' as the email and 'admin' as the password.  
If you're going to make use of the paystack payment gateway then go to this folder: localhost/tats/admin/functions/functions.php in the loadPaystackCode and verifyPayment functions, pass in your keys.
### How to contribute
If you find any part of the site you can improve, just fork the project, work on your own copy then send me a pull request, i reply as soon as possible. Do try to make the pull request as small as possible, that way its easier to read through them.
