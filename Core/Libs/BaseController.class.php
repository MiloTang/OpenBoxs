<?php
/**
 * Created by PhpStorm.
 * User: francis and winnie
 * Date: 2016/11/3
 * Time: 22:45
 */
namespace Core\libs;
defined('CORE_PATH') or exit();
class BaseController
{
    private $data;
    private $class;
    private $function;
    public function __construct()
    {
        $route=Route::getInstance();
        $this->class=$route->getControl();
        $this->function=$route->getAction();
        $this->cacheHTMLCheck(CACHE_TIME);
    }
    public function assign(string $name,$data)
    {
        $this->data[$name]=$data;
    }
    public function display(string $view)
    {
        $this->templatePHP($view);
    }

    /**
     * @param string $view
     */
    private function templatePHP(string $view)
    {
        $file=WEB_PATH.'Views/Cache/PHP/'.md5($view).'.php';
        $tp=Template::getInstance();
        if ($this->data!=null)
        {
            extract($this->data);
        }
        if(CACHE)
        {
            if (!file_exists($file))
            {
                $tp->template($view);
            }
            else
            {
                $this->cachePHPCheck($view);
                if (!file_exists($file))
                {
                    $tp->template($view);
                }
            }
            $this->templateHtml($view);
        }
        else
        {
            $tp->template($view);
            $this->templateHtml($view);
        }
    }
    private function templateHtml(string $view)
    {
        if (CACHE_HTML)
        {
            $this->createHtml($view);
        }
        else
        {
            if ($this->data!=null)
            {
                extract($this->data);
            }
            $file=WEB_PATH.'Views/Cache/PHP/'.md5($view).'.php';
            if(file_exists($file))
            {
                require_once $file.'';
            }
            else
            {
                PrintFm($view.' 模板不存在');
            }
        }
    }
    public function params():array
    {
        $params=array();
        if($_SERVER['REQUEST_METHOD']=='GET')
        {
            $route=Route::getInstance();
            $params=$route->getParams();

        }
        elseif($_SERVER['REQUEST_METHOD']=='POST')
        {
            $params=$_POST;
        }
        if(MAGIC_GPC)
        {
            return $this->filterGPCParams($params);
        }
        else
        {
            return $this->filterParams($params);
        }
    }
    private function filterParams(array $params):array
    {
        foreach ($params as $key=>$value)
        {
            if(is_string($value))
            {
                $params[$key]=addslashes(strip_tags(htmlentities($value,ENT_QUOTES)));

            }
            elseif(is_array($value))
            {
                $params[$key]=$this->filterParams($value);
            }
        }
        return $params;
    }
    private function filterGPCParams(array $params):array
    {
        foreach ($params as $key=>$value)
        {
            if(is_string($value))
            {
                $params[$key]=strip_tags(htmlentities($value,ENT_QUOTES));
            }
            elseif(is_array($value))
            {
                $params[$key]=$this->filterGPCParams($value);
            }
        }
        return $params;
    }
    private function createHtml(string $view)
    {
        $FName=md5($this->class.$this->function);
        $cacheFile=WEB_PATH.'Views/Cache/HTML/'.$FName.'.html';
        $file=WEB_PATH.'Views/Cache/PHP/'.$view;
        if ($this->data!=null)
        {
            extract($this->data);
        }
        if(file_exists($file))
        {
            ob_start();
            require_once $file.'';
            $contents = ob_get_contents();
            file_put_contents($cacheFile,$contents);
            ob_end_flush();
        }
        else
        {
            GetError($view.' 模板不存在');
        }
    }
    private function cacheHTMLCheck(int $cacheTime=200)
    {
        if(CACHE_HTML)
        {
            $FName=md5($this->class.$this->function);
            $cacheFile=WEB_PATH.'Views/Cache/HTML/'.$FName.'.html';
            if (is_file($cacheFile))
            {
                $aTime=fileatime($cacheFile);
                if ((time()-$aTime)>$cacheTime)
                {
                    unlink($cacheFile);
                }
                else
                {
                    require_once $cacheFile.'';
                    exit();
                }
            }
        }
    }
    private function cachePHPCheck(string $view,int $cacheTime=200)
    {
        if(CACHE)
        {
            $view=md5($view).'.php';
            $cacheFile=WEB_PATH.'Views/Cache/PHP/'.$view;
            if (is_file($cacheFile))
            {
                $aTime=fileatime($cacheFile);
                if ((time()-$aTime)>$cacheTime)
                {
                    unlink($cacheFile);
                }
                else
                {
                    require_once $cacheFile.'';
                    exit();
                }
            }
        }
    }
}