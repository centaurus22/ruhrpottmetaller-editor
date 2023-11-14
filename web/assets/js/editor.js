
function initEditor()
{
    const cityId = getCityIdFromDataTag();
    const venueId = getVenueIdFromDataTag();
    const eventId = getEventIdFromDataTag();
    loadCityVenueContent(cityId, venueId);
    loadLineupContent(eventId);
}

function reloadCityVenueContent(citySelectElement, venueSelectElement, changedField)
{
    if (venueSelectElement !== null) {
        loadCityVenueContent(citySelectElement.value, venueSelectElement.value, changedField);
    } else {
        loadCityVenueContent(citySelectElement.value, null, changedField);
    }
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

function loadLineupContent(eventId) {
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            let lineup = document.getElementById("ajax_lineup");
            lineup.innerHTML = xmlHttp.responseText;

            for (let band of lineup.getElementsByClassName('fieldset_band')) {
                let bandLineupId = band.id.substring(5);
                let bandFirstCharSelect = document.getElementById('first_sign_' + bandLineupId)
                bandFirstCharSelect.onchange = (event) => {
                    let bandFirstChar = event.target.value;
                    let bandLineupId = event.target.id.substring(11);
                    let bandOptions = document.getElementById('band_id_' + bandLineupId);
                    updateBandSelect(bandOptions, bandId, bandFirstChar)
                }

                let bandId = band.getAttribute('data-band-id');
                let bandFirstChar = band.getAttribute('data-band-first-char');
                let bandOptions = document.getElementById('band_id_' + bandLineupId);
                updateBandSelect(bandOptions, bandId, bandFirstChar)
                bandOptions.onchange = (event) => {
                    updateBand(event);
                }
                bandOptions.dispatchEvent(new Event('change'));
            }
        }
    };
    const file = "index.php?ajax=1&content=lineup&event_id=" + eventId;
    xmlHttp.open("GET", file, true);
    xmlHttp.send();
}

function updateBandSelect(bandOptions, bandId, bandFirstChar)
{
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            bandOptions.innerHTML = xmlHttp.responseText;
        }
    };
    const file = 'index.php?ajax=1&content=band_options&band_id=' + bandId + '&band_first_char=' + bandFirstChar;
    xmlHttp.open('GET', file, true);
    xmlHttp.send();
}

function updateBand(event) {
    const bandLineupId = event.target.id.substring(8);
    const bandId = event.target.value;
    let bandNewNameInput = document.getElementById('band_new_name_' + bandLineupId);
    if (bandId === '3') {
         bandNewNameInput.style.display = 'inline-block';
    } else {
         bandNewNameInput.style.display = 'none';
    }

    const xmlHttp = new XMLHttpRequest();
    const file = 'index.php?ajax=1&command=change_gig&band_id=' + bandId;
    xmlHttp.open('GET', file, true);
    xmlHttp.send();
}

function getVenueIdFromDataTag()
{
    return document.getElementById('ajax_city_venue').getAttribute('data-venue-id');
}

function getCityIdFromDataTag()
{
    return document.getElementById('ajax_city_venue').getAttribute('data-city-id');
}

function getEventIdFromDataTag()
{
    return document.getElementById('ajax_lineup').getAttribute('data-event-id');
}

window.onload = initEditor;