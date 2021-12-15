# Installation
To install the software the following steps are necessary:
* Install and configure PHP, the Webserver and MariaDB or MySQL.
* Download the project by cloning it or fetching one of these files:
  * zip: https://github.com/klaus-thorres/rpmetaller-editor/zipball/main
  * tar.gz: https://github.com/klaus-thorres/rpmetaller-editor/tarball/main
* Make the content of the folder “deploy/web/” accessible for the web server. If you want you
  can only upload the “deploy” folder to your web server.
* Install the project dependencies via `composer install`.
* Import the database from the file “databases_rpm.sql” in the “database” folder
  into your database management software.
* Create the “db_connect.inc.php” file in the “deploy/include/” folder, which contains the
  login data for the database management software and the name of the database you
  selected previously. A sample file is also located in that folder.
