<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * index
     */
    function index(Request $request){

//        session_start();
//
//        $fb = new Facebook([
//            'app_id' => '1984625251687847',
//            'app_secret' => 'f0008da5defcdfe4bb64e79a36b67561',
//            'default_graph_version' => 'v2.10',
//        ]);
//
//        $helper = $fb->getRedirectLoginHelper();
//        $helper->getPersistentDataHandler()->set('state', $request->query->get('state'));
//        $permissions = ['email','read_insights'];
//        try {
//            if (isset($_SESSION['facebook_access_token'])) {
//                $accessToken = $_SESSION['facebook_access_token'];
//            } else {
//                $accessToken = $helper->getAccessToken();
//                $_SESSION['facebook_access_token'] = $accessToken;
//            }
//            $page_token_request = $fb->get('/103242447732766?fields=access_token',$accessToken);
//            $json = json_decode($page_token_request->getBody());
//            $page_token = $json->access_token;
//            $since = strtotime('-1 month');
//            $until = strtotime(now());
//
//            $page_request = $fb->get('/103242447732766/insights?metric=page_messages_active_threads_unique&since='.$since.'&until='.$until.'&access_token='.$page_token);
//            $page_data = json_decode($page_request->getBody());
//
//
//        } catch(Facebook\Exceptions\FacebookResponseException $e) {
//            echo 'Graph returned an error: ' . $e->getMessage();
//            exit;
//        } catch(Facebook\Exceptions\FacebookSDKException $e) {
//            echo 'Facebook SDK returned an error: ' . $e->getMessage();
//            exit;
//        }


        return view('admin.dashboard.dashboard',[
//            'helper'=>$helper,
//            'permissions'=>$permissions,
//            'accessToken'=>$accessToken,
        ]);

    }

}
