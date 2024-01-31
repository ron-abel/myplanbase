<?php

namespace App\Helpers;

class ManageItems
{
    public static function get_items($contractor, $floorplan)
    {
        $items = array_filter(session()->has('items') ? session()->get('items') : [], function ($value) use ($contractor, $floorplan) {
            return $value['contractor_id'] == $contractor->id && $value['floor_plan_id'] == $floorplan->id;
        }, ARRAY_FILTER_USE_BOTH);

        return $items;
    }

    public static function update_items($request, $values, $floorplan_id)
    {
        $items = $request->session()->has('items') ? $request->session()->get('items') : [];
        $contractor = $request->contractor_details;

        $found = false;

        foreach ($items as &$item) {
            if (($item['contractor_id'] == $contractor->id) && ($item['floor_plan_id'] == $floorplan_id) && ($item['product_id'] == $values['product_id'])) {
                $item['color'] = isset($values['color']) ? $values['color'] : null;
                $item['comment'] = isset($values['comment']) ? $values['comment'] : null;

                $found = true;
                break;
            }
        }

        if (!$found) {
            $items[] = [
                "contractor_id" => $contractor->id,
                "floor_plan_id" => $floorplan_id,
                "product_id" => $values['product_id'],
                "color" => isset($values['color']) ? $values['color'] : null,
                "comment" => isset($values['comment']) ? $values['comment'] : null
            ];
        }

        $request->session()->put("items", $items);
        $request->session()->put("last_floor_plan", $floorplan_id);
    }

    public static function update_colors($request, $colors)
    {
        $items = $request->session()->get('items');

        foreach ($colors["colors"] as $key => $value) {
            $item = &$items[$key];
            $item['color'] = $value['color'];
        }

        $request->session()->put('items', $items);
    }

    public static function delete_item($request, $key)
    {
        $items = $request->session()->has('items') ? $request->session()->get('items') : [];

        if (array_key_exists($key, $items)) {
            unset($items[$key]);
        }

        $request->session()->put('items', $items);
    }

    public static function delete_items($contractor, $floorplan)
    {
        $items = array_filter(session()->has('items') ? session()->get('items') : [], function ($value) use ($contractor, $floorplan) {
            return $value['contractor_id'] != $contractor->id || $value['floor_plan_id'] != $floorplan->id;
        }, ARRAY_FILTER_USE_BOTH);

        session()->put('items', $items);
    }

    public static function get_last_floor_plan($subdomain)
    {
        $response = [
            'url' => '',
            'count' => 0
        ];
        // $floorplan_id = session()->has('last_floor_plan') ? session()->get('last_floor_plan') : "";
        $items = session()->has('items') ? session()->get('items') : [];
        if(count($items) > 0) {
            $item = end($items);
            $floorplan_id = $item['floor_plan_id'];
            $url = route('contractor.productgroups.index', ['subdomain' => $subdomain, 'floorplan' => $floorplan_id]);
            $response = [
                'url' => $url,
                'count' => count($items)
            ];
        }
        return $response;
    }
}
