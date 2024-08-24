<p align="center">
    <a href="https://ugbanawaji.com/api/v1/documentation" target="_blank">
        <img src="https://media.licdn.com/dms/image/C4D16AQGXE5mUQHQTQA/profile-displaybackgroundimage-shrink_200_800/0/1621539157957?e=1717027200&amp;v=beta&amp;t=Z7ztgmcfAUZ3vao5VXLbm9PMmqf7WUjBLl-LpN1VM2I" alt="Pensuh Logo" width="400">
    </a>
</p>

<p align="center">

</p>

## Job Backend Ugbanawaji Play Ground

Ugbanawaji Play Ground is a collective of carefully curated programs designed and developed for learning Purposes.

Play Ground yet robust.


Ugbanawaji Play Ground API is extensive and thorough [documentation](https://insight-bot.test/api/v1/documentation).
Another server [documentation](https://api.insight.ai/api/v1/documentation)

## Get Started

- Pull down the repository from bitbucket:
  `git clone https://github.com/Tetranyble/insight-bot.git`
- Navigate into the repository and install project's dependencies:
  `cd insight-bot && composer install`
  `php artisan test` This guarantees that everything is working as expected.
- Next up migrate and seed the local development server:
  - `php artisan migrate`
  - `php artisan schedule:run`
  - `php artisan queue:work`

Note: you might want to change `$schedule->command('autobots:generate')->hourly();` to this `$schedule->command('autobots:generate')->everyMinute();`
    to see things work out as expected.
  - 
### Windows Users
- Start the local development server if you're on window: `php artisan server`


- Or visit the url on Mac System `http://insight-bot.test/api/v1/documentation#/` or `http://insight-bot.test`

##### And that's it. Let's get hacking.

Note: Before starting the local development server ensure you have set up the database connection and the database server is up and running.


#Happy hacking

## Contributing

Thank you for considering contributing to this project! The contribution guide can be found in the [Insight Documentation](http://insight-bot.test/docs/contributions).

## Code of Conduct

Please review and abide by the [Code of Conduct](http://insight-bot.test/api/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Insight, please send an e-mail to Leonard Ekenekiso via [senenerst@gmail.com](senenerst@gmail.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](orhttps://opensource.org/licenses/MIT).
