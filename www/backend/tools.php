<?php
/**
 * Отдает ответ в виде json и завершает скрипт
 * @param  Array   $response Тело ответа
 * @param  integer $code     Код ответа
 * @return void
 */
function makeResponse($response, $code = 200)
{
    http_response_code($code);
    exit(json_encode($response));
}
