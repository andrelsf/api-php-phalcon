<?php

namespace App\Phalcon\Controllers;

use Phalcon\Mvc\Micro;
use App\Phalcon\Models\Robots;
use Phalcon\Http\Response;

class RobotsController extends Micro
{
    /**
     * Method GET:
     * Endpoint: /api/robots
     * @request curl -i -X GET http://localhost/api/robots
     */
    public function getRobotsAction()
    {
        $phql = 'SELECT id, name, type FROM App\Phalcon\Models\Robots ORDER BY name';

        try {
            $robots = $this->modelsManager->executeQuery($phql);

            $data = array();

            foreach ($robots as $robot) {
                $data[] = [
                    'id' => $robot->id,
                    'name' => $robot->name,
                    'type' => $robot->type,
                ];
            }

            $response = new Response();

            $response->setStatusCode(200, 'success');
            $response->setJsonContent(
                [
                    'status' => 200,
                    'robots' => $data,
                ],
                JSON_PRETTY_PRINT
            );

            return $response;
        } catch(Phalcon\Db\Exception $e) {
            print($e->getTrace());
        }
    }

    /**
     * Method GET
     * Endpoint: /api/robots/search/{name}
     * @request curl -i -X GET http://localhost/api/robots/search/PO
     */
    public function searchRobotsAction(string $name)
    {
        $phql = "SELECT * FROM App\Phalcon\Models\Robots WHERE name LIKE :name: ORDER BY name";

        $robots = $this->modelsManager->executeQuery($phql, ['name' => "%" . $name . "%"]);

        $data = array();

        foreach ($robots as $robot) {
            $data[] = [
                'id' => $robot->id,
                'name' => $robot->name,
            ];
        }

        $response = new Response();

        $response->setStatusCode(200, 'success');
        $response->setJsonContent(
            [
                'status' => 200,
                'search' => $name,
                'robots' => $data,
            ],
            JSON_PRETTY_PRINT
        );

        return $response;
    }

    /**
     * Method GET
     * Endpoint: /api/robots/1
     * @request curl -i -X GET http://localhost/api/robots/1
     */
    public function getByIdAction(int $id)
    {
        $phql = "SELECT * FROM App\Phalcon\Models\Robots WHERE id = :id:";

        $robot = $this->modelsManager->executeQuery(
            $phql, [ 'id' => $id ]
        )->getFirst();

        $response = new Response();
        if ($robot === false || $robot->id === null || $robot->name === null) {
            return $response->setJsonContent(
                [
                    'status' => 204,
                    'message' => 'No Content',
                ],
                JSON_PRETTY_PRINT
            );
            return $response;
        }

        $response->setJsonContent(
            [
                'status' => 200,
                'data' => [
                    'id' => $robot->id,
                    'name' => $robot->name,
                    'type' => $robot->type,
                    'year' => $robot->year,
                ]
            ],
            JSON_PRETTY_PRINT
        );

        return $response;
    }


    /**
     * Method POST: /api/robots
     * @request curl -i -X POST \
     *          -H 'Content-Type: application/json' \
     *          -d '{"name":"C-3PO","type":"droid","year":1977}' \
     *          http://localhost/api/robots
     */
    public function createRobotAction()
    {
        $robot = $this->request->getJsonRawBody();

        $phql = "INSERT INTO App\Phalcon\Models\Robots (name, type, year) VALUES (:name:, :type:, :year:)";

        $status = $this->modelsManager->executeQuery(
            $phql,
            [
                'name' => $robot->name,
                'type' => $robot->type,
                'year' => $robot->year,
            ]
        );

        $response = new Response();

        if ($status->success() === true) {
            $response->setStatusCode(201, 'Created');
            $robot->id = $status->getModel()->id;
            $response->setJsonContent(
                [
                    'status' => 201,
                    'data' => $robot,
                ],
                JSON_PRETTY_PRINT
            );
            return $response;
        }

        $response->setStatusCode(409, 'Conflict');

        $errors = [];
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }
        $response->setJsonContent(
            [
                'status' => 409,
                'error' => $errors,
            ],
            JSON_PRETTY_PRINT
        );
        return $response;
    }

    /**
     * Method PUT
     * Endpoint: /api/robots/{id:}
     * @request curl -i -X PUT \
     *          -H 'Content-Type: application/json' \
     *          -d '{"name":"CryBot-1","type":"virtual","year":2020}' \
     *          http://localhost/api/robots/3
     */
    public function updateRobotAction(int $id)
    {
        $robot = $this->request->getJsonRawBody();

        $phql = "UPDATE App\Phalcon\Models\Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";

        $status = $this->modelsManager->executeQuery(
            $phql,
            [
                'id'    => $id,
                'name'  => $robot->name,
                'type'  => $robot->type,
                'year'  => $robot->year,
            ]
        );

        $response = new Response();

        if ($status->success() === true) {
            $response->setStatusCode(200, 'success');
            $response->setJsonContent(
                [
                    'status' => 200,
                    'message' => "robot with ID {$id} updated",
                ],
                JSON_PRETTY_PRINT
            );
            return $response;
        }

        $response->setStatusCode(409, 'Conflict');
        $errors = [];
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }
        $response->setJsonContent(
            [
                'status' => 409,
                'error' => $errors,
            ],
            JSON_PRETTY_PRINT
        );
        return $response;
    }

    /**
     * Method DELETE
     * Endpoint: /api/robots/{id:}
     * @request curl -i -X DELETE http://localhost/api/robots/8
     */
    public function deleteRobotAction(int $id)
    {
        $phql = "DELETE FROM App\Phalcon\Models\Robots WHERE id = :id:";

        $status = $this->modelsManager->executeQuery($phql, [ 'id' => $id ]);

        $response = new Response();

        if ($status->success() === true) {
            $response->setStatusCode(200, 'success');
            $response->setJsonContent(
                [
                    'status' => 200,
                    'message' => "robot with ID {$id} deleted",
                ],
                JSON_PRETTY_PRINT
            );
            return $response;
        }

        $response->setStatusCode(409, 'Conflict');

        $errors = [];
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            [
                'status' => 409,
                'error' => $errors,
            ],
            JSON_PRETTY_PRINT
        );

        return $response;
    }
}