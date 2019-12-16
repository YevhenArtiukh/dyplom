<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 19.01.2019
 * Time: 16:36
 */

namespace App\Controller;


use App\Entity\Sites;
use App\Form\SitesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(
            SitesType::class,
            []
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $variables = $this->getAllVariableFromUrl($data['url']);

            $site = new Sites(
                $data['url'],
                $data['urlType'],
                $variables[0],
                $variables[1],
                $variables[2],
                $this->getUser()
            );
            $this->getDoctrine()->getManager()->persist($site);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard');
        }

        $chart['politics'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('politic');
        $chart['sklep'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('shop');
        $chart['blog'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('blog');
        $chart['rozrywkowy'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('entertaining');
        $chart['inne'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('other');

        foreach ($chart as $type_url => $arr)
        {
            if(count($arr) == 0)
            {
                $chartData[$type_url]['local'] = 0;
                $chartData[$type_url]['session'] = 0;
                $chartData[$type_url]['cookie'] = 0;
            }
            else
            {
                $countLocal = 0;
                $countSession = 0;
                $countCookie = 0;

                /**
                 * @var Sites $site
                 */
                foreach ($arr as $k=>$site)
                {
                    $countLocal += $site->getLocalStorage();
                    $countSession += $site->getSessionStorage();
                    $countCookie += $site->getCookie();
                }

                $chartData[$type_url]['local'] = $countLocal/count($arr);
                $chartData[$type_url]['session'] = $countSession/count($arr);
                $chartData[$type_url]['cookie'] = $countCookie/count($arr);
            }
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
            'sites' => count($this->getDoctrine()->getRepository('App:Sites')->findAll()),
            'localStorage' => $this->getDoctrine()->getRepository('App:Sites')->findAllLocalStorage(),
            'sessionStorage' => $this->getDoctrine()->getRepository('App:Sites')->findAllSessionStorage(),
            'cookie' => $this->getDoctrine()->getRepository('App:Sites')->findAllCookie(),
            'chart' => [
                'local' => json_encode([
                    $chartData['politics']['local'],
                    $chartData['sklep']['local'],
                    $chartData['blog']['local'],
                    $chartData['rozrywkowy']['local'],
                    $chartData['inne']['local']
                    ]),
                'session' => json_encode([
                    $chartData['politics']['session'],
                    $chartData['sklep']['session'],
                    $chartData['blog']['session'],
                    $chartData['rozrywkowy']['session'],
                    $chartData['inne']['session']
                ]),
                'cookie' => json_encode([
                    $chartData['politics']['cookie'],
                    $chartData['sklep']['cookie'],
                    $chartData['blog']['cookie'],
                    $chartData['rozrywkowy']['cookie'],
                    $chartData['inne']['cookie']
                ]),
            ]
        ]);
    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);

        if ($ini == 0)
            return '';

        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }

    function getStringBetweenDelimiters($p_string, $p_from, $p_to, $p_multiple=false)
    {
        if (strlen($p_string) > 0)
        {
            if ($p_multiple)
            {
                $result_list = explode($p_to, $p_string);
                foreach ( $result_list AS $rlkey => $rlrow)
                {
                    $result_start_pos   = strpos($rlrow, $p_from);
                    $result_len         =  strlen($rlrow) - $result_start_pos;

                    if ($result_start_pos > 0)
                    {
                        $result[] =   substr($rlrow, $result_start_pos + strlen($p_from), $result_len);
                    }
                }
            }
            else
            {
                $result_start_pos   = strpos($p_string, $p_from) + strlen($p_from);
                $result_length      = strpos($p_string, $p_to, $result_start_pos);
                $result             = substr($p_string, $result_start_pos+1, $result_length );
            }
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    function getAllVariableFromUrl($url)
    {
        $urlPage = $url;
        $page = file_get_contents($urlPage);
        $countLocalStorage = 0;
        $countSessionStorage = 0;
        $countCookies = 0;

        $parsed = $this->getStringBetweenDelimiters($page, '<script', '</script>', true);

        foreach($parsed as $key => $value)
        {
            $url = [];
            if(strpos($value, 'src='))
            {
                if(strpos($value, "src='"))
                {
                    $url[$key] = $this->get_string_between($value,"src='","'");
                }
                else
                {
                    $url[$key] = $this->get_string_between($value,'src="','"');
                }
            }
            else
            {
                $countLocalStorage += substr_count($value, 'localStorage');
                $countSessionStorage += substr_count($value, 'sessionStorage');
                $countCookies += substr_count($value, 'cookie');
            }

            foreach($url as $k=>$v)
            {
                if(isset($value[1]) && $value[1] == '/')
                {
                    $result[$k] = file_get_contents('https:'.$v);
                }
                elseif(isset($v[0]) && $v[0] == '/' && isset($v[1]) &&  $v[1] != '/')
                {
                    $result[$k] = file_get_contents('http://'.parse_url($urlPage)['host'].$v);
                }
                elseif(isset($v[0]) && $v[0] == 'h' && isset($v[1]) && $v[1] == 't' &&
                    isset($v[2]) && $v[2] == 't' && isset($v[3]) && $v[3] == 'p')
                {
                    if(!curl_init($v))
                        $result[$k] = file_get_contents($v);
                    else
                        $result[$k] = null;
                }
                else
                {
                    $result[$k] = $v;
                }

                $countLocalStorage += substr_count($result[$k], 'localStorage');
                $countSessionStorage += substr_count($result[$k], 'sessionStorage');
                $countCookies += substr_count($result[$k], 'cookie');
            }
        }

        return [$countLocalStorage, $countSessionStorage, $countCookies];
    }


    /**
     * @Route("/results", name="results")
     */
    public function resultsAction(Request $request)
    {
        $form = $this->createForm(
            SitesType::class,
            []
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $variables = $this->getAllVariableFromUrl($data['url']);

            $site = new Sites(
                $data['url'],
                $data['urlType'],
                $variables[0],
                $variables[1],
                $variables[2],
                $this->getUser()
            );
            $this->getDoctrine()->getManager()->persist($site);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('results');
        }

        $chart['politics'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('politic');
        $chart['sklep'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('shop');
        $chart['blog'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('blog');
        $chart['rozrywkowy'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('entertaining');
        $chart['inne'] = $this->getDoctrine()->getRepository('App:Sites')->findByUrlType('other');

        foreach ($chart as $type_url => $arr)
        {
            if(count($arr) == 0)
            {
                $chartData[$type_url]['local'] = 0;
                $chartData[$type_url]['session'] = 0;
                $chartData[$type_url]['cookie'] = 0;
            }
            else
            {
                $countLocal = 0;
                $countSession = 0;
                $countCookie = 0;

                foreach ($arr as $k=>$site)
                {
                    $countLocal += $site->getLocalStorage();
                    $countSession += $site->getSessionStorage();
                    $countCookie += $site->getCookie();
                }

                $chartData[$type_url]['local'] = $countLocal/count($arr);
                $chartData[$type_url]['session'] = $countSession/count($arr);
                $chartData[$type_url]['cookie'] = $countCookie/count($arr);
            }
        }

        return $this->render('sites/index.html.twig', [
            'form' => $form->createView(),
            'sites' => $this->getDoctrine()->getRepository('App:Sites')->findAll(),
            'chart' => [
                'local' => json_encode([
                    $chartData['politics']['local'],
                    $chartData['sklep']['local'],
                    $chartData['blog']['local'],
                    $chartData['rozrywkowy']['local'],
                    $chartData['inne']['local']
                ]),
                'session' => json_encode([
                    $chartData['politics']['session'],
                    $chartData['sklep']['session'],
                    $chartData['blog']['session'],
                    $chartData['rozrywkowy']['session'],
                    $chartData['inne']['session']
                ]),
                'cookie' => json_encode([
                    $chartData['politics']['cookie'],
                    $chartData['sklep']['cookie'],
                    $chartData['blog']['cookie'],
                    $chartData['rozrywkowy']['cookie'],
                    $chartData['inne']['cookie']
                ]),
            ]
        ]);
    }

}