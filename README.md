# User API

User API is a RESTful API for manage user profiles (id, name, email, image) using PHP and MySQL database.

This API was built with Slim 3 PHP framework. It uses composer as a Dependency Manager and supports PSR-2 and PSR-4 coding standards.
Finally, this API has unit tests built with PHPUnit and Guzzle (PHP Http client).

Because of lack time, this API don't have oAuth 2 authentication, maybe for the next version.

## Server Dependencies

PHP 5.6.30 and mysqli activated
MySQL 5.5.16 or greater

## Install

1. Create database and table executing the "/userprofileapidb.sql" file in MySQL database
2. Go to the root of apache documents
3. Clone the repository in this place
4. Edit "/app/api/dbConfig.php" file and change the constants in order to connect with database (HOST,USER,PASSWORD)
5. Go to "userAPI" folder and execute this command in your CLI to start the application 
	php -S localhost:8050 -t public

## Using the API

1. Go to your browser and copy-paste the URL "http://localhost:8050/api/userProfile"
2. If you want to run the unit tests do the following
	2.1 Go to the "userAPI" folder inside of apache documents folder
	2.2 Execute the next command in your CLI:
		if you have linux:
			php vendor/bin/phpunit tests/userProfileTests.php
		
		if you have windows:
			phpunit.bat tests\userProfileTests.php

3. You also can use Postman Extension (web browser) for testing, the available routes are:
	
	### Get all user profiles 
	GET http://localhost:8050/api/userProfile
	
		In this case when there are rows in database, the result is in json format and look like this:
		[
			{
				id: "1",
				name: "UserProfileTest363",
				email: "UserProfileTest363@gmail.com",
				Image: "http://someserver/images/UserProfileTest363.jpeg"
			},
			{
				id: "2",
				name: "UserProfileTest366",
				email: "UserProfileTest366@hotmail.com",
				Image: "http://someserver/images/UserProfileTest366.jpg"
			}
		]
		
		If this case when there are no rows in database, the result is in json format and look like this:
		["No results found."]
	
	
	
	### Get one user profile, in this case 3 is the code of the user profile that we want to get
	GET http://localhost:8050/api/userProfile/3
	
		In this case when the rows exists in database, the result is in json format and look like this:
		[
			{
			id: "3",
			name: "UserProfileTest249",
			email: "UserProfileTest249@gmail.com",
			Image: "http://someserver/images/UserProfileTest249.jpeg"
			}
		]
		
		If this case when the row don't exists in database, the result is in json format and look like this:
		["No results found."]
	
	
	
	### Create one user profile, you can use Postman to send data
	POST http://localhost:8050/api/userProfile
	
		In this case is necessary to send a json array data like this:
		[
			{
				id: "20",
				name: "UserProfileTest149",
				email: "UserProfileTest149@hotmail.com",
				Image: "http://someserver/images/UserProfileTest149.png"
			}
		]
		The id key optional if you don't send it, database creates it for you.
		If the request was successful, the result will look like this:
		["Successful insert"]
		
		In this case when the row don't inserts in database, the result is in json format and look like these:
		["name argument is required"]
		["invalid email address"]
		["An error has occurred. "]
		
	
	
	### Update one user profile, you can use Postman to send data
	PUT http://localhost:8050/api/userProfile
		
		In this case is necessary to send a json array data like this:
		[
			{
				id: "21",
				name: "UserProfileTest165",
				email: "UserProfileTest165@hotmail.com",
				Image: "http://someserver/images/UserProfileTest165.png"
			}
		]
		If the request was successful, the result will look like this:
		["Successful update"]
		
		In this case when the row don't updates in database, the result is in json format and look like these:
		["name argument is required"]
		["invalid email address"]
		["An error has occurred. "]
	
	
	
	### Delete one user profile, in this case 8 is the code of the user profile that we want to delete
	DELETE http://localhost:8050/api/userProfile/8
		
		If the request was successful, the result will look like this:
		["Successful delete"]
		
		In this case when the row don't deletes in database, the result is in json format and look like these:
		["id argument is required"]
		["An error has occurred. "]
		

## Author

Edwuin Gutierrez
edwinguti86@gmail.com


## License

Copyright(c) 2017
MIT License
