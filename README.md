campustore
==========
http://54.163.241.123/campustore

An online web store for students community in universities. (CIS 525 term project)

How to deploy to your local machine:
1. If you can't upload files to server, it's typically caused by permission deny
. Please set your campustore/uploads/icons/ folder to writable to anyone.
   $sudo chmod a+w campustore/uploads/icons/

2. Database is deployed in AWS RDS. You don't need to config it.
   However, if you want to do that, you can setup your own mysql database by "FILE..." 
3. Database configuration info is in include/connection.php
4. If you can't connect to aws database, usually it means your devices is not in the RDS secure group. Please send your public ip address to me. I'll add your into it.

Steven Liu
10/07/2014
