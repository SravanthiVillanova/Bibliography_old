<?php

/**
 * Project:     GoogleMapAPI: a PHP library inteface to the Google Map API
 * File:        GoogleMapAPI.class.php
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to
 * smarty-general-subscribe@lists.php.net
 *
 * @link http://www.phpinsider.com/php/code/GoogleMapAPI/
 * @copyright 2005 New Digital Group, Inc.
 * @author Monte Ohrt <monte at ohrt dot com>
 * @package GoogleMapAPI
 * @version 1.2
 */

/* $Id: GoogleMapAPI.class.php,v 1.9 2005/12/19 16:10:34 mohrt Exp $ */

/*

For best results with GoogleMaps, use XHTML compliant web pages with this header:

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">

For database caching, you will want to use this schema:

CREATE TABLE GEOCODES (
  address varchar(255) NOT NULL default '',
  lon float default NULL,
  lat float default NULL,
  PRIMARY KEY  (address)
);

*/

class GoogleMapAPI {

    /**
     * PEAR::DB DSN for geocode caching. example:
     * $dsn = 'mysql://user:pass@localhost/dbname';
     *
     * @var string
     */
    var $dsn = null;
    
    /**
     * YOUR GooglMap API KEY for your site.
     * (http://maps.google.com/apis/maps/signup.html)
     *
     * @var string
     */
    var $api_key = '';

    /**
     * current map id, set when you instantiate
     * the GoogleMapAPI object.
     *
     * @var string
     */
    var $map_id = null;

    /**
     * message <div> used along with this map.
     *
     * @var string
     */
    var $message_id = null;

    /**
     * sidebar <div> used along with this map.
     *
     * @var string
     */
    var $sidebar_id = null;    
    
    /**
     * GoogleMapAPI uses the Yahoo geocode lookup API.
     * This is the application ID for YOUR application.
     * This is set upon instantiating the GoogleMapAPI object.
     * (http://developer.yahoo.net/faq/index.html#appid)
     *
     * @var string
     */
    var $app_id = null;

    /**
     * use onLoad() to load the map javascript.
     * if enabled, be sure to include on your webpage:
     * <html onload="onLoad()">
     *
     * @var string
     */
    var $onload = true;
    
    /**
     * map center latitude (horizontal)
     * calculated automatically as markers
     * are added to the map.
     *
     * @var float
     */
    var $center_lat = null;

    /**
     * map center longitude (vertical)
     * calculated automatically as markers
     * are added to the map.
     *
     * @var float
     */
    var $center_lon = null;
    
    /**
     * enables map controls (zoom/move/center)
     *
     * @var boolean
     */
    var $map_controls = true;

    /**
     * determines the map control type
     * small -> show move/center controls
     * large -> show move/center/zoom controls
     *
     * @var string
     */
    var $control_size = 'large';
    
    /**
     * enables map type controls (map/satellite/hybrid)
     *
     * @var boolean
     */
    var $type_controls = true;

    /**
     * default map type (G_MAP_TYPE/G_SATELLITE_TYPE/G_HYBRID_TYPE)
     *
     * @var boolean
     */
    var $map_type = 'G_MAP_TYPE';
        
    /**
     * determines the default zoom level
     *
     * @var integer
     */
    var $zoom = 4;

    /**
     * determines the map width
     *
     * @var integer
     */
    var $width = '500px';
    
    /**
     * determines the map height
     *
     * @var integer
     */
    var $height = '500px';

    /**
     * message that pops up when the browser is incompatible with Google Maps.
     * set to empty string to disable.
     *
     * @var integer
     */
    var $browser_alert = 'Sorry, the Google Maps API is not compatible with this browser.';
    
    /**
     * message that appears when javascript is disabled.
     * set to empty string to disable.
     *
     * @var string
     */
    var $js_alert = '<b>Javascript must be enabled in order to use Google Maps.</b>';

    /**
     * determines if sidebar is enabled
     *
     * @var string
     */
    var $sidebar = true;    

    /**
     * determines if to/from directions are included inside info window
     *
     * @var string
     */
    var $directions = true;

    /**
     * determines if info window appears with a click or mouseover
     *
     * @var string click/mouseover
     */
    var $window_trigger = 'click';    

    /**
     * version number
     *
     * @var string
     */
    var $_version = '1.2';    
                            
    /**
     * list of added markers
     *
     * @var array
     */
    var $_markers = array();

    /**
     * list of added polylines
     *
     * @var array
     */
    var $_polylines = array();    
    
    /**
     * icon info array
     *
     * @var array
     */
    var $_icon_info = array();
    
        
    /**
     * class constructor
     *
     * @param string $map_id the id for this map
     * @param string $app_id YOUR Yahoo App ID
     */
    function GoogleMapAPI($map_id = 'map', $app_id = 'MyMapApp') {
        $this->map_id = $map_id;
        $this->message_id = 'message_' . $map_id;
        $this->sidebar_id = 'sidebar_' . $map_id;
        $this->app_id = $app_id;
    }
   
    /**
     * sets the PEAR::DB dsn
     *
     * @param string $dsn
     */
    function setDSN($dsn) {
        $this->dsn = $dsn;   
    }
    
    /**
     * sets YOUR Google Map API key
     *
     * @param string $key
     */
    function setAPIKey($key) {
        $this->api_key = $key;   
    }

    /**
     * sets the width of the map
     *
     * @param string $width
     */
    function setWidth($width) {
        if(!preg_match('!^(\d+)(.*)$!',$width,$_match))
            return false;

        $_width = $_match[1];
        $_type = $_match[2];
        if($_type == '%')
            $this->width = $_width . '%';
        else
            $this->width = $_width . 'px';
        
        return true;
    }

    /**
     * sets the height of the map
     *
     * @param string $height
     */
    function setHeight($height) {
        if(!preg_match('!^(\d+)(.*)$!',$height,$_match))
            return false;

        $_height = $_match[1];
        $_type = $_match[2];
        if($_type == '%')
            $this->height = $_height . '%';
        else
            $this->height = $_height . 'px';
        
        return true;
    }        

    /**
     * sets the default map zoom level
     *
     * @param string $level
     */
    function setZoomLevel($level) {
        $this->zoom = (int) $level;
    }    
            
    /**
     * enables the map controls (zoom/move)
     *
     */
    function enableMapControls() {
        $this->map_controls = true;
    }

    /**
     * disables the map controls (zoom/move)
     *
     */
    function disableMapControls() {
        $this->map_controls = false;
    }    
    
    /**
     * sets the map control size (large/small)
     *
     * @param string $size
     */
    function setControlSize($size) {
        if(in_array($size,array('large','small')))
        $this->control_size = $size;
    }            

    /**
     * enables the type controls (map/satellite/hybrid)
     *
     */
    function enableTypeControls() {
        $this->type_controls = true;
    }

    /**
     * disables the type controls (map/satellite/hybrid)
     *
     */
    function disableTypeControls() {
        $this->type_controls = false;
    }

    /**
     * set default map type (map/satellite/hybrid)
     *
     */
    function setMapType($type) {
        switch($type) {
            case 'hybrid':
                $this->map_type = 'G_HYBRID_TYPE';
                break;
            case 'satellite':
                $this->map_type = 'G_SATELLITE_TYPE';
                break;
            case 'map':
            default:
                $this->map_type = 'G_MAP_TYPE';
                break;
        }       
    }    
    
    /**
     * enables onload
     *
     */
    function enableOnLoad() {
        $this->onload = true;
    }

    /**
     * disables onload
     *
     */
    function disableOnLoad() {
        $this->onload = false;
    }
    
    /**
     * enables sidebar
     *
     */
    function enableSidebar() {
        $this->sidebar = true;
    }

    /**
     * disables sidebar
     *
     */
    function disableSidebar() {
        $this->sidebar = false;
    }    

    /**
     * enables map directions inside info window
     *
     */
    function enableDirections() {
        $this->directions = true;
    }

    /**
     * disables map directions inside info window
     *
     */
    function disableDirections() {
        $this->directions = false;
    }    
        
    /**
     * set browser alert message for incompatible browsers
     *
     * @params $message string
     */
    function setBrowserAlert($message) {
        $this->browser_alert = $message;
    }

    /**
     * set <noscript> message when javascript is disabled
     *
     * @params $message string
     */
    function setJSAlert($message) {
        $this->js_alert = $message;
    }

    /**
     * set the info window trigger action
     *
     * @params $message string click/mouseover
     */
    function setInfoWindowTrigger($type) {
        switch($type) {
            case 'mouseover':
                $this->window_trigger = 'mouseover';
                break;
            default:
                $this->window_trigger = 'click';
                break;
            }
    }    

    /**
     * adds a map marker by address
     * 
     * @param string $address the map address to mark (street/city/state/zip)
     * @param string $title the title display in the sidebar
     * @param string $html the HTML block to display in the info bubble (if empty, title is used)
     */
    function addMarkerByAddress($address,$title = '',$html = '') {
        $_geocode = $this->getGeocode($address);
        $_marker['lon'] = $_geocode['lon'];
        $_marker['lat'] = $_geocode['lat'];
        $_marker['html'] = strlen($html) > 0 ? $html : $title;
        $_marker['title'] = $title;
        $this->_markers[] = $_marker;
        $this->adjustCenterCoords($_marker['lon'],$_marker['lat']);
        // return index of marker
        return count($this->_markers) - 1;
    }

    /**
     * adds a map marker by geocode
     * 
     * @param string $lon the map latitude (horizontal)
     * @param string $lat the map latitude (vertical)
     * @param string $title the title display in the sidebar
     * @param string $html the HTML block to display in the info bubble (if empty, title is used)
     */
    function addMarkerByCoords($lon,$lat,$title = '',$html = '') {
        $_marker['lon'] = $lon;
        $_marker['lat'] = $lat;
        $_marker['html'] = strlen($html) > 0 ? $html : $title;
        $_marker['title'] = $title;
        $this->_markers[] = $_marker;
        $this->adjustCenterCoords($_marker['lon'],$_marker['lat']);
        // return index of marker
        return count($this->_markers) - 1;
    }

    /**
     * adds a map polyline by address
     * 
     * @param string $address1 the map address to draw from
     * @param string $address2 the map address to draw to
     * @param string $color the color of the line (format: #000000)
     * @param string $weight the weight of the line in pixels
     * @param string $opacity the line opacity (percentage)
     */
    function addPolyLineByAddress($address1,$address2,$color='#000000',$weight=10,$opacity=100) {
        $_geocode1 = $this->getGeocode($address1);
        $_geocode2 = $this->getGeocode($address2);
        $_polyline['lon1'] = $_geocode1['lon'];
        $_polyline['lat1'] = $_geocode1['lat'];
        $_polyline['lon2'] = $_geocode2['lon'];
        $_polyline['lat2'] = $_geocode2['lat'];
        $_polyline['color'] = $color;
        $_polyline['weight'] = $weight;
        $_polyline['opacity'] = $opacity;
        $this->_polylines[] = $_polyline;
        $this->adjustCenterCoords($_polyline['lon1'],$_polyline['lat1']);
        $this->adjustCenterCoords($_polyline['lon2'],$_polyline['lat2']);
        // return index of polylines
        return count($this->_polylines) - 1;
    }

    /**
     * adds a map polyline by map coordinates
     * 
     * @param string $lon1 the map longitude to draw from
     * @param string $lat1 the map latitude to draw from
     * @param string $lon2 the map longitude to draw to
     * @param string $lat2 the map latitude to draw to
     * @param string $color the color of the line (format: #000000)
     * @param string $weight the weight of the line in pixels
     * @param string $opacity the line opacity (percentage)
     */
    function addPolyLineByCoords($lon1,$lat1,$lon2,$lat2,$color='#000000',$weight=10,$opacity=100) {
        $_polyline['lon1'] = $lon1;
        $_polyline['lat1'] = $lat1;
        $_polyline['lon2'] = $lon2;
        $_polyline['lat2'] = $lat2;
        $_polyline['color'] = $color;
        $_polyline['weight'] = $weight;
        $_polyline['opacity'] = $opacity;
        $this->_polylines[] = $_polyline;
        $this->adjustCenterCoords($_polyline['lon1'],$_polyline['lat1']);
        $this->adjustCenterCoords($_polyline['lon2'],$_polyline['lat2']);
        // return index of polylines
        return count($this->_polylines) - 1;
    }        
        
    /**
     * adjust map center coordinates by the given lat/lon point
     * 
     * @param string $lon the map latitude (horizontal)
     * @param string $lat the map latitude (vertical)
     */
    function adjustCenterCoords($lon,$lat) {
        if(!isset($this->center_lat))
            $this->center_lat = (float) $lat;
        else
            $this->center_lat = (float) (($this->center_lat + $lat) / 2);
        if(!isset($this->center_lon))
            $this->center_lon = (float) $lon;
        else
            $this->center_lon = (float) (($this->center_lon + $lon) / 2);
    }

    /**
     * set map center coordinates to lat/lon point
     * 
     * @param string $lon the map latitude (horizontal)
     * @param string $lat the map latitude (vertical)
     */
    function setCenterCoords($lon,$lat) {
        $this->center_lat = (float) $lat;
        $this->center_lon = (float) $lon;
    }    

    /**
     * set new marker icon image
     * 
     * @param string $iconImage URL to icon image
     * @param string $iconShadowImage URL to shadow image
     * @param string $iconAnchorX X coordinate for icon anchor point
     * @param string $iconAnchorY Y coordinate for icon anchor point
     * @param string $infoWindowAnchorX X coordinate for info window anchor point
     * @param string $infoWindowAnchorY Y coordinate for info window anchor point
     */
    function setMarkerIcon($iconImage,$iconShadowImage,$iconAnchorX,$iconAnchorY,$infoWindowAnchorX,$infoWindowAnchorY) {
    
        $_icon_image_path = strpos($iconImage,'http') === 0 ? $iconImage : $_SERVER['DOCUMENT_ROOT'] . $iconImage;
        if(!($_image_info = @getimagesize($_icon_image_path))) {
            die('GoogleMapAPI:setMarkerIcon: Error reading image: ' . $iconImage);   
        }
        $_shadow_image_path = strpos($iconShadowImage,'http') === 0 ? $iconShadowImage : $_SERVER['DOCUMENT_ROOT'] . $iconShadowImage;
        if(!($_shadow_info = @getimagesize($_shadow_image_path))) {
            die('GoogleMapAPI:setMarkerIcon: Error reading image: ' . $iconShadowImage);
        }
        
        $this->_icon_info = array(
                'image' => $iconImage,
                'shadow' => $iconShadowImage,
                'iconWidth' => $_image_info[0],
                'iconHeight' => $_image_info[1],
                'shadowWidth' => $_shadow_info[0],
                'shadowHeight' => $_shadow_info[1],
                'iconAnchorX' => $iconAnchorX,
                'iconAnchorY' => $iconAnchorY,
                'infoWindowAnchorX' => $infoWindowAnchorX,
                'infoWindowAnchorY' => $infoWindowAnchorY
                );
    }    

    /**
     * print map header javascript (goes between <head></head>)
     * 
     */
    function printHeaderJS() {
        echo $this->getHeaderJS();   
    }
    
    /**
     * return map header javascript (goes between <head></head>)
     * 
     */
    function getHeaderJS() {
        return sprintf('<script src="http://maps.google.com/maps?file=api&v=1&key=%s" type="text/javascript" charset="utf-8"></script>', $this->api_key);
    }    
    
    /**
     * print map javascript (put just before </body>, or in <header> if using onLoad())
     * 
     */
    function printMapJS() {
        echo $this->getMapJS();
    }    

    /**
     * return map javascript
     * 
     */
    function getMapJS() {
        $_output = '<script type="text/javascript" charset="utf-8">' . "\n";
        $_output .= '//<![CDATA[' . "\n";
        $_output .= "/*************************************************\n";
        $_output .= " * Created with GoogleMapAPI " . $this->_version . "\n";
        $_output .= " * Author: Monte Ohrt <monte AT ohrt DOT com>\n";
        $_output .= " * Copyright 2005 New Digital Group\n";
        $_output .= " * http://www.phpinsider.com/php/code/GoogleMapAPI/\n";
        $_output .= " *************************************************/\n";

        if($this->sidebar) {        
            $_output .= 'var sidebar_html = "";' . "\n";
            $_output .= 'var markers = [];' . "\n";
            $_output .= 'var marker_html = [];' . "\n";
            $_output .= 'var counter = 0;' . "\n";
        }

        if($this->directions) {        
            $_output .= 'var to_htmls = [];' . "\n";
            $_output .= 'var from_htmls = [];' . "\n";
        }        
        
        if(!empty($this->_icon_info)) {
            $_output .= 'var icon = new GIcon();' . "\n";   
            $_output .= sprintf('icon.image = "%s";',$this->_icon_info['image']) . "\n";   
            $_output .= sprintf('icon.shadow = "%s";',$this->_icon_info['shadow']) . "\n";   
            $_output .= sprintf('icon.iconSize = new GSize(%s,%s);',$this->_icon_info['iconWidth'],$this->_icon_info['iconHeight']) . "\n";   
            $_output .= sprintf('icon.shadowSize = new GSize(%s,%s);',$this->_icon_info['shadowWidth'],$this->_icon_info['shadowHeight']) . "\n";   
            $_output .= sprintf('icon.iconAnchor = new GPoint(%s,%s);',$this->_icon_info['iconAnchorX'],$this->_icon_info['iconAnchorY']) . "\n";   
            $_output .= sprintf('icon.infoWindowAnchor = new GPoint(%s,%s);',$this->_icon_info['infoWindowAnchorX'],$this->_icon_info['infoWindowAnchorY']) . "\n";
        }        
                                        
        if($this->onload) {
           $_output .= 'function onLoad() {' . "\n";   
        }        
                
        if(!empty($this->browser_alert)) {
            $_output .= 'if (GBrowserIsCompatible()) {' . "\n";
        }                
                        
        $_output .= sprintf('var map = new GMap(document.getElementById("%s"));',$this->map_id) . "\n";
        if(isset($this->center_lat) && isset($this->center_lon)) {
            $_output .= sprintf('map.centerAndZoom(new GPoint(%s, %s), %s);', $this->center_lon, $this->center_lat, $this->zoom) . "\n";
        }
        if($this->map_controls) {
          if($this->control_size == 'large')
              $_output .= 'map.addControl(new GLargeMapControl());' . "\n";
          else
              $_output .= 'map.addControl(new GSmallMapControl());' . "\n";
        }
        if($this->type_controls) {
            $_output .= 'map.addControl(new GMapTypeControl());' . "\n";
            $_output .= sprintf('map.setMapType(%s);',$this->map_type) . "\n";
        }
        if(!empty($this->_markers)) {
            $_output .= 'function createMarker(point, title, html) {' . "\n";
            if(!empty($this->_icon_info)) {
                $_output .= 'var marker = new GMarker(point,icon);' . "\n";                
            } else {
                $_output .= 'var marker = new GMarker(point);' . "\n";
            }
            if($this->directions) {
                $_output .= "to_htmls[counter] = html + '<br>Directions: <b>To here</b> - <a href=\"javascript:fromhere(' + counter + ')\">From here</a>' +
           '<br>Start address:<form action=\"http://maps.google.com/maps\" method=\"get\" target=\"_blank\">' +
           '<input type=\"text\" SIZE=40 MAXLENGTH=40 name=\"saddr\" id=\"saddr\" value=\"\" /><br>' +
           '<INPUT value=\"Get Directions\" TYPE=\"SUBMIT\">' +
           '<input type=\"hidden\" name=\"daddr\" value=\"' +
           point.y + ',' + point.x + \"(\" + title + \")\" + '\"/>';" . "\n";
                $_output .= "from_htmls[counter] = html + '<br>Directions: <a href=\"javascript:tohere(' + counter + ')\">To here</a> - <b>From here</b>' +
           '<br>End address:<form action=\"http://maps.google.com/maps\" method=\"get\"\" target=\"_blank\">' +
           '<input type=\"text\" SIZE=40 MAXLENGTH=40 name=\"daddr\" id=\"daddr\" value=\"\" /><br>' +
           '<INPUT value=\"Get Directions\" TYPE=\"SUBMIT\">' +
           '<input type=\"hidden\" name=\"saddr\" value=\"' +
           point.y + ',' + point.x + \"(\" + title + \")\" + '\"/>';" . "\n";
                $_output .= "html = html + '<br>Directions: <a href=\"javascript:tohere(' + counter + ')\">To here</a> - <a href=\"javascript:fromhere(' + counter + ')\">From here</a>';" . "\n";              
            }
            $_output .= sprintf('GEvent.addListener(marker, "%s", function() { marker.openInfoWindowHtml(html); });',$this->window_trigger) . "\n";
            if($this->sidebar) {        
                $_output .= 'markers[counter] = marker;' . "\n";
                $_output .= 'marker_html[counter] = html;' . "\n";
                $_output .= "sidebar_html += '<a href=\"javascript:click_sidebar(' + counter + ')\">' + title + '</a><br />';" . "\n";
                $_output .= 'counter++;' . "\n";
            }
            $_output .= 'return marker;' . "\n";
            $_output .= '}' . "\n";
        }
        foreach($this->_markers as $_marker) {
            $_output .= sprintf('var point = new GPoint(%s,%s);',$_marker['lon'],$_marker['lat']) . "\n";         
            $_output .= sprintf('var marker = createMarker(point,"%s","%s");',str_replace('"','\"',$_marker['title']),str_replace('"','\"',$_marker['html'])) . "\n";
            $_output .= 'map.addOverlay(marker);' . "\n";
        }
        
        foreach($this->_polylines as $_polyline) {
            $_output .= sprintf('var polyline = new GPolyline([new GPoint(%s,%s),new GPoint(%s,%s)],"%s",%s,%s);',
                    $_polyline['lon1'],$_polyline['lat1'],$_polyline['lon2'],$_polyline['lat2'],$_polyline['color'],$_polyline['weight'],$_polyline['opacity'] / 100.0) . "\n";
            $_output .= 'map.addOverlay(polyline);' . "\n";
        }
        
        $_output .= sprintf('document.getElementById("%s").innerHTML = sidebar_html;', $this->sidebar_id) . "\n";
        
        if(!empty($this->browser_alert)) {
            $_output .= '} else {' . "\n";
            $_output .= 'alert("' . $this->browser_alert . '");' . "\n";
            $_output .= '}' . "\n";
        }                        

        if($this->onload) {
           $_output .= '}' . "\n";
        }        

        if($this->sidebar) {        
            $_output .= 'function click_sidebar(idx) {' . "\n";
            $_output .= 'markers[idx].openInfoWindowHtml(marker_html[idx]);' . "\n";
            $_output .= '}' . "\n";
        }
        if($this->directions) {
            $_output .= 'function tohere(idx) {' . "\n";
            $_output .= 'markers[idx].openInfoWindowHtml(to_htmls[idx]);' . "\n";
            $_output .= '}' . "\n";
            $_output .= 'function fromhere(idx) {' . "\n";
            $_output .= 'markers[idx].openInfoWindowHtml(from_htmls[idx]);' . "\n";
            $_output .= '}' . "\n";
        }

        $_output .= '//]]>' . "\n";
        $_output .= '</script>' . "\n";
        return $_output;
    }

    /**
     * print map (put at location map will appear)
     * 
     */
    function printMap() {
        echo $this->getMap();
    }

    /**
     * return map
     * 
     */
    function getMap() {
        $_output = sprintf('<div id="%s" style="width: %s; height: %s"></div>',$this->map_id,$this->width,$this->height) . "\n";
        $_output .= sprintf('<div id="%s"></div>',$this->message_id) . "\n";
        
        if(!empty($this->js_alert)) {
            $_output .= '<noscript>' . $this->js_alert . '</noscript>' . "\n";
        }
        return $_output;
    }    
    
    /**
     * print map (put at location map will appear)
     * 
     */
    function printSidebar() {
        echo $this->getSidebar();
    }    

    /**
     * return sidebar html
     * 
     */
    function getSidebar() {
        return sprintf('<div id="%s"></div>',$this->sidebar_id) . "\n";
    }    
            
    /**
     * get the geocode lat/lon points from given address
     * look in cache first, otherwise get from Yahoo
     * 
     * @param string $address
     */
    function getGeocode($address) {
        if(empty($address))
          return false;

        $_geocode = false;

        if(($_geocode = $this->getCache($address)) === false) {
            $_geocode = $this->geoGetCoords($address);
            $this->putCache($address, $_geocode['lon'], $_geocode['lat']);
        }
        
        return $_geocode;
    }
   
    /**
     * get the geocode lat/lon points from cache for given address
     * 
     * @param string $address
     */
    function getCache($address) {
        if(!isset($this->dsn))
           return false;
        
        $_ret = array();
        
        // PEAR DB
        require_once('DB.php');          
        $_db =& DB::connect($this->dsn);
        if (PEAR::isError($_db)) {
            die($_db->getMessage());
        }
        $_res =& $_db->query(sprintf("SELECT lon,lat FROM GEOCODES where address = '%s'",$_db->escapeSimple($address)));
        if (PEAR::isError($_res)) {
            die($_res->getMessage());
        }
        if($_row = $_res->fetchRow()) {            
            $_ret['lon'] = $_row[0];
            $_ret['lat'] = $_row[1];
        }
        
        $_db->disconnect();
        
        return !empty($_ret) ? $_ret : false;
    }
    
    /**
     * put the geocode lat/lon points into cache for given address
     * 
     * @param string $address
     * @param string $lon the map latitude (horizontal)
     * @param string $lat the map latitude (vertical)
     */
    function putCache($address, $lon, $lat) {
        if(!isset($this->dsn) || (strlen($address) == 0 || strlen($lon) == 0 || strlen($lat) == 0))
           return false;
        // PEAR DB
        require_once('DB.php');          
        $_db =& DB::connect($this->dsn);
        if (PEAR::isError($_db)) {
            die($_db->getMessage());
        }
        
        $_res =& $_db->query(sprintf("insert into GEOCODES values ('%s',%s,%s)",
                $_db->escapeSimple($address),
                $lon,
                $lat
                ));
        if (PEAR::isError($_res)) {
            die($_res->getMessage());
        }
        $_db->disconnect();
        
        return true;
        
    }
   
    /**
     * get geocode lat/lon points for given address from Yahoo
     * 
     * @param string $address
     */
    function geoGetCoords($address) {
        
        $_url = 'http://api.local.yahoo.com/MapsService/V1/geocode';
        $_url .= sprintf('?appid=%s&location=',$this->app_id) . rawurlencode($address);

        $_result = false;
        
        if($_result = file_get_contents($_url)) {
        
            preg_match('!<Latitude>(.*)</Latitude><Longitude>(.*)</Longitude>!U', $_result, $_match);

            //print_r($_match);
            
            $_coords['lon'] = $_match[2];
            $_coords['lat'] = $_match[1];
        
        }
        
        return $_coords;       
    }

}

?>
