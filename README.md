Russian Utilites for EE 3
===========================

Плагин для работы с русскими датами и плюрализацией.

Данный плагин для движка ExpressionEngine 3.

Основан на библиотеке <https://github.com/andre487/php_rutils>.

## Установка

1. Скопируйте папку **rutools** в директорию **system/user/addons**.
2. Установите плагин в админ панели.

## Использование

Плюрализация строки:

```
{exp:rutools:plural variants="гвоздь,гвоздя,гвоздей" num="2"}  => 2 гвоздя
```
- variants: список слов (один.., два.., много..)
- num: число для плюрала

Вывод чисел текстом с плюралом:

```
{exp:rutools:sum_string variants="гвоздь,гвоздя,гвоздей" num="10"} => десять гвоздей
```
- variants: список слов (один.., два.., много..)
- num: число для плюрала

Вывод числа текстом:
```
{exp:rutools:number_words num="100500"} => сто тысяч пятьсот
```
- num: число

Вывод суммы рублей прописью:
```
{exp:rutools:get_rubles num="100.50"} => сто рублей пятьдесят копеек
```
- num: число, можно с плавующей точкой

Вывод плюральной даты:
```
{exp:rutools:date format="Опубликовано d F в H:i" date="1397475973"} => Опубликовано 14 апреля в 15:46
```
- format (стандартно 'Y.m.d H:i') формат вывода
- date (стандартно текущее время) дата в unix timestamp

Вывод относительной даты:
```
{exp:rutools:timeleft date="1397475973"}  => 21 минуту назад
```
- date (стандартно текущее время) дата в unix timestamp

Вывод возраста:
```
{exp:rutools:get_age date="1960-01-01"} => 54
```
-date: дата (можно в формате http://ru2.php.net/manual/en/datetime.formats.date.php или unix timestamp)

Промежуток времени:
```
{exp:rutools:time_interval from="2000-01-01 00:00" to="2014-04-14 18:00" accuracy="minute"}  => через 14 лет, 3 месяца, 13 дней, 18 часов
{exp:rutools:time_interval from="2014-01-01 00:00" to="2000-01-01 18:00" accuracy="hours"}  => 13 лет, 11 месяцев, 30 дней, 6 часов назад
```
- from: дата начала промежутка
- to: дата конца промежутка
- accuracy: тип подсчёта (years, months, days, hours, minutes)

Транслитизация
```
{exp:rutools:translify text="Россия"} => Rossiya
{exp:rutools:detranslify text="Rossiya"} => Россия
{exp:rutools:slugify text="Привет Россия!"} => privet-rossiya
```
