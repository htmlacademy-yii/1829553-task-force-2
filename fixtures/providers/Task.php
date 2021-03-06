<?php

namespace app\fixtures\providers;

use Faker\Provider\Base;

class Task extends Base
{
    protected static $data = [
        [
            'name' => 'Заменить смеситель на кухне',
            'description' => 'Кран куплен подводка тоже нужен человек с прямыми руками'
        ],
        [
            'name' => 'Заменить фильтры проточной воды',
            'description' => 'Колбы проточные металлические не могу открутить, для замены нужен спец ключ'
        ],
        [
            'name' => 'Замена полотенцесушителя',
            'description' => 'Старый потек, куплен новый. Резьба не подходит нужено что-то думать с 3/4 на 1/2',
        ],
        [
            'name' => 'Собрать мебель из Икеи',
            'description' => 'Стеллаж, стул и стол из серии ИКЕА Н',
        ],
        [
            'name' => 'Собрать и установить кухню из Леруа',
            'description' => 'Кухня прямая длинной 2 мета, глянцевые панели. Крепление на стену из ГКЛ',
        ],
        [
            'name' => 'Сделать встроенный шкаф в детскую',
            'description' => 'Нужен шкаф из ЛДСП длиной 2 метра, встроенный. Двери зеркальные',
        ],
        [
            'name' => 'Врезать замок в деревянную дверь',
            'description' => 'Простая деревенная дверь, в нее надо установить замок. Замка нету, привези с собой',
        ],
        [
            'name' => 'Замена проводки',
            'description' => 'Заменить проводку в 1комнатной квартире, сделать расчет всех материалов, купить отчет по чекам.',
        ],
        [
            'name' => 'Выгул собак по средам утром',
            'description' => 'В среду утром погулять с собаками в течении 1 часа в парке',
        ],
        [
            'name' => 'Перевезти пианино',
            'description' => 'Пианино для нас бесценно, поэтому главное упаковать хорошо и грузчики все трезвые должны быть',
        ],
        [
            'name' => 'Перевезти личные вещи из склада в квартиру без лифта',
            'description' => 'Личные вещи упакованы в коробках, объем 2 куба вес 800 кг. Подъем на 5 этаж без лифта',
        ],
        [
            'name' => 'Перевозка небольшой коробки',
            'description' => 'Срочно отвезти коробку на ЖД вокзал, примерно 20 кг',
        ],
        [
            'name' => 'Почистить компьютер от вирусов',
            'description' => 'Загружается Виндовс и потом появляется синий экран',
        ],
        [
            'name' => 'Ноутбук не включается',
            'description' => 'Что-то там грузится но Виндовс не запускается и потом перезагружается',
        ],
        [
            'name' => 'Переустановить операционную систему',
            'description' => 'Ребенок на устанавливал всяких программ, что теперь нету возможности работать с ОС. Переустановить ему и все',
        ],
        [
            'name' => 'Сделать ремонт в детской',
            'description' => 'Переклеить обои, выровнять стены, плинтуса',
        ],
        [
            'name' => 'Капремонт 2х комнатной хрушевки',
            'description' => 'Обычный хрущевка 2х комнатная, капремонт. Сделать демонтаж всего, и потом коммуникации (проводка и трубы) и потом чистовая',
        ],
        [
            'name' => 'Поклеить обои в гостиной',
            'description' => 'Комната с выровненными стенами, клей и обои уже есть. Приди преклей',
        ],
        [
            'name' => 'Вынести строительный мусор',
            'description' => 'В процессе ремонта много мусора осталось, примерно 25 мешков заполненных на половину',
        ],
        [
            'name' => 'Стиральная машину не реагирует на включение',
            'description' => 'Стиральная машина не реагирует на включение, вообще никак. Вода и электричество к ней подключено',
        ],
        [
            'name' => 'Стиральная машина не отжимает',
            'description' => 'Начинается цикл стирки, а затем останавливается. Отлючить можно только руками',
        ],
        [
            'name' => 'Холодильник не морозит',
            'description' => 'Холодильник начал гудеть сильно 2 недели назад. Сейчас в нем чуть холодно, может фреон',
        ],
        [
            'name' => 'Нужен стилист для фотосессии',
            'description' => 'У меня модная фотосессия в центре города, нужен визажист-стилист для создания нескольких образов',
        ],
        [
            'name' => 'Наклеить ресницы',
            'description' => 'Хочу длинные ресницы.',
        ],
        [
            'name' => 'Нужен лешмейкер',
            'description' => 'Нужен профи который выровняет и исправит все ошибки от прошлого мастера',
        ],
        [
            'name' => 'Фотограф для мероприятия',
            'description' => 'Встреча небольшого НКО, нужно сделать несколько общих снимков и фоновых',
        ],
        [
            'name' => 'У нас важный день нужно сделать несколько снимков',
            'description' => 'Годовщина свадьбы пройдемся в нескольких местах вот там надо и сделать снимки. Время займет примерно 2 часа',
        ],
        [
            'name' => 'Выездное фото',
            'description' => 'Нужно сделать несколько снимков на природе или в парке. с вас также транспорт',
        ],
        [
            'name' => 'Сделать перевод документов с русского на английский',
            'description' => 'Нужно подготовить документы для миграции. Сделать переводы всех важных документов',
        ],
        [
            'name' => 'Перевести договор на английский язык',
            'description' => 'Есть иностранный заказчик подготовить документы для работы с ним. Договор в формате билингва, и заготовку для выставления счетов ',
        ],
        [
            'name' => 'Перевод с технического немецкого языка',
            'description' => 'Был куплен прибор в Германии, есть только техническая документация. Работа возможно только с подписанием NDA',
        ],
        [
            'name' => 'Нужен репетитор для ребенка по немецкому языку',
            'description' => '10 летнему ребенку нужен репетитор по немецкому языку, занятия 2ы в неделю',
        ],

    ];

    public function getTaskData(): array
    {
        $key = array_rand(static::$data);
        return static::$data[$key];
    }


}
