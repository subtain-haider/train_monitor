<?php

use Carbon\Carbon;

if (!function_exists('array_paginate')) {
    /**
     * Paginate an array of data.
     *
     * @param array $items
     * @param int $perPage
     * @param int $page
     * @param array $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

     function array_paginate(array $items, $perPage = 25, $pageName = 'page', $page = null, $options = [])
     {
         $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage($pageName) ?: 1);
         $items = collect($items);
         $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
             $items->forPage($page, $perPage),
             $items->count(),
             $perPage,
             $page,
             array_merge(['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()], $options)
         );

         // Specify which query string key this paginator should use
         $paginator->setPageName($pageName);

         return $paginator;
     }

}


