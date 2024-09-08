Run application with PHP support for HEIC format using docker:

1. Build docker image:
    ```
    docker build -t php-heic:1.1 .
    ```

2. Run php serving application using the previously built image:
    ```
    docker run --rm -it -p 8080:8080 -v ${PWD}:/var/www/html php-heic:1.1 php -S 0.0.0.0:8080 index.php
    ```

The application should be available on port `:8080`.

PS: The `index.php` in `php -S 0.0.0.0:8080 index.php` is necessary, because without it `php` tries
to serve static files, instead of redirecting all traffic to PHP script.
