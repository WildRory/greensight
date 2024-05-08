# Используем официальный образ PHP
FROM php:8.2-cli

# Копируем файлы проекта в контейнер
COPY . /usr/src/greensight

# Устанавливаем рабочую директорию внутри контейнера
WORKDIR /usr/src/greensight

# Открываем порт 8000
EXPOSE 8000

# Запускаем встроенный веб-сервер PHP
CMD [ "php", "-S", "0.0.0.0:8000" ]