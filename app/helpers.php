<?php
    use App\Models\Menus;
    use App\Models\Countries;
    use App\Models\ResourceComponents;

    function getMenus()
    {
        $menus = Menus::all();
        return $menus;
    }

    function getCountrys()
    {
        $countrys = Countries::all();
        return $countrys;   
    }
    
    function getComponent($component_id, $id)
    {
        $components = ResourceComponents::orderBy('component_id', 'desc')->orderBy('id', 'desc')->where('component_id', $component_id)->where('id', '!=', $id)->get();
        return $components;
    }
?>