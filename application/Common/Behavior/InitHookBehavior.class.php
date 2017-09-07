<?php

namespace Common\Behavior;

use Think\Behavior;
use Think\Hook;

// 初始化钩子信息
class InitHookBehavior extends Behavior {

    // 行为扩展的执行入口必须是run
    public function run(&$content){
        if(isset($_GET['g']) && strtolower($_GET['g']) === 'install') return;
        
        $data = S('hooks');
        if(!$data){
           $plugins = M('Plugins')->where("status=1")->getField("name,hooks");
           if(!empty($plugins)){
               foreach ($plugins as $plugin => $hooks) {
                   if($hooks){
                       $hooks=explode(",", $hooks);
                       foreach ($hooks as $hook){
                           Hook::add($hook,$plugin);
                       }
                   }
               }
           }
            S('hooks',Hook::get());
        }else{
           Hook::import($data,false);
        }
    }
}