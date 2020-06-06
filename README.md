# Robot working log in Console
Symfony Console based App to determine Robot cleaning and charging time.

# Installation

composer install

# How to use it
 
- run command `php robot.php clean --floor=carpet --area=70`.
- you see the state when it's cleaning or charging the battery as a command output.
- total time to complete all tasks in command output.
- `--floor` parameter can be `hard` or `carpet` value.
- if you pass any other value then you will get error.
- if you pass area = `0` also then you will get error.

# Screenshots

Output for command `php robot.php clean --floor=carpet --area=24`

![alt text](https://i.ibb.co/drXYq3H/Screenshot-2020-06-06-at-6-48-53-PM.png)

# Tests

You can run tests by `./vendor/bin/phpunit tests`
