<?php

namespace Siam\CurdGenerationPlugs\controller;

use Siam\Plugs\controller\BasePlugsController;

class Generation extends BasePlugsController 
{
    
    public function create()
    {
        
        $tableName           = $this->request()->getRequestParam("table_name");
        $controllerNamespace = $this->request()->getRequestParam("controller_namespace");
        $modelNamespace      = $this->request()->getRequestParam("model_namespace");
        
        try{
            $mysqlConfigSet = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL');
            $mysqlConfig    = new \EasySwoole\ORM\Db\Config($mysqlConfigSet);
            $connection     = new \EasySwoole\ORM\Db\Connection($mysqlConfig);
        
        
            // 添加表前缀
            $prefix    = $mysqlConfigSet['prefix'] ?? "";
            $tableName = $prefix.$tableName;
            
            $codeGeneration = new \EasySwoole\CodeGeneration\CodeGeneration($tableName, $connection);
            //生成model
            $codeGeneration->generationModel($modelNamespace, $prefix);
            //生成controller
            $codeGeneration->generationController($controllerNamespace, null, $prefix);
            
            // feature  根据图标、前端路径、菜单名，生成view列表页和注入菜单
        }catch (\Throwable $e){
            $this->writeJson("500", [], $e->getMessage());
            return;
        }
    
        $this->writeJson("200");
    }
}