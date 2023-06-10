# Project installation

## Requirements
- Docker (CLI or desktop)
- In case of using Windows OS, you need to install WSL2 (Windows Subsystem for Linux) and Docker desktop for Windows

## Installation
1. Clone the repository
2. Run `make` or `make init` in the root directory of the project to install vendor packages and sail
3. Run `make up` to start the project
4. You are ready to go! The project is available at http://localhost:8080 run `make open` to open it in your browser


# Available Makefile commands
- `make` or `make init` - install vendor packages and sail
- `make up` - start the project
- `make down` - stop the project
- `make restart` - restart the project
- `make open` - open the project in your browser
- `make tty` - open bash in the container
- `make tty-root` - open bash in the container as root
- `make test` - run tests
- `make tinker` - start a new Laravel Tinker session
