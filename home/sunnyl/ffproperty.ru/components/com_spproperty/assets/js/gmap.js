/**
 * @package com_spproperty
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

jQuery(function ($) {
    google.maps.event.addDomListener(window, 'load', function () {

        var latlng = new google.maps.LatLng($('#spproperty-property-map').data('lat'), $('#spproperty-property-map').data('lng'));
        var mapOptions = {
            zoom: 15,
            center: latlng,
            scrollwheel: false
        };

        var styles = [
        {
            "featureType": "administrative",
            "elementType": "geometry",
            "stylers": [
            {
                "saturation": "2"
            },
            {
                "visibility": "simplified"
            }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "labels",
            "stylers": [
                {
                    "saturation": "-28"
            },
                {
                    "lightness": "-10"
            },
                {
                    "visibility": "on"
            }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#444444"
            }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "all",
            "stylers": [
                {
                    "color": "#f2f2f2"
            }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "saturation": "-1"
            },
                {
                    "lightness": "-12"
            }
            ]
        },
        {
            "featureType": "landscape.natural",
            "elementType": "labels.text",
            "stylers": [
                {
                    "lightness": "-31"
            }
            ]
        },
        {
            "featureType": "landscape.natural",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "lightness": "-74"
            }
            ]
        },
        {
            "featureType": "landscape.natural",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "lightness": "65"
            }
            ]
        },
        {
            "featureType": "landscape.natural.landcover",
            "elementType": "geometry",
            "stylers": [
                {
                    "lightness": "-15"
            }
            ]
        },
        {
            "featureType": "landscape.natural.landcover",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "lightness": "0"
            }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
            }
            ]
        },
        {
            "featureType": "road",
            "elementType": "all",
            "stylers": [
                {
                    "saturation": -100
            },
                {
                    "lightness": 45
            }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "on"
            },
                {
                    "saturation": "0"
            },
                {
                    "lightness": "-9"
            }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "lightness": "-14"
            }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels",
            "stylers": [
                {
                    "lightness": "-35"
            },
                {
                    "gamma": "1"
            },
                {
                    "weight": "1.39"
            }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "lightness": "-19"
            }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "lightness": "46"
            }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "simplified"
            }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "lightness": "-13"
            },
                {
                    "weight": "1.23"
            },
                {
                    "invert_lightness": true
            },
                {
                    "visibility": "simplified"
            },
                {
                    "hue": "#ff0000"
            }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
            }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
            }
            ]
        },
        {
            "featureType": "water",
            "elementType": "all",
            "stylers": [
                {
                    "color": "#adadad"
            },
                {
                    "visibility": "on"
            }
            ]
        }

        ]; // END gmap styles

        var map = new google.maps.Map(document.getElementById('spproperty-property-map'), mapOptions);
        var marker = new google.maps.Marker({position: latlng, map: map});
        map.setMapTypeId(google.maps.MapTypeId.ROADMAP);

      // Set styles to map
        map.setOptions({styles: styles});

    });

});