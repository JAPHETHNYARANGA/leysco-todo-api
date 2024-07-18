#  Project Overview

<p>
This Laravel project is a task management application with authentication. It allows users to register, login, create tasks, view tasks, update tasks, assign tasks to other users, and delete tasks. Tasks have attributes such as name, status, and assigned user.
</P>

## Setup Instructions
* Clone the repository 
`git clone https://github.com/JAPHETHNYARANGA/leysco-todo-api.git `

* Install Composer Dependencies
`composer install`

* Install NPM Dependencies
`npm install`

* Generate an application key:
`php artisan key:generate`

* Configure Database:
create a .env file if you dont have already and set datavbase credentils

`DB_CONNECTION=mysql`
`DB_HOST=127.0.0.1`
`DB_PORT=3306`
`DB_DATABASE=your_database_name`
`DB_USERNAME=your_database_username`
`DB_PASSWORD=your_database_password`

* Run database migrations to create necessary tables:

`php artisan migrate`

* Start the Development Server:

`php artisan serve`

* Access the Application:
<p>
Open your web browser and navigate to http://localhost:8000 to access the application.
</p>

## API Endpoints
* Click on the link to obtain postman api collections 

`https://documenter.getpostman.com/view/17088191/2sA3kSn3R7`


