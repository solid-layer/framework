<?php

namespace Clarity\Util\Validator\Tests;

class Sample
{
    /**
     * Provide the rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'empty_array_sample' => [
                'array_val',
                'array_type',
            ],

            'simple_array_sample' => [
                'array_val',
                'array_type',
            ],

            'array_object_sample' => [
                'array_val',
                '!array_type',
            ],

            'simple_xml_element_sample' => '!array_val',

            'bool_val_sample_1' => 'bool_val',
            'bool_val_sample_2' => 'bool_val',
            'bool_val_sample_3' => 'bool_val',
            'bool_val_sample_4' => 'bool_val',
            'bool_val_sample_5' => 'bool_val',
            'bool_val_sample_6' => 'bool_val',

            'bool_type_sample_1' => 'bool_type',
            'bool_type_sample_2' => 'bool_type',

            'callable_type_sample_1' => 'callable_type',
            'callable_type_sample_2' => 'callable_type',
            'callable_type_sample_3' => 'callable_type',

            'countable_sample_1' => 'countable',
            'countable_sample_2' => 'countable',
            'countable_sample_3' => '!countable',

            'date_sample_1' => 'date',
            'date_sample_2' => 'date',
            'date_sample_3' => 'date',
            'date_sample_4' => [
                '!date' => ['Y-m-d'],
            ],

            'false_val_sample_1' => 'false_val',
            'false_val_sample_2' => 'false_val',
            'false_val_sample_3' => 'false_val',
            'false_val_sample_4' => 'false_val',
            'false_val_sample_5' => 'false_val',
            'false_val_sample_6' => 'false_val',
            'false_val_sample_7' => '!false_val',
            'false_val_sample_8' => '!false_val',

            'float_val_sample_1' => 'float_val',
            'float_val_sample_2' => 'float_val',

            'float_type_sample_1' => 'float_type',
            'float_type_sample_2' => '!float_type',
            'float_type_sample_3' => 'float_type',

            'instance_sample_1' => [
                'instance' => ['DateTime'],
            ],
            'instance_sample_2' => [
                'instance' => ['Traversable'],
            ],

            'int_val_sample_1' => 'int_val',
            'int_val_sample_2' => 'int_val',
        ];
    }

    public function validationData()
    {
        return [
            'empty_array_sample' => [],

            'simple_array_sample' => [1, 2, 3],

            'array_object_sample' => new \ArrayObject,

            'simple_xml_element_sample' => new \SimpleXMLElement($this->sampleXML()),

            'bool_val_sample_1' => 'on',
            'bool_val_sample_2' => 'off',
            'bool_val_sample_3' => 'yes',
            'bool_val_sample_4' => 'no',
            'bool_val_sample_5' => 1,
            'bool_val_sample_6' => 0,

            'bool_type_sample_1' => true,
            'bool_type_sample_2' => false,

            'callable_type_sample_1' => function () {
            },
            'callable_type_sample_2' => 'trim',
            'callable_type_sample_3' => [new self, 'validationData'],

            'countable_sample_1' => [],
            'countable_sample_2' => new \ArrayObject,
            'countable_sample_3' => 'string',

            'date_sample_1' => '2009-01-01',
            'date_sample_2' => 'now',
            'date_sample_3' => new \DateTime,
            'date_sample_4' => '01-01-2009',

            'false_val_sample_1' => false,
            'false_val_sample_2' => 0,
            'false_val_sample_3' => '0',
            'false_val_sample_4' => 'false',
            'false_val_sample_5' => 'off',
            'false_val_sample_6' => 'no',
            'false_val_sample_7' => '0.5',
            'false_val_sample_8' => '2',

            'float_val_sample_1' => 1.5,
            'float_val_sample_2' => '1e5',

            'float_type_sample_1' => 1.5,
            'float_type_sample_2' => '1.5',
            'float_type_sample_3' => 0e5,

            'instance_sample_1' => new \DateTime,
            'instance_sample_2' => new \ArrayObject,

            'int_val_sample_1' => '10',
            'int_val_sample_2' => 10,
        ];
    }

    private function sampleXML()
    {
        return <<<XML
<?xml version='1.0' standalone='yes'?>
<movies>
    <movie>
        <title>PHP: Behind the Parser</title>
        <characters>
            <character>
                <name>Ms. Coder</name>
                <actor>Onlivia Actora</actor>
            </character>
            <character>
                <name>Mr. Coder</name>
                <actor>El Act&#211;r</actor>
            </character>
        </characters>
        <plot>
            So, this language. It's like, a programming language. Or is it a
            scripting language? All is revealed in this thrilling horror spoof
            of a documentary.
        </plot>
        <great-lines>
            <line>PHP solves all my web problems</line>
        </great-lines>
        <rating type="thumbs">7</rating>
        <rating type="stars">5</rating>
    </movie>
</movies>
XML;
    }
}
