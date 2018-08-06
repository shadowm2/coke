<?php
/**
 * Created by PhpStorm.
 * User: shadow_m2
 * Date: 8/5/18
 * Time: 2:32 PM
 */

namespace Shadow\Coke;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Coke
{
    public function transform($input, $changes = [], $closure = null)
    {
        return $this->_transform($input, $changes);
    }

    public function _transform($input, $changes)
    {
        if ($input instanceof Model)
            $data = $this->transformModel($input, $changes);
        else if ($input instanceof Collection)
            $data = $this->transformCollection($input, $changes);
        else if ($input instanceof LengthAwarePaginator) {
            $data = $this->transformCollection($input->getCollection(), $changes);
            $data = $this->paginate($input, $data);
        } else if (is_null($input))
            $data = null;
        else
            throw new \Exception("Model/Collection/Paginator expected");


        return $data;
    }

    public function transformModel(Model $item, $changes = [])
    {
        $class_name = get_class($item);
        if (in_array($class_name, array_keys($changes))) {
            $function_name = $changes[$class_name];
            $response = $item->$function_name();
        } else {
            $response = $item->transform();
        }


        foreach ($item->getRelations() as $relation_name => $relation) {
            $data = $this->_transform($relation, $changes);
            $relation_name = $this->from_camel_case($relation_name);
            $response[$relation_name] = $data;
        }

        return $response;
    }


    public function transformCollection(Collection $collection, $changes = [])
    {
        $items = [];
        foreach ($collection as $item) {
            array_push($items, $this->_transform($item, $changes));
        }
        return $items;
    }


    public function paginate(LengthAwarePaginator $paginator, $data)
    {

        if (is_array($data))
            $collection = new Collection($data);
        else
            $collection = $data;

        return $paginator->setCollection($collection);
    }


    private function from_camel_case($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}