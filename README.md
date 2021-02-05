This project was created with input from my fellow student for educational purposes as database class course project.

#Before running the project you have to have the next installed:
- node.js, npm;
- gulp.js;
- xampp

##Build the project:

1) BackEnd:
	- run xampp and then run an apache and mysql;
	- goto http://localhost/8080 or http://localhost/phpmyadmin/ press import and chose a file from ...\socialnet\socialnetback\socialnet.sql;
	- create folder named "socialnet" in ...\xampp\htdoc folder and copy all the content of socialnet\socialnetback into created forlder;
	- goto http://localhost/socialnet and you have to see "Hello!".


2)Front end:

	- In the project directory run

``` shell
npm install
```

	- Then
	
``` shell
gulp start
```

	- goto http://localhost:9000/ click registration and fill out the form.
	Next, open  http://localhost:9000/ again and log-in with Login "admin" and password "qwerty".
	
	If everything is ok, congratulations you can send messages to yourself). 