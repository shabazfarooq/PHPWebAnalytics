TITLE
-----
    PHP Web Analytics

AUTHOR
------
    Shabaz Farooq
    www.ShabazFarooq.com

BUG REPORTS
-----------
    shabazfa@buffalo.edu

DESCRIPTION
-----------
	This is a intuitive web analytics software to provide statistics on
	web traffic to your website. The software has been designed in PHP
	using MySQL as the storage database. Individual entries will display
	the USERs IP, the PAGE they have viewed, how many times they viewed that
	particular page and the last visited time.


INSTALLTION
-----------
    1) Create the necessary table in MySQL by running the following query:

    CREATE TABLE hit_counter (
   	    ip varchar(40) NOT NULL,
   	    page varchar(50) NOT NULL,
   	    count int(3) DEFAULT NULL,
   	    time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   	    UNIQUE KEY ip (ip,page)
    );


    2) Open ‘hitCounter.php’ and modify the database host, username, password and
       name accordingly.


USING THE COUNTER
-----------------
    1) Run the following code within a header or footer file to log user stats:

        <?php 
            // Record user statistics
            include("includes/hitCounter.php");
            $obj = new hitCounter;
        ?>

    2) Run the following code where ever you’d like to display the statistics:
        <?php 
            // Load statistics
            include("includes/hitCounter.php");
            $obj = new hitCounter;
            
            // Display statistics
            echo "T: " . $obj->total_count;
            echo " &emsp;&emsp; ";
            echo "U: " . $obj->unique_count;
        ?>






