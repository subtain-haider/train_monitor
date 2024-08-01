# Introduction
This Laravel application provides real-time information on train arrivals and departures for selected stations in the Netherlands. Utilizing the NS (Nationale Spoorwegen) API, it offers a user-friendly dashboard to view the upcoming train schedules and any service disruptions.

## Minimum Requirements
- PHP: ^8.2
- Composer
- Git

## Setup and Run Application
The setup process involves cloning the repository, installing dependencies, and configuring the environment.

#### Steps:

##### Clone the Repository
```
git clone git@github.com:subtain-haider/train_monitor.git train_monitor
cd train_monitor
```

##### Configure Environment
Copy the .env.example file to create a .env file:
```
cp .env.example .env
```
Open the .env file and adjust the NS_API_KEY

##### Install Dependencies
```
composer install
```

##### Generate Application Key
```
php artisan key:generate
```

##### Run the Application
```
php artisan serve
```
This will start the Laravel development server, typically accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000)
