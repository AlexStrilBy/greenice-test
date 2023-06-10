# Project requirements
- Реализовать возможность обмена средствами между кошельками пользователей.
- С каждой транзакции брать комиссию 2% в пользу системы.
- Подготовить данные (seed) для демонстрации (несколько пользователей, кошельков и заявок)
- Работа с системой осуществляется только через REST API.

Example:
1. The user A has 2 wallets USD - 100, UAH - 500
2. The user B has 3 wallets USD - 10, UAH - 2500, EUR - 400
3. Any user has ability to create requests:
   - The user A creates a request to sell 50 USD for 2000 UAH
4. Any user has ability to get listing of requests except own
   price for buyer: 2040 UAH (2000 + 2%), 40UAH system fee
5. Any user who has ability, can apply request
6. After transaction user A wallets USD - 50, UAH - 2500, user B - USD - 60, UAH - 460, EUR - 400
7. The additional API endpoint: sum of system fee for date interval
   - Example:
     - Request : date_from = 2022-07-01 date_to = 2022-08-01
     - Response [{currency: UAH, amount: 40}, {currency: USD, amount: 130}]

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
