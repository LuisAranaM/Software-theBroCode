<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard as Guard;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Date\Date as Carbon;

use Closure;

class RequestLog {

    protected $auth;
    protected $_file;
    protected $_startTime;
    protected $_startDate;
    protected $_endTime;

    //const REQUEST_LOG_FILE = storage_path();

    public function __construct(Guard $auth){
        $this->auth = $auth;
        $this->_file = 'logs/request-log' . Carbon::now()->toDateString() . '.log';
        if(!Storage::exists($this->_file)) {
            Storage::put($this->_file, '');
        }
    }


    public function handle($request, Closure $next){
        return $next($request);
    }

    public function terminate($request, $response){
        $this->_endTime = microtime(true);
        $request->requestUri;
        $url = $request->url();
        $method = $request->getMethod();
        $ip = $request->getClientIp();
        $status = $response->getStatusCode();
        $fecha = Carbon::now()->toDateTimeString();
        $system = $this->parse_user_agent($request->header('User-Agent'));
        $usuario = $this->auth->user()? $this->auth->user()->REGISTRO: 'guest';
        $format = $request->getRequestFormat();
        $params = json_encode($request->all());
        $logtext = "$usuario|$ip|".$system['platform'].'|'.$system['platform_version'].'|'.$system['browser'].'|'.$system['version']."|$fecha|$status|$method|$url|$params";

        Storage::append($this->_file, $logtext);
    }

    function parse_user_agent( $u_agent = null ) {
        if( is_null($u_agent) ) {
            if( isset($_SERVER['HTTP_USER_AGENT']) ) {
                $u_agent = $_SERVER['HTTP_USER_AGENT'];
            } else {
                throw new \InvalidArgumentException('parse_user_agent requires a user agent');
            }
        }
        $platform = null;
        $browser  = null;
        $version  = null;
        $platform_version = null;
        $empty = array( 'platform' => $platform, 'browser' => $browser, 'version' => $version, 'platform_version' => $platform_version );
        if( !$u_agent ) return $empty;
        if( preg_match('/\((.*?)\)/im', $u_agent, $parent_matches) ) {
            preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|iPod|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|(New\ )?Nintendo\ (WiiU?|3?DS)|Xbox(\ One)?)
                    (?:\ [^;]*)?
                    (?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);
            $priority           = array( 'Xbox One', 'Xbox', 'Windows Phone', 'Tizen', 'Android' );
            $result['platform'] = array_unique($result['platform']);
            if( count($result['platform']) > 1 ) {
                if( $keys = array_intersect($priority, $result['platform']) ) {
                    $platform = reset($keys);
                } else {
                    $platform = $result['platform'][0];
                }
            } elseif( isset($result['platform'][0]) ) {
                $platform = $result['platform'][0];
            }
        }
        if( $platform == 'linux-gnu' ) {
            $platform = 'Linux';
        } elseif( $platform == 'CrOS' ) {
            $platform = 'Chrome OS';
        }
        preg_match_all('%(?P<browser>Camino|Kindle(\ Fire)?|Firefox|Iceweasel|Safari|MSIE|Trident|AppleWebKit|TizenBrowser|Chrome|
                Vivaldi|IEMobile|Opera|OPR|Silk|Midori|Edge|CriOS|
                Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
                NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
                (?:\)?;?)
                (?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
            $u_agent, $result, PREG_PATTERN_ORDER);
        // If nothing matched, return null (to avoid undefined index errors)
        if( !isset($result['browser'][0]) || !isset($result['version'][0]) ) {
            if( preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?%ix', $u_agent, $result) ) {
                return array( 'platform' => $platform ?: null, 'browser' => $result['browser'], 'version' => isset($result['version']) ? $result['version'] ?: null : null, 'platform_version' => null );
            }
            return $empty;
        }
        if( preg_match('/rv:(?P<version>[0-9A-Z.]+)/si', $u_agent, $rv_result) ) {
            $rv_result = $rv_result['version'];
        }
        $browser = $result['browser'][0];
        $version = $result['version'][0];
        $lowerBrowser = array_map('strtolower', $result['browser']);
        $find = function ( $search, &$key ) use ( $lowerBrowser ) {
            $xkey = array_search(strtolower($search), $lowerBrowser);
            if( $xkey !== false ) {
                $key = $xkey;
                return true;
            }
            return false;
        };
        $key  = 0;
        $ekey = 0;
        if( $browser == 'Iceweasel' ) {
            $browser = 'Firefox';
        } elseif( $find('Playstation Vita', $key) ) {
            $platform = 'PlayStation Vita';
            $browser  = 'Browser';
        } elseif( $find('Kindle Fire', $key) || $find('Silk', $key) ) {
            $browser  = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
            $platform = 'Kindle Fire';
            if( !($version = $result['version'][$key]) || !is_numeric($version[0]) ) {
                $version = $result['version'][array_search('Version', $result['browser'])];
            }
        } elseif( $find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS' ) {
            $browser = 'NintendoBrowser';
            $version = $result['version'][$key];
        } elseif( $find('Kindle', $key) ) {
            $browser  = $result['browser'][$key];
            $platform = 'Kindle';
            $version  = $result['version'][$key];
        } elseif( $find('OPR', $key) ) {
            $browser = 'Opera Next';
            $version = $result['version'][$key];
        } elseif( $find('Opera', $key) ) {
            $browser = 'Opera';
            $find('Version', $key);
            $version = $result['version'][$key];
        } elseif( $find('Midori', $key) ) {
            $browser = 'Midori';
            $version = $result['version'][$key];
        } elseif( $browser == 'MSIE' || ($rv_result && $find('Trident', $key)) || $find('Edge', $ekey) ) {
            $browser = 'MSIE';
            if( $find('IEMobile', $key) ) {
                $browser = 'IEMobile';
                $version = $result['version'][$key];
            } elseif( $ekey ) {
                $version = $result['version'][$ekey];
            } else {
                $version = $rv_result ?: $result['version'][$key];
            }
            if( version_compare($version, '12', '>=') ) {
                $browser = 'Edge';
            }
        } elseif( $find('Vivaldi', $key) ) {
            $browser = 'Vivaldi';
            $version = $result['version'][$key];
        } elseif( $find('Chrome', $key) || $find('CriOS', $key) ) {
            $browser = 'Chrome';
            $version = $result['version'][$key];
        } elseif( $browser == 'AppleWebKit' ) {
            if( ($platform == 'Android' && !($key = 0)) ) {
                $browser = 'Android Browser';
            } elseif( strpos($platform, 'BB') === 0 ) {
                $browser  = 'BlackBerry Browser';
                $platform = 'BlackBerry';
            } elseif( $platform == 'BlackBerry' || $platform == 'PlayBook' ) {
                $browser = 'BlackBerry Browser';
            } elseif( $find('Safari', $key) ) {
                $browser = 'Safari';
            } elseif( $find('TizenBrowser', $key) ) {
                $browser = 'TizenBrowser';
            }
            $find('Version', $key);
            $version = $result['version'][$key];
        } elseif( $key = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser'])) ) {
            $key = reset($key);
            $platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $key);
            $browser  = 'NetFront';
        }
        if( $platform == 'Kindle' && $find('Kindle', $key) ) {
            $platform_version = $result['version'][$key];
        } elseif( !empty($parent_matches[1]) && preg_match('/(?:Mac OS X (?P<version>[0-9_.]+))|(?:Windows (?:NT|Phone)*(?: OS)* *(?P<version2>[0-9_.]+))|(?:Android (?P<version3>[^;)]+))|(?:Linux (?P<version4>[^;)]+))|(?:(?:iPhone|CPU) OS (?P<version5>[0-9_.]+))/i', $parent_matches[1], $regs) ) {
            $platform_version = @trim($regs['version'] . $regs['version1'] . $regs['version2'] . $regs['version3'] . $regs['version4'] . $regs['version5']);
            if( $platform == 'Windows' ) {
                $ver = array( '5.0' => '2000', '5.1' => 'XP', '5.2' => 'XP64', '6.0' => 'Vista', '6.1' => '7', '6.2' => '8', '6.3' => '8.1', '6.4' => '10.0' );
                $platform_version = isset($ver[$platform_version]) ? $ver[$platform_version] : $platform_version;
            }
            $platform_version = str_replace('_', '.', $platform_version);
        } else {
            $result = "";
        }
        return array( 'platform' => $platform ?: null, 'browser' => $browser ?: null, 'version' => $version ?: null, 'platform_version' => $platform_version ?: null );
    }
}