<?php

abstract class ControllerBase extends Controller {

   const DEFAULT_TPL = 'default';
   const SMARTY_TPL = 'smarty';
   
   private $smarty;
   private $moduleOutputs = array();
   
   protected $templateEngine = ControllerBase::SMARTY_TPL;
   
   protected $modulePositions = 'left,right';

   public function __construct($registry) {
      $this->registry = $registry;
      $this->init();
   }
   /**
   *  初始化smarty类
   */
   private function init(){
      if( $this->smarty == null ){
         $this->smarty=new Smarty;
         $this->smarty->setTemplateDir(DIR_TEMPLATE);
         $this->smarty->setCompileDir(SMARTY_COMPILE);
         // $this->smarty->setCacheDir(SMARTY_CACHE);
         // $this->smarty->caching=HTML_CACHE;
      }

      $page=$this->request->get['page'];

      (empty($page) || $page<1) && $this->request->get['page']=1;

      $page>100 && $this->request->get['page']=100;
   }
   
   protected function assign($array){
      foreach($array as $k=>$v){
         $this->smarty->assign($k,$v);
      }
   }

   protected function render() {

      foreach ($this->children as $child) {
         $file  = DIR_APPLICATION . 'controller/' . $child . '.php';
         $class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $child);
         
         if (file_exists($file)) {
            require_once($file);
            $controller = new $class($this->registry);
            $controller->index();

            if( $this->templateEngine == ControllerBase::DEFAULT_TPL ) {

               //When this Controller working with OpenCart Template Framework.
               $this->data[$controller->id] = $controller->output;
            }
            else if( $this->templateEngine == ControllerBase::SMARTY_TPL ) {   
               //When this Controller working with Smarty Template.
               
               $this->data[$controller->id] = $controller->output;
               
            }
         } else {
            exit('Error: Could not load controller ' . $child . '!');
         }
      }
      // exit();
      $this->output = $this->fetch($this->template);
      if ($this->layout) {
         $file  = DIR_APPLICATION . 'controller/' . $this->layout . '.php';
         $class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $this->layout);
         
         if (file_exists($file)) {
            require_once($file);
         
            $controller = new $class();
            $controller->data[$this->id] = $this->output;
            $controller->index();
            $this->output = $controller->output;
            
         } else {
            exit('Error: Could not load controller ' . $this->layout . '!');
         }   
      }
      // print_r($this->output);exit();
      $this->response->setOutput($this->output);
   }
   
   protected function fetch($filename) {
      $file = DIR_TEMPLATE . $filename;
      
      if (file_exists($file)) {
      
         ob_start();
   
         if( strtolower($this->templateEngine) == ControllerBase::DEFAULT_TPL ) {
            //When this Controller using OpenCart Template Framework.
            extract($this->data);
            require($file);
            
            //Get Template Output From OpenCart Template Framework.
            $content = ob_get_contents();
         }
         else if( strtolower($this->templateEngine) == ControllerBase::SMARTY_TPL ) {
            //When this Controller using Smarty Template Framework.
            
            $this->smarty->compile_check = true;
            $this->smarty->debugging = false;
            
            //When smarty dose not Cached.
            if(!$this->smarty->isCached($file))  {
            
               //Assign Data From Controller to Template View.
               foreach ($this->data as $key => $value) 
                  $this->smarty->assign($key,$value);
                  
               if( $this->modulePositions != '' ) {
                  $modulePos =  explode( $this->modulePositions, ',' );
                  foreach( $modulePos as $pos ) {
                     if( $pos != '' )
                        $this->smarty->assign(trim($pos), '');
                  }
               }
           // echo count($this->data['modules']);
               // When this Controller Object is a  Module Container.
               if( count($this->moduleOutputs)> 0 && count($this->data['modules']) > 0 ) {
                  // echo 33;exit();
                  $regionOutputs = array();
                  foreach( $this->data['modules'] as $module ) {
                     // echo $module;exit();
                     if( array_key_exists($module['position'], $regionOutputs) ) 
                        $regionOutputs[$module['position']] .= $this->moduleOutputs[$module['code']];
                     else 
                        $regionOutputs[$module['position']] = $this->moduleOutputs[$module['code']];
                  }
               
                  //Set  all of modules output To Smarty Template.
                  foreach ($regionOutputs as $key => $value) 
                     $this->smarty->assign($key,$value);
               }   

            }
            
            //Get Template Output From Smarty.
            $content = $this->smarty->fetch($file);
         }
        
         ob_end_clean();   
         return $content;
         
       } else {
            exit('Error: Could not load template ' . $file . '!');
       }
   }
}
