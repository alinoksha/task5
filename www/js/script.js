/**
 * Подгружает список стран, вешает события
 * @return void
 */
function init()
{
    refresh();
    // Кнопка добавления страны
    $(document).on('click', '.add-country-btn', function() {
        $('#addCountryModal').modal('show');
    });
    // Кнопка "Закрыть" в модальном окне
    $(document).on('click', '#addCountryModal .close-modal-btn', function() {
        $('#addCountryModal').modal('hide');
        $('#addCountryModal .form-control').val('');
        $('.modal-body .input-error').hide();
    });
    // Кнопка "Сохранить" в модальном окне 
    $(document).on('click', '#addCountryModal .save-modal-btn', function() {
        let country = {};
        country.name = $('#addCountryModal .form-control#name').val().trim();
        country.code = $('#addCountryModal .form-control#code').val().trim();
        addCountry(country);
        refresh();
        $('#addCountryModal .form-control').val('');
    });
}
/**
 * Обновляет список стран
 * @return void
 */
function refresh()
{
    $('.countries').html('');
    let countries = getCountries();
    if (countries.length > 0) {
        $('.countries-table').show();
        $('.no-countries').hide();
    } else {
        $('.countries-table').hide();
        $('.no-countries').show();
    }
    for (let i in countries) {
        $('.countries').append(`
            <tr>
                <th>${countries[i].id}</th>
                <td>${countries[i].name}</td>
                <td>${countries[i].code}</td>
                <th>
                    <button type="button" class="btn btn-outline-primary" disabled>Редактировать</button>
                    <button type="button" class="btn btn-outline-danger" disabled>Удалить</button>
                </th>
            </tr>
        `);
    }
}
/**
 * Получение списка стран с сервера
 * @return Array Ответ сервера(список стран и данные о них)
 */
function getCountries()
{
    let countries = $.ajax({
        method: 'GET',
        url: 'http://localhost/backend/api.php?action=list',
        async: false
    }).responseJSON;
    return countries.result;
}
/**
 * Проверяет вводимые пользователем данные
 * @param Array data Данные о стране(имя,код страны)
 */
function addCountry(data)
{
    if (data.name != '') {
        let response = sendCountry(data);
        if (response.status == 'error') {
            $('.modal-body .input-error').show();
            $('.modal-body .input-error').text('Такая страна уже существует');
        }
        else {
            $('.modal-body .input-error').hide();
            $('#addCountryModal').modal('hide');
        }
    } else {
        $('.modal-body .input-error').show();
        $('.modal-body .input-error').text('Введите название страны');
    }
}
/**
 * Отправляет запрос на сервер для добавления новой страны
 * @param  Array country Данные о стране(имя,код страны)
 * @return Array         Ответ сервера
 */
function sendCountry(country)
{
    return $.ajax({
        method: 'POST',
        url: 'http://localhost/backend/api.php?action=add',
        data: JSON.stringify(country),
        headers: {
            'Content-Type': 'application/json'
        },
        async: false
    }).responseJSON;
}
