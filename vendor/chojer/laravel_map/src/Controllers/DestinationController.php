<?php

namespace Chojer\Laravel\Map\Controllers;

use Chojer\Laravel\Map\Models\DestinationGroup;
use Ckryo\Laravel\App\Http\Controllers\Controller;
use Ckryo\Laravel\Upload\Services\OSS;

class DestinationController extends Controller
{

    function index () {
        $groups = DestinationGroup::with('children')->select('*', 'id as value', 'name as label')->get()->toArray();
        foreach ($groups as &$group) {
            $group = array_only($group, ['value', 'label', 'children']);
            foreach ($group['children'] as &$code) {
                $code = array_only($code, ['value', 'label', 'children']);
                foreach ($code['children'] as &$dest) {
                    $dest = array_only($dest, ['value', 'label']);
                }
            }
        }

        $url = OSS::uploadContent('json', 'map_destination.json', json_encode($groups, JSON_UNESCAPED_UNICODE));
        dd($url);
    }

}