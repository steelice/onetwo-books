Ньюансы реализации
------------------

* Поле статус для простоты сделано is_published, хотя в реальном проекте я бы уточнил у заказчика, возможно его стоит сделать enum если статусов будет больше или даже связанной таблицей, если статусы планируют менять

* Slug у книг не реализован, т.к. его нет в ТЗ, в реальном проекте я бы обговорил этот момент

* Аплоад картинки не реализован, даётся лишь ссылка на неё. Если необходим аплоад, можно добавить функционал, но тогда бы хорошо отдельно описать это в точках входа АПИ, и сделать для аплоада картинки отдельную точку.