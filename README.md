
Schedule run in cron
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1


Queue run in supervisor
https://laravel.com/docs/8.x/queues#installing-supervisor


Mail will send with help of queue or at once, set 'mail_use_queue' in config/mail.php 

    true - in queue
    false - at once
    
Don't forget execute 'php artisan config:cache' in console of project


