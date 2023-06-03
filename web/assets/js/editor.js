function getVenueIdFromDataTag()
{
    return document.getElementById('ajax_city_venue').getAttribute('data-venue-id');
}

function getCityIdFromDataTag()
{
    return document.getElementById('ajax_city_venue').getAttribute('data-city-id');
}

function loadCityVenueContent(cityId, venueId, changedField = null)
{
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            document.getElementById("ajax_city_venue").innerHTML = xmlHttp.responseText;

            let citySelectElement = document.getElementById('city_id');
            let venueSelectElement = document.getElementById('venue_id');
            citySelectElement.onchange = () => {
                    reloadCityVenueContent(citySelectElement, null, 'city');
            }
            if (venueSelectElement !== null) {
                venueSelectElement.onchange = () => {
                    reloadCityVenueContent(citySelectElement, venueSelectElement, 'venue');
                }
            }

            if (changedField === 'city') {
                citySelectElement.focus();
            } else if (changedField === 'venue') {
                venueSelectElement.focus();
            }
        }
    };
    const file = "index.php?ajax=1&content=city_venue&venue_id=" + venueId + "&city_id=" + cityId;
    xmlHttp.open("GET", file,true);
    xmlHttp.send();
}

function reloadCityVenueContent(citySelectElement, venueSelectElement, changedField)
{
    if (venueSelectElement !== null) {
        loadCityVenueContent(citySelectElement.value, venueSelectElement.value, changedField);
    } else {
        loadCityVenueContent(citySelectElement.value, null, changedField);
    }
}

function initEditor()
{
    const cityId = getCityIdFromDataTag();
    const venueId = getVenueIdFromDataTag();
    loadCityVenueContent(cityId, venueId);
}

window.onload = initEditor;