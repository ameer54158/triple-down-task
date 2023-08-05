
I have some question related to the project, but I did this project according to my understanding.
1. I created a admin user using the laravel database seeder and use the laravel by default register and login module for the registration for the users 
and login for the users.
2. According to my understanding I divide the system into two parts. Admin will create the notification and send these notification to different users.
Normal user will receive the notification and it will show on the list page. User can delete his/her own notification that they received.
3. When an admin want to send a notification to multiple users, I used here jobs and queue, an job has been run and a background queue will be start and this
queue will send the notification to all users one by one. In this way admin will not be hold on the page. All this process has been done in background.
4. I didn't make it more complex like using the firebase or pusher for the notification etc...
5. And one more thing I have just use livewire on the notification page.
6. If you need any explanation or something else that is not understandable in the project you just let me know because I'm very excited to join your team and company
as a developer.

Thanks!


Run following commands
1. composer update , npm run build, npm run dev
2. php artisan serve
3. php artisan migrate
4. php artisan db:seed
5. php artisan queue work