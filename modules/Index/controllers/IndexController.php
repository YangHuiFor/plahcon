<?php

namespace Index\Controllers;
use Common\AbstractController;
class IndexController extends AbstractController
{

    public function indexAction()
    {	
    	$dir = $this->view->getViewsDir();
    	$layout  = $this->view->getLayoutsDir();
    	$layouts  = $this->view->getLayout();
    	// echo $layouts;	
    	// var_dump($layout);die;
    	// echo 'this is index';
    }

}

