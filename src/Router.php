<?php


use Siam\CurdGenerationPlugs\controller\Generation;

return [
    '/api/curd-generation-plugs/create' => [['GET','POST'], [new Generation, 'create']],
];