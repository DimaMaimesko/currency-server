# Currency Rates Service



## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `make setup` to set up a project. It includes building fresh images, install dependencies, setup database, apply migrations and run scheduler worker in background.  
3. Run `make down` to stop and remove containers
4. Run `make up` to start containers and run scheduler worker in background
5. Run `make tests` to run tests

## Features

* Get USD to UAH rate: `GET: http://localhost:80/api/rate`
* Subscribe email to get daily notifications: `POST: http://localhost:80/api/subscribe`

## Коментарі та опис логіки



Для отримання актуального курсу долара у гривні використовую сервіс від НБУ який реалізував у класі `src\Services\CurrencyConvertors\NBUConvertor.php` та Fixer у класі `src\Services\CurrencyConvertors\FixerConvertor.php`.

 Також зробив клас `src\Services\CurrencyConvertors\ChainConvertor.php`. Він в якості аргументів приймає різні типи конверторів і робить їх послідовне опитування, повертає результат того хто перший відповів. Якщо ніхто не відповів - повертає null. Це зроблено щоб збільшити надійність системи, бо кожен сервіс при деяких обставинах може відвалитися - викинути exception (наприклад, сервіс від НБУ працює тільки для України). У цьому разі ChainConvertor мютує exception та продовжує опитувати наступні сервіси.

Таким чином при бажанні можна буде додавати інші валютні сервіси, головне щоб вони імплементували `CurrencyConvertorInterface`,  та у клієнтському коді додавати їх у клас `ChainConvertor`, як це зроблено у класі `CurrencyRateController` (спочатку ті що більш надійні).

Для щоденної відправки емейлів використовую сімфонівський Scheduler. Щоб це працювало потрібно щоб був запущений процес Worker, він запускається у фоні автоматично командами  `make setup` або `make up`. Відправка емейлів відбувається через тестовий аккаунт Mailtrap за який відповідає сервіс `src\Services\Mailers\MailtrapSender.php` 

У заданні сказано що треба дізнаватись поточний курс долара (USD) у гривні (UAH) що я спочатку і зробив, успішно захардкодив це у класах `NBUConvertor.php` та `FixerConvertor.php`. Але згодом вирішив зробити це більш універсальним, щоб ці класи мали змогу працювати з різними валютами, а валюти задавались у клієнтських класах, в моєму випадку це  `CurrencyRateController` що обробляє роут `/api/rate` та `MainSchedule` де настроюється відправка емейлів.



## Credits

Created by [Dmytro Maimesko]().
