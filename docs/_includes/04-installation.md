# Installation
To install the software the following steps are necessary:
* Install and configure PHP, the Webserver and MariaDB or MySQL.
* Download the software as [zip](https://github.com/klaus-thorres/rpmetaller-editor/zipball/main) or [tar.gz](https://github.com/klaus-thorres/rpmetaller-editor/tarball/main) file.
* Make the content of the “deploy” folder accessible for the web server.
* Import the database from the file “databases_rpm.sql” in the “database” folder into your database management software.
* Create the “db_connect.inc.php” file in the “deploy/include” folder, which contains the login data for the database
  management software and the name of the database you selected previously. A sample file is located in that folder.
