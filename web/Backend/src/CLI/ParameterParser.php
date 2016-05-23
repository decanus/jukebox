<?php

namespace Jukebox\Backend\CLI
{
    class ParameterParser
    {
        public function parse(array $params): array
        {
            $cliParameters = array();
            unset($params[0]);
            unset($params[1]);
            foreach ($params as $param) {

                if (strpos($param, '--') === false) {
                    continue;
                }

                if (strpos($param, '=') !== false) {
                    $parameterKey = substr($param, 2, (strpos($param, '=') - 2));
                    $parameterValue = substr($param, (strpos($param, '=') + 1));
                } else {
                    $parameterKey = substr($param, 2);
                    $parameterValue = true;
                }

                if ($parameterValue === 'true') {
                    $parameterValue = true;
                } elseif ($parameterValue === 'false') {
                    $parameterValue = false;
                }

                $cliParameters[$parameterKey] = $parameterValue;
            }

            return $cliParameters;
        }
    }
}
