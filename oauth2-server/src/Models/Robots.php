<?php

namespace App\Phalcon\Models;

use Phalcon\Mvc\Model;
use Phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Robots extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            "type",
            new InclusionIn(
                [
                    'message' => "Type must be 'droid', 'mechanical', or 'virtual'",
                    'domain' => [
                        'droid', 'mechanical', 'virtual'
                    ],
                ]
            )
        );

        $validator->add(
            'name',
            new Uniqueness(
                [
                    'field' => 'name',
                    'message' => 'The robot name must be unique',
                ]
            )
        );

        if ($this->year < 0) {
            $this->appendMessage(
                new Message('The year cannot be less than zero')
            );
        }

        return $this->validate($validator);
    }
}