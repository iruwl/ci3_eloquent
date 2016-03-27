# CodeIgniter 3.0.6 With Eloquent ORM
1.  Download CodeIgniter from [CodeIgniter.com](https://www.codeigniter.com/)
2.  Extract CodeIgniter to your web root
3.  Install Illuminate Database package

    ```
    composer require illuminate/database
    ```

4.	Install Illuminate Events package

    ```
    composer require illuminate/events
    ```

5.  Add next lines to "composer.json" file

	```
    ...
    "autoload": {
        "classmap": [
            "application/core",
            "application/models",
            "application/libraries"
        ]
    }
    ...
    ```

6.  Add next line to /index.php

	```
    ...
    include_once('vendor/autoload.php');
    ...
    ```

7.  Copy "elo.php" to /application/libraries
8.  Adjust eloquent database(s) config on /application/libraries/elo.php
9.  Load eloquent library from /application/config/autoload.php

	```
    ...
    $autoload['libraries'] = array('elo', 'database');
    ...
    ```

10. Copy "My_Model.php" to /application/core
11. Create new CI Model extend to My_Model
12. Create new CI Controller
13. Do composer update to mapping class, etc

    ```
    composer update
    ```

14. Test & Debug.
15. Done. :)

### License
[MIT License](https://github.com/expressodev/laravel-codeigniter-db/blob/master/LICENSE)
