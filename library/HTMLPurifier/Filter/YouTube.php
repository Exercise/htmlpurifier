<?php

class HTMLPurifier_Filter_YouTube extends HTMLPurifier_Filter
{

    public $name = 'YouTube';

  public function preFilter($html, $config, $context) {
    $html = preg_replace("#<object([^>]*height=\"\d+\")([^>]*width=\"\d+\"[^>]*)>#is", '<object$2$1>', $html); // incase the params are backwards
    $pattern = '#<object[^>]*width="(\d+)"[^>]*height="(\d+)"[^>]*>.+?http://www.youtube.com/v/([A-Za-z0-9\-_]+).+?</object>#is';
    $replace = '<span class="youtube-embed">\1:\2:\3</span>';
    return preg_replace($pattern, $replace, $html);
  }

  public function postFilter($html, $config, $context) {
    $pattern = '#<span class="youtube-embed">(\d+):(\d+):([A-Za-z0-9\-_]+)</span>#';
    $replace = '<object width="\1" height="\2" '.
      'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" '.
      'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">'."\n".
      '<param name="src" value="http://www.youtube.com/v/\3" />'."\n".
      '<embed type="application/x-shockwave-flash" width="\1" height="\2" src="http://www.youtube.com/v/\3"></embed>'."\n".
      '</object>';
    return preg_replace($pattern, $replace, $html);
  }

}

// vim: et sw=4 sts=4
