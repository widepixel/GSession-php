# GSession-php
PHP $_SESSION alternative / Superglobal variables

Если по какой либо причине у вас не работают сессии, вам могут пригодиться суперглобалиные переменные GSession.

<h2>Функции</h2>

<p>Запись переменной. Если не указывать lifetime параметр то по умолчанию он будет 1800 секунд.</p>
<code>set_gsession([name], [value], [lifetime (optional)]);</code><br/>

<p>Вывод переменной</p>
<code>get_gsession([name]);</code><br/>

<p>Удаление переменной</p>
<code>unset_gsession();</code><br/>

<p>Удаление всех переменных</p>
<code>clear_gsession();</code><br/>

<p>Получение времени жизни переменной в секундах</p>
<code>lifetime_gsession([name]);</code><br/>

<p>Массив имен переменных</p>
<code>list_gsession();</code><br/>

<p>Проверка существования переменной, при истине вернет 1</p>
<code>isset_gsession([name]);</code><br/>

<p>Проверка существования переменной, при истине вернет 1</p>
<code>isset_gsession([name]);</code><br/><br/>

<p>Все переменные записываются в папку <b>variables</b>.</p>
