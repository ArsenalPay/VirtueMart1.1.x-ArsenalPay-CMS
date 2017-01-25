# ArsenalPay Plugin for VirtueMart of Joomla! CMS

*Arsenal Media LLC*  
[Arsenal Pay processing center](https://arsenalpay.ru/)

*Плагин тестировался для VirtueMart 1.1.9 и Joomla 1.5.23  
Но данные версии не безопасны и больше не поддерживаются,  
поэтому советуем [обновиться](https://docs.joomla.org/Joomla_1.5_to_3.x_Step_by_Step_Migration) и использовать [плагин опаты для более новых версий](https://github.com/ArsenalPay/VirtueMart-ArsenalPay-CMS)*

## Source
[Official integration guide page]( https://arsenalpay.ru/developers.html )

### О МОДУЛЕ
* Модуль платежной системы ArsenalPay под VirtueMart позволяет легко встроить платежную страницу на Ваш сайт.
* После установки модуля у Вас появится новый вариант оплаты товаров и услуг через платежную систему ArsenalPay.
* Платежная система ArsenalPay позволяет совершать оплату с различных источников списания средств: мобильных номеров (МТС/Мегафон/Билайн/TELE2), пластиковых карт (VISA/MasterCard/Maestro). Перечень доступных источников средств постоянно пополняется. Следите за обновлениями.
* Модуль поддерживает русский и английский языки.

За более подробной информацией о платежной системе ArsenalPay обращайтесь по адресу [arsenalpay.ru](http://arsenalpay.ru)

### УСТАНОВКА
1. Скопируйте содержимое папки arsenalpay-joomla15-vm11 в корень сайта;
2. Убедитесь, что конфиг-файл /administrator/components/com_virtuemart/classes/payment/ps_arsenalpay.cfg.php имеет права на запись. 
3. Зайдите в административную панель Joomla!, далее в **Компоненты->VirtueMart->Способы оплаты**;
4. Там создайте новый способ оплаты.
- Укажите название для данного способа оплаты (например ArsenalPay);
- Код: AP
- Выберите класс имени платежа: ps_arsenalpay 
- Способ оплаты: HTML-форма (например, для PayPal)
5. Cохраните новый метод оплаты.

### НАСТРОЙКИ
1. В **Компоненты->VirtueMart->Способы оплаты** выберите созданный во время установки способ оплаты через ArsenalPay;
2. Выберите закладку с настройками.
 - Заполните поля **Уникальный токен** и **Ключ (key)**, присвоенными Вам токеном и ключом для подписи.
 - Проверьте **URL-адрес фрейма** должен быть установлен как `https://arsenalpay.ru/payframe/pay.php`
 - Установите **Тип оплаты** как `card` для активации платежей с пластиковых карт или  как `mk` — платежей с аккаунтов мобильных телефонов.
 - Вы можете задать **Параметр css** для применения к отображению платежного фрейма, указав url css-файла.
 - Вы можете задать ip-адрес, только с которого будут разрешены обратные запросы о совершаемых платежах, в поле **Разрешенный IP-адрес**.
 - Для **URL для обратного запроса** задайте значение `http(s)://[ваш-адрес-joomla-сайта]/administrator/components/com_virtuemart/arsenalpay_notify.php`. Ваш интернет-магазин будет получать уведомления о совершенных платежах. На адрес, указанный в этом поле, от ArsenalPay будет поступать запрос с результатом платежа для фиксирования статусов заказа в системе предприятия. 
 - При необходимости осуществления проверки номера заказа перед проведением платежа, заполните поле **URL для проверки**, на который от ArsenalPay будет поступать запрос на проверку. По умолчанию значение совпадает с **URL для обратного запроса**.
 - Вы можете отображать платежную страницу внутри фрейма на Вашем сайте, либо перенаправлять пользователя напрямую по адресу платежной страницы. (Рекомендуем перенаправление)
 - Вы можете подгонять ширину, высоту, границу и прокрутку платежного фрейма, задавая соответствующие значения параметров iframe.
 - В поле "Payment Extra Info:" (Дополнительная информация) скопируйте содержимое файла PaymentExtraInfo.php

### УДАЛЕНИЕ
1. Удалите метод оплаты ArsenalPay из методов оплат VirtueMart по пути **Компоненты->VirtueMart->Способы оплаты**
2. Также при необходимости удалите созданные ArsenalPay файлы на сервере.

### ИСПОЛЬЗОВАНИЕ
После успешной установки и настройки модуля на сайте появится возможность выбора платежной системы ArsenalPay.
Для оплаты заказа с помощью платежной системы ArsenalPay нужно:

1. Выбрать из каталога товар, который нужно купить.
2. Перейти на страницу оформления заказа (покупки).
3. В разделе "Платежные системы" выбрать платежную систему ArsenalPay.
4. Перейти на страницу подтверждения введенных данных и ввода источника списания средств (мобильный номер, пластиковая карта и т.д.).
5. После ввода данных об источнике платежа, в зависимости от его типа, либо придет СМС о подтверждении платежа, либо покупатель будет перенаправлен на страницу с результатом платежа.

------------------
### ОПИСАНИЕ РЕШЕНИЯ
ArsenalPay – удобный и надежный платежный сервис для бизнеса любого размера. 

Используя платежный модуль от ArsenalPay, вы сможете принимать онлайн-платежи от клиентов по всему миру с помощью: 
пластиковых карт международных платёжных систем Visa и MasterCard, эмитированных в любом банке
баланса мобильного телефона операторов МТС, Мегафон, Билайн, Ростелеком и ТЕЛЕ2
различных электронных кошельков 

### Преимущества сервиса: 
 - [Самые низкие тарифы](https://arsenalpay.ru/tariffs.html)
 - Бесплатное подключение и обслуживание
 - Легкая интеграция
 - [Агентская схема: ежемесячные выплаты разработчикам](https://arsenalpay.ru/partnership.html)
 - Вывод средств на расчетный счет без комиссии
 - Сервис смс оповещений
 - Персональный личный кабинет
 - Круглосуточная сервисная поддержка клиентов 

А ещё мы можем взять на техническую поддержку ваш сайт и создать для вас мобильные приложения для Android и iOS. 

ArsenalPay – увеличить прибыль просто!  
Мы работаем 7 дней в неделю и 24 часа в сутки. А вместе с нами множество российских и зарубежных компаний. 

### Как подключиться: 
1. Вы скачали модуль и установили его у себя на сайте;
2. Отправьте нам письмом ссылку на Ваш сайт на pay@arsenalpay.ru либо оставьте заявку на [сайте](https://arsenalpay.ru/#register) через кнопку "Подключиться";
3. Мы Вам вышлем коммерческие условия и технические настройки;
4. После Вашего согласия мы отправим Вам проект договора на рассмотрение.
5. Подписываем договор и приступаем к работе.

Всегда с радостью ждем ваших писем с предложениями. 

pay@arsenalpay.ru  
[arsenalpay.ru](https://arsenalpay.ru)



 
