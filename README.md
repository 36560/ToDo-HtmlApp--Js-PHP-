# ToDo-Web-App

## Simple web app to manage daily tasks

### Used languages and tools:
 - HTML
 - PHP
 - CSS
 - JavaScript
 - JQuery
 - AJAX
 - Bootstrap v5
 
---

### Content
The web page constist of a login/register screen and main screen after login.

#### Screen after successful register

![register](https://user-images.githubusercontent.com/67658221/164249507-54155715-e1c1-46c4-8720-9c93d6761d80.png)

---

App contains:
 - CRUD operations (read list of tasks for current user, update, delete, create task)
 - checking/unchecking tasks
 - deleting checked tasks from past
 - Grouping task by deadline to future, today or past tasks
 - displaying welcome info (depends on the time of day)
 - sorting task by category, title or deadline 
 - search tasks by title without page refreshing
 
---

### Structure of base
Database contains table with tasks, users and categories. 
User password is encrypted by default algorithm (bcrypt) in PHP 5.5.0.

* In 'Base' folder you may find example database in sql format.

#### Database example view
![base](https://user-images.githubusercontent.com/67658221/164253041-cbe823ff-f3cb-436c-a2ab-558fa49e43ac.png)

---

### Application - screens

#### * Main screen of app - table with tasks and welcome message
![list](https://user-images.githubusercontent.com/67658221/164255490-3403b175-01b9-457d-a9f2-308bed13b468.png)

#### * Form to add task (by click on central button)
![add](https://user-images.githubusercontent.com/67658221/164255555-7a666ec8-181e-4c61-93cf-d02e9b4839cb.png)

#### * Form to update task (by click on action button in table)
![edit](https://user-images.githubusercontent.com/67658221/164255767-46cf81bc-795a-4727-8994-fde1da12ead0.png)

#### * Info screen after deleting checked task from past
![deleteChecked](https://user-images.githubusercontent.com/67658221/164255984-b2038bef-de34-4425-9e5d-c382dde57bd8.png)

#### * Search (by type search key in input field in navbar)
![search](https://user-images.githubusercontent.com/67658221/164256588-09d46c31-efd6-47a6-87cb-c87e45a910dd.png)

#### * Sort (by click on filter icon in table head)
![sort](https://user-images.githubusercontent.com/67658221/164256220-292c68f3-e171-4c5d-b0c2-751da8f70381.png)

#### * Group (by select option in dropdown list)
![select](https://user-images.githubusercontent.com/67658221/164256437-cf409c76-61c4-4085-8a5b-86508d9f31c7.png)



