1. Подключите БД в файле .env
2. В терминале, в папке проекта, выполните команду composer install
3. В терминале, в папке проекта, выполните миграции php artisan migrate


rootUrl/api/login - Авторизация
rootUrl/api/register - Регистрация
rootUrl/api/user - Просмотр пользователя
rootUrl/api/update - Обновление профиля

rootUrl/api/games - Получение списка игр
rootUrl/api/games/{id} - Просмотр информации об игре отдельно

rootUrl/api/cart/add/{id} - Положить товар в корзину
rootUrl/api/cart - Просмотр списка товаров в моей корзине
rootUrl/api/cart/remove/{id} - Удаление товара из корзины

rootUrl/api/logout - Разовтаризация пользователя

