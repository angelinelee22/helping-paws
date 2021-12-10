# Helping Paws
Adopting dogs can be a life-changing experience. With such a large number of dogs entering shelters every year, existing dog adoption systems could take anywhere from a day to a month to match dogs with their new owners. As with any adoption service, staff members typically have to perform extensive interview processes and background checks on potential adopters. By fully digitizing the adoption system, organizations can easily profile both future pet parents and the dogs they currently home. Helping Paws pet adoption system aims to expedite this process to maximize efficiency while ensuring that dogs are assigned proper homes matching and even exceeding current adoption standards.

## Running the Docker Container
1. Ensure that docker has been installed on your machine. It should return something similar to below.
```
$ docker version
    Client: Docker Engine - Community
    Version:           20.10.11
    API version:       1.41
    Go version:        go1.16.9
    Git commit:        dea9396
    Built:             Thu Nov 18 00:37:06 2021
    OS/Arch:           linux/amd64
    Context:           default
    Experimental:      true

    Server: Docker Engine - Community
    Engine:
    Version:          20.10.11
    API version:      1.41 (minimum version 1.12)
    Go version:       go1.16.9
    Git commit:       847da18
    Built:            Thu Nov 18 00:35:39 2021
    OS/Arch:          linux/amd64
    Experimental:     false
    containerd:
    Version:          1.4.12
    GitCommit:        7b11cfaabd73bb80907dd23182b9347b4245eb5d
    runc:
    Version:          1.0.2
    GitCommit:        v1.0.2-0-g52b36a2
    docker-init:
    Version:          0.19.0
    GitCommit:        de40ad0
```

2. Enter your terminal and `cd` to the directory of this Git Repository
```$ pwd
.../helping-paws
```
3. Build the Docker image with the provided DockerFile
```$ docker build -t php:8.0-apache .```

4. Use `docker-compose up` to create the container for the MySQL, PHP, and Apache servers.
```$ docker-compose up```

5. Go on your preferred browser and enter `localhost:8000` as a URL. Hit enter.

Once the container is up, you'll find that the Docker container has three components: 
1) The Apache server: This is the web server itself. Apache is an open source software maintained by the Apache Software Foundation. More can be read about it [here](https://www.apache.org/free/).
2) MySQL database: This is the database that stores all of our information on our customers, employees, and lovable dogs!
3) phpMyAdmin: This is a web application that is connected to our MySQL database and allows for the developer or database administrators to manipulate our data directly. *

*Currently, this is the only way to add information (aside from signing up a user).

## phpMyAdmin
In order to access the database from the backend, you can view the database management system at `http://localhost:8080/`. To make major changes (such as recreating the database), please login to the server as root. Below are the accounts to enter:

Root account (password is empty)
```
Username: root
Password:
```

User account
```
Username: test
Password: test
```

Below is a screenshot of the server:
![phpMyAdmin](./screenshots/phpmyadmin.jpg)

## Website
Upon entering the website at `http://localhost:8000/`, you should see a login page. At this point, the database has been initialized.
![login](./screenshots/login.jpg)

As a user that hasn't been logged in, you can go to the homepage, but there isn't much to do there.
![home](./screenshots/home.jpg)

Let's sign up for an account! Be careful to meet the following requirements:
- Username must be at least 5 characters
- Password must be at least 6 characters and have one of each: lowercase character, uppercase character, and number
- Phone number must be in the following format: ###-###-####
- Email must be in the following format: XXX@XXXXX.XXX

Otherwise, the below will occur:
![signup fail](./screenshots/signup-fail.jpg)
![signup fail](./screenshots/signup-fail-2.jpg)

After you've signed up, you can login to your account. Please be aware that you cannot create an administrator account from the UI/UX. However, we have initialized the database with pre-existing data that you may use to your liking:

<u>Customer Accounts</u>
```
Username: CrazyCat11
Password: HatePetsLol01

Username: DanaPeters
Password: ImSoExcited00

Username: GetItJeff
Password: JeffSretam1
```

<u> Admin Accounts</u>
```
Username: Angeline5Foot7
Password: IAmActually5Foot3

Username: DocRay
Password: IAmBestVet1010

Username: SomeInternChris
Password: WishIWorkedAtCostco1
```

Once you are logged in as an administrator, you will have access to the following: dog database, customer database, and admin profile. Customers only have access to their own profile. When you click on different rows, you will gain access to even more information on the subject, as shown below.

Dog database:
![dogs database](./screenshots/dogs.jpg)
![dogs database](./screenshots/dogs-2.jpg)

Customer database: 
![customer database](./screenshots/cust.jpg)
![customer database](./screenshots/cust-2.jpg)

Profile:
![profile](./screenshots/profile.jpg)