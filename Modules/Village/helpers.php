<?php

if ( ! function_exists('localizeddate')) {
    function localizeddate($string, $format = 'standard')
    {
        return Jenssegers\Date\Date::parse($string)->format(config('village.date.human.'.$format));
    }
}
