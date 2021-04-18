<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once 'init.php';

$data = json_decode(file_get_contents('php://input'), true);

$country = new Country;

if (!isset($_GET['action'])) {
    makeResponse([
        'status' => 'error',
        'message' => 'Missing action'
    ], 400);
}
switch ($_GET['action']) {
    case 'add':
        if (isset($data['name']) && $data['name']) {
            $check = $country->add($data);
            if ($check) {
                makeResponse([
                    'status' =>'ok'
                ]);
            } else {
                makeResponse([
                    'status' => 'error',
                    'message' => 'Country already exists',
                ]);
            }
        } else {
            makeResponse([
                'status' => 'error',
                'message' => 'Missing country name'
            ], 400);
        }
    break;
    case 'list':
        makeResponse([
            'status' => 'ok',
            'result' => $country->list()
        ]);
    break;
    default:
        makeResponse([
            'status' => 'error',
            'message' => 'Unknown action'
        ], 400);
    break;
}
