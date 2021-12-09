# Helping Paws
Adopting dogs can be a life-changing experience. With such a large number of dogs entering shelters every year, existing dog adoption systems could take anywhere from a day to a month to match dogs with their new owners. As with any adoption service, staff members typically have to perform extensive interview processes and background checks on potential adopters. By fully digitizing the adoption system, organizations can easily profile both future pet parents and the dogs they currently home. Helping Paws pet adoption system aims to expedite this process to maximize efficiency while ensuring that dogs are assigned proper homes matching and even exceeding current adoption standards.

# Running the Docker Container
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