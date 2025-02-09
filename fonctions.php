<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/vendor/autoload.php');
    use Ramsey\Uuid\Uuid;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    function connected($acces=null)
    {
        if ($acces != null) {
            if (!isset($_SESSION['id_compte']) || ($_SESSION['type_compte'] != $acces && $_SESSION['type_compte'] != 'admin')) {
                $redirect = $_SERVER['REQUEST_URI'];
    
                $uuid = Uuid::uuid1();
                $deceive_uri_rand_str = $uuid->toString();
    
                header("Location:/ged/?redirect=true&deceive_uri_rand_str=$deceive_uri_rand_str&redirect_uri=$redirect");
                exit();
            }
        } else {
            if (!isset($_SESSION['id_compte'])) {
                $redirect = $_SERVER['REQUEST_URI'];
    
                $uuid = Uuid::uuid1();
                $deceive_uri_rand_str = $uuid->toString();
    
                header("Location:/ged/?redirect=true&deceive_uri_rand_str=$deceive_uri_rand_str&redirect_uri=$redirect");
                exit();
            }
        }
    }
    ////////// dump avec des pre pour saut de ligne
    function dumpi($variable)
    {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
    }

    ///////// Convertit une date ou un timestamp en français
    function date_to_french($date)
    {
        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, $date));
    }
    function date_to_french_format($date, $format)
    {
        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date))));
    }

    function date_abbr($date, $lang)
    {
        if ($lang == 'fr') {
            
            $date = new DateTime($date);
            $now = new DateTime();
            $interval = $now->diff($date);
            $prefix = ($interval->invert ? 'il y a ' : '');
            if ($interval->d >= 1) return $date->format('d M');
            if ($interval->h >= 1) return $prefix . $interval->h . ' h';
            if ($interval->i >= 1) return $prefix . $interval->i . ' min';
            if ($interval->s >= 1) return $prefix . $interval->s . ' s';
            return 'à l\'instant';
            
        } else {
            $date = new DateTime($date);
            $now = new DateTime();
            $interval = $now->diff($date);
            $sufix = ($interval->invert ? ' ago' : '');
            if ($interval->d >= 1) return $date->format('d M');
            if ($interval->h >= 1) return $interval->h . ' h' . $sufix;
            if ($interval->i >= 1) return $interval->i . ' min' . $sufix;
            if ($interval->s >= 1) return $interval->s . ' s' . $sufix;
            return 'just now';
        }
        
    }

    ////////// Function-group pour déboguage des variables
    function d($data)
    {
        if (is_null($data)) {
            $str = "<i>NULL</i>";
        } elseif ($data == "") {
            $str = "<i>Empty</i>";
        } elseif (is_array($data)) {
            if (count($data) == 0) {
                $str = "<i>Empty array.</i>";
            } else {
                $str = "<table style=\"border-bottom:0px solid #000;\" cellpadding=\"0\" cellspacing=\"0\">";
                foreach ($data as $key => $value) {
                    $str .= "<tr><td style=\"background-color:#008B8B; color:#FFF;border:1px solid #000;\">" . $key . "</td><td style=\"border:1px solid #000;\">" . d($value) . "</td></tr>";
                }
                $str .= "</table>";
            }
        } elseif (is_object($data)) {
            $str = d(get_object_vars($data));
        } elseif (is_bool($data)) {
            $str = "<i>" . ($data ? "True" : "False") . "</i>";
        } else {
            $str = $data;
            $str = preg_replace("/\n/", "<br>\n", $str);
        }
        return $str;
    }

    function dnl($data)
    {
        echo d($data) . "<br>\n";
    }

    function ddi($data)
    {
        echo dnl($data);
        exit;
    }

    function ddt($message = "")
    {
        echo "[" . date("Y/m/d H:i:s") . "]" . $message . "<br>\n";
    }

    ///////////// Fin group de la fonction

    function si_funct($a, $b, $c, $d)
    {
        if ($a == $b)
            return $c;
        else
            return $d;
    }

    function si_funct1($a, $b, $c)
    {
        if ($a)
            return $b;
        else
            return $c;
    }

    function end_s($a)
    {
        if ($a > 1)
            return 's';
        else
            return '';
    }

    function format_am($amount)
    {
        return number_format($amount, 0, ',', ' ');
    }

    function user($info)
    {
        $key = $info . '_utilisateur';
        return $_SESSION["$key"];
    }

    function menu_item($title, $url = null, $active = null)
    {
        $html = <<<HTML

                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {$active}" href="{$url}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">$title</span>
                    </a>
                    <!--end:Menu link-->
                </div>

            HTML;

        return $html;
    }

    function menu_sub_item($title, $url = null, $active = null)
    {

        if ($url == null) {

            $html = <<<HTML
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">$title</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->

                HTML;
        } else {

            $html = <<<HTML

                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {$active}" href="{$url}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">$title</span>
                        </a>
                        <!--end:Menu link-->
                    </div>

                HTML;
        }

        return $html;
    }

    function single_menu($nom, $icon, $url, $active)
    {

        $html = <<<HTML

                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link {$active}" href="{$url}">
                        $icon
                        <span class="menu-title">$nom</span>
                    </a>
                    <!--end:Menu link-->
                </div>

            HTML;

        return $html;
    }

    function single_sub_menu($nom, $icon, $tab_menu, $active)
    {
        $html = <<<HTML

                <div data-kt-menu-trigger="click" class="menu-item {$active} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        $icon
                        <span class="menu-title">$nom</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

            HTML;

        // $html .= menu_item($nom);

        foreach ($tab_menu as $sub_menu) {

            if (is_array($sub_menu[1])) {

                $html .= <<<HTML

                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {$sub_menu[2]}">

                    HTML;
                $html .= menu_sub_item($sub_menu[0]);
                $html .= <<<HTML
                        <div class="menu-sub menu-sub-accordion">
                    HTML;

                foreach ($sub_menu[1] as $sub_sub_menu) {
                    $html .= menu_sub_item($sub_sub_menu[0], $sub_sub_menu[1], $sub_sub_menu[2]);
                }

                $html .= <<<HTML

                            </div>
                            <!--end:Menu sub-->
                        </div>

                    HTML;
            } else {
                $html .= menu_item($sub_menu[0], $sub_menu[1], $sub_menu[2]);
            }
        }

        $html .= <<<HTML

                    </div>
                    <!--end:Menu sub-->
                </div>

            HTML;

        return $html;
    }

    function niveau_redacteur($niveau)
    {
        $html = '';
        switch ($niveau) {
            case 'debutant':
                $html = <<<HTML

                        <div class="d-flex align-items-center">
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Debutant" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Amateur" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Intermédiaire" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Confirmé" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Expert" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            
                            </a>
                        </div>

                    HTML;
                break;
            case 'amateur':
                $html = <<<HTML

                        <div class="d-flex align-items-center">
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Debutant" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Amateur" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Intermédiaire" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Confirmé" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Expert" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            
                            </a>
                        </div>

                    HTML;
                break;
            case 'intermediaire':
                $html = <<<HTML

                        <div class="d-flex align-items-center">
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Debutant" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Amateur" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Intermédiaire" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Confirmé" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Expert" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            
                            </a>
                        </div>

                    HTML;
                break;
            case 'confirme':
                $html = <<<HTML

                        <div class="d-flex align-items-center">
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Debutant" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Amateur" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Intermédiaire" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Confirmé" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Expert" class="svg-icon svg-icon-2x"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            
                            </a>
                        </div>

                    HTML;
                break;
            case 'expert':
                $html = <<<HTML

                        <div class="d-flex align-items-center">
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Debutant" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Amateur" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Intermédiaire" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Confirmé" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-08-18-143101/core/html/src/media/icons/duotune/general/gen029.svg-->
                            <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-dismiss="click" title="Expert" class="svg-icon svg-icon-2x svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->
                            
                            </a>
                        </div>

                    HTML;
                break;
        }

        return $html;
    }


    function select($propriete, $table, $db, $selected = '', $condition = ''): string
    {

        $query = "SELECT DISTINCT $propriete FROM $table $condition";
        $statement = $db->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll();



        $output = '';

        foreach ($result as $row) {
            $attributes = ($selected == $row[$propriete]) ? 'selected' : '';
            $output .= '<option value="' . $row['' . $propriete . ''] . '" ' . $attributes . '>' . $row['' . $propriete . ''] . '</option>';
        }

        return $output;
    }

    function select1($propriete, $table, $value, $db, $selected = '', $condition = ''): string
    {

        $query = "SELECT DISTINCT * FROM $table $condition";
        $statement = $db->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll();



        $output = '';

        foreach ($result as $row) {
            $attributes = ($selected == $row[$propriete]) ? 'selected' : '';
            $output .= '<option value="' . $row['' . $value . ''] . '" ' . $attributes . '>' . $row['' . $propriete . ''] . '</option>';
        }

        return $output;
    }

    function send_mail($to, $from, $subject, $message, $attachment = null)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.yahoo.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'c_elyon@yahoo.fr';                     //SMTP username
            $mail->Password   = 'iixialwiovbjnwlt';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = 'utf-8';
        
            //Recipients
            $mail->setFrom($from[0], $from[1]);

            foreach ($to['to'] as $row) {
                if(isset($row[1]))
                    $mail->addAddress($row[0], $row[1]);
                else
                    $mail->addAddress($row[0]);
                
            }

            if (isset($to['cc'])) {
                foreach ($to['cc'] as $row) {
                    if(isset($row[1]))
                        $mail->addCC($row[0], $row[1]);
                    else
                        $mail->addCC($row[0]);
                }
            }

            if (isset($to['bcc'])) {
                foreach ($to['bcc'] as $row) {
                    if(isset($row[1]))
                        $mail->addBCC($row[0], $row[1]);
                    else
                        $mail->addBCC($row[0]);
                }
            }

            if (isset($to['reply_to'])) {
                foreach ($to['reply_to'] as $row) {
                    if(isset($row[1]))
                        $mail->addReplyTo($row[0], $row[1]);
                    else
                        $mail->addReplyTo($row[0]);
                }
            }

            // $mail->addAddress('dest@example.com', 'Joe User');     //Add a recipient
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments

            if (isset($attachment)) {
                foreach ($attachment as $row) {
                    if (isset($row[1]))
                        $mail->addAttachment($row[0], $row[1]);
                    else
                        $mail->addAttachment($row[0]);
                }
            }

            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body   = $message;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
